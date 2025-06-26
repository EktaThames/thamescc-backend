<?php

namespace Webkul\Admin\Http\Controllers\Catalog;

use Illuminate\Http\Request;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Product\Repositories\ProductRepository;
use League\Csv\Reader;
use League\Csv\Statement;
use Illuminate\Support\Facades\Log;

class ProductImportController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function showImportForm()
    {
        return view('admin::catalog.products.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        $csv = Reader::createFromPath($request->file('csv_file')->getRealPath(), 'r');
        $csv->setHeaderOffset(0); // Use first row as header
        $records = (new Statement())->process($csv);

        foreach ($records as $record) {
            try {
                $sku = trim($record['sku']);
                $product = $this->productRepository->findOneWhere(['sku' => $sku]);

                $data = [
                    'sku'                => $sku,
                    'type'               => $record['type'] ?? 'simple',
                    'attribute_family_id'=> 1,
                    'name'               => $record['name'] ?? 'Unnamed',
                    'price'              => $record['Sell 1'] ?? 0,
                    'weight'             => $record['Product pack 1 weight'] ?? 1,
                    'status'             => 1,
                    'qty'                => $record['qty_in_stock'] ?? 0,
                ];

                if ($product) {
                    $this->productRepository->update($data, $product->id);
                } else {
                    $this->productRepository->create($data);
                }

            } catch (\Exception $e) {
                Log::error("CSV Import Error: " . $e->getMessage());
                continue;
            }
        }

        return redirect()
            ->route('admin.catalog.products.index')
            ->with('success', 'CSV Imported Successfully!');
    }
}
