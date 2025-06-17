<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webkul\Customer\Models\Customer;
use Webkul\Product\Models\Product;
use Webkul\Customer\Models\Wishlist;
use League\Csv\Reader;
use Illuminate\Support\Facades\Log;

class ImportWishlistFromCSV extends Command
{
    protected $signature = 'import:wishlist';
    protected $description = 'Import wishlist items from CSV and save them in Bagisto';

    public function handle(): int
    {
        $filePath = storage_path('app/private/imports/wishlist_export.csv');

        try {
            $csv = Reader::createFromPath($filePath, 'r');
            $csv->setHeaderOffset(0);

            foreach ($csv->getRecords() as $record) {

                $email = trim($record['customer_email']);
                $sku = trim($record['product_sku']);
                $customer = Customer::where('email', $email)->first();
                if (!$customer) {
                    $this->warn("Customer not found: $email");
                    continue;
                }

                $product = Product::where('sku', $sku)->first();
                if (!$product) {
                    $this->warn("Product not found: $sku");
                    continue;
                }

                $existing = Wishlist::where('customer_id', $customer->id)
                    ->where('product_id', $product->id)
                    ->first();

                if ($existing) {
                    $this->info("Already in wishlist: $email -> $sku");
                    continue;
                }

                Wishlist::create([
                    'channel_id' => core()->getCurrentChannel()->id,
                    'customer_id' => $customer->id,
                    'product_id' => $product->id,
                ]);

                $this->info("Wishlist added: $email -> $sku");
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            Log::error('Wishlist import error: ' . $e->getMessage());
            return 1;
        }

        $this->info('Wishlist import completed.');
        return 0;
    }
}
