<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Webkul\DataTransfer\Repositories\ImportRepository;
use Webkul\DataTransfer\Helpers\Import;
use Illuminate\Support\Facades\Event;
use Webkul\Product\Models\ProductImage;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;
use League\Csv\Exception;
use Webkul\Product\Models\Product;
use Illuminate\Support\Facades\Log;

class ImportProductsDaily extends Command
{
    protected $signature = 'import:products-daily';
    protected $description = 'Import products from CSV file daily';

    public function __construct(
        protected ImportRepository $importRepository,
        protected Import $importHelper
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $filePath = 'imports/products.csv';
        $fullPath = storage_path('app/private/' . $filePath);


        if (!file_exists($fullPath)) {
            $this->error("CSV file not found at: $fullPath");
            return Command::FAILURE;
        }

        $import = $this->importRepository->create([
            'type' => 'products',
            'action' => 'append',
            'validation_strategy' => 'skip-errors',
            'allowed_errors' => 100,
            'field_separator' => ',',
            'process_in_queue' => false,
            'file_path' => $filePath,
            'state' => Import::STATE_PENDING,
        ]);
        $import->refresh();

        $this->info("Import record created: ID {$import->id}");

        Event::dispatch('data_transfer.imports.create.after', $import);


        $this->importHelper->setImport($import);

        $import->refresh();

        if (!$this->importHelper->validate()) {
            $this->error("Validation failed.");
            return Command::FAILURE;
        }

        $this->info("Import validated successfully.");



        if ($import->state === \Webkul\DataTransfer\Helpers\Import::STATE_PENDING) {
            $this->importHelper->started();
        }

        $import->refresh();

        // Create batches
        $importBatch = $import->batches->where('state', \Webkul\DataTransfer\Helpers\Import::STATE_PENDING)->first();

        try {
            if ($importBatch) {
                $this->importHelper->start($importBatch);
                $this->info("Import batch started.");
            } else {
                $this->info("No pending batch to import.");
            }
        } catch (\Exception $e) {
            $this->error("Error in importing batch: " . $e->getMessage());
            return Command::FAILURE;
        }

        $import->refresh();

        // Linking
        if ($this->importHelper->isLinkingRequired()) {
            $this->importHelper->linking();
            $importBatch = $import->batches->where('state', \Webkul\DataTransfer\Helpers\Import::STATE_PROCESSED)->first();

            if ($importBatch) {
                try {
                    $this->importHelper->link($importBatch);
                    $this->info("Linking completed.");
                } catch (\Exception $e) {
                    $this->error("Error during linking: " . $e->getMessage());
                    return Command::FAILURE;
                }
            }
        }

        $import->refresh();

        // Indexing
        if ($this->importHelper->isIndexingRequired()) {
            $this->importHelper->indexing();
            $importBatch = $import->batches->where('state', \Webkul\DataTransfer\Helpers\Import::STATE_LINKED)->first();

            if ($importBatch) {
                try {
                    $this->importHelper->index($importBatch);
                    $this->info("Indexing completed.");
                } catch (\Exception $e) {
                    $this->error("Error during indexing: " . $e->getMessage());
                    return Command::FAILURE;
                }
            }
        }
        $import->refresh();
        // Complete import

        $this->importHelper->completed();
        $this->info("Import process completed successfully.");

        $import->refresh();

        $this->importHelper->stats(\Webkul\DataTransfer\Helpers\Import::STATE_INDEXED);

        // Check for missing images
        $missingImages = [];

        try {
            $csv = Reader::createFromPath($fullPath, 'r');
            $csv->setHeaderOffset(0);
            $records = $csv->getRecords();

            foreach ($records as $record) {
                if (!isset($record['images'])) {
                    continue;
                }

                $imagePaths = explode(',', $record['images']);

                foreach ($imagePaths as $imgPath) {
                    $imgPath = trim($imgPath);
                    if (empty($imgPath)) {
                        continue;
                    }

                    $imageRelativePath = 'imports/images/' . ltrim($imgPath, '/');

                    if (!Storage::disk('private')->exists($imageRelativePath)) {
                        $missingImages[] = $imgPath;
                        Log::warning("Missing image: {$imgPath} for SKU: {$record['sku']}");
                    }
                }
            }

            if (!empty($missingImages)) {
                $this->warn("Some product images are missing:");
                foreach ($missingImages as $img) {
                    $this->line("- $img");
                }
                Log::warning("Missing product images detected", $missingImages);
            } else {
                $this->info("All images referenced in the CSV are present.");
                Log::info("All images in CSV are present.");
            }

            foreach ($records as $record) {
                $sku = $record['sku'] ?? null;
                if (!$sku) {
                    continue;
                }

                $product = Product::where('sku', $sku)->first();
                if (!$product) {
                    $this->warn("Product with SKU {$sku} not found.");
                    Log::warning("No product found for SKU: {$sku}");
                    continue;
                }

                if (!isset($record['images'])) {
                    continue;
                }

                $imagePaths = explode(',', $record['images']);

                foreach ($imagePaths as $imgPath) {
                    $imgPath = trim($imgPath);
                    if (empty($imgPath)) {
                        continue;
                    }

                    $sourceImagePath = storage_path('app/private/imports/images/' . ltrim($imgPath, '/'));
                    $destinationPath = storage_path('app/public/catalog/products/');

                    if (!File::exists($sourceImagePath)) {
                        continue;
                    }

                    if (!File::exists($destinationPath)) {
                        File::makeDirectory($destinationPath, 0755, true);
                    }

                    $destinationFileName = basename($imgPath);
                    $destinationFilePath = $destinationPath . $destinationFileName;

                    File::copy($sourceImagePath, $destinationFilePath);

                    Log::info("Copied image for SKU {$sku}: {$destinationFileName}");

                    $exists = ProductImage::where('product_id', $product->id)
                        ->where('path', 'catalog/products/' . $destinationFileName)
                        ->exists();

                    if (!$exists) {
                        ProductImage::create([
                            'product_id' => $product->id,
                            'path' => 'catalog/products/' . $destinationFileName,
                            'type' => 'image',
                            'sort_order' => 0,
                        ]);

                        Log::info("Image record created for SKU {$sku}: {$destinationFileName}");
                    }
                }
            }
        } catch (Exception $e) {
            $this->error("Failed to parse CSV for image check: " . $e->getMessage());
            Log::error("CSV image validation error: " . $e->getMessage());
        }

        return Command::SUCCESS;
    }
}
