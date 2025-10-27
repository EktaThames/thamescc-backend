<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webkul\Attribute\Models\Attribute;
use Webkul\Product\Repositories\ProductRepository;

class FixMissingBrandAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(ProductRepository $productRepository)
    {
        $brandAttribute = Attribute::where('code', 'brand')->first();

        if (! $brandAttribute) {
            $this->command->error('The "brand" attribute was not found. Please ensure it exists.');
            return;
        }

        // Get all attribute families that have the 'brand' attribute.
        $familyIds = DB::table('attribute_groups')
            ->join('attribute_group_mappings', 'attribute_groups.id', '=', 'attribute_group_mappings.attribute_group_id')
            ->where('attribute_group_mappings.attribute_id', $brandAttribute->id)
            ->pluck('attribute_groups.attribute_family_id')
            ->unique();

        if ($familyIds->isEmpty()) {
            $this->command->warn('The "brand" attribute is not assigned to any attribute family.');
            return;
        }

        // Get all products that belong to these families.
        $products = $productRepository->whereIn('attribute_family_id', $familyIds)->get();

        $this->command->info('Found ' . $products->count() . ' products to check and fix...');

        $productsUpdated = 0;

        foreach ($products as $product) {
            $attributeValueExists = DB::table('product_attribute_values')
                ->where('product_id', $product->id)
                ->where('attribute_id', $brandAttribute->id)
                ->exists();

            if (! $attributeValueExists) {
                DB::table('product_attribute_values')->insert([
                    'product_id'   => $product->id,
                    'attribute_id' => $brandAttribute->id,
                    'channel'      => null, // Default for non-channel specific attributes
                    'locale'       => null, // Default for non-locale specific attributes
                    'integer_value' => null, // For select attributes, this stores the option ID. Null means no option selected.
                ]);

                $this->command->line('Added missing DB entry for product ID: ' . $product->id);
            }

            // Force a re-save using the repository to ensure all related data (like product_flat) is updated.
            // Passing an empty array to update() triggers the update logic without changing existing data.
            $productRepository->update([], $product->id);
            $this->command->line('Triggered full product update for product ID: ' . $product->id . ' (SKU: ' . $product->sku . ')');
            $productsUpdated++;
        }

        $this->command->info('Process complete. ' . $productsUpdated . ' products were checked and synced.');
    }
}
