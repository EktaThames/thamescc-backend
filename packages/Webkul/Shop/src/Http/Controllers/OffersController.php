<?php

namespace Webkul\Shop\Http\Controllers;

use Webkul\Product\Models\ProductFlat;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Webkul\Product\Helpers\Toolbar;

class OffersController extends Controller
{
    public function index()
    {
        $toolbar = app(Toolbar::class);

        $params = request()->all();

        $order = $toolbar->getOrder($params ?? []);

        $limit = $toolbar->getLimit($params ?? []);

        $offers = ProductFlat::with(['product', 'product.images', 'product.reviews'])
            ->whereNotNull('priority')
            ->where('status', 1)
            ->where('visible_individually', 1)
            ->where('channel', core()->getCurrentChannelCode())
            ->where('locale', app()->getLocale())
            ->orderBy($order['sort'], $order['order'])
            ->paginate($limit);

        $initialProducts = $offers->getCollection()->map(function ($flat) {
            $product = $flat->product;
            $productTypeInstance = $flat->getTypeInstance();

            $baseImage = product_image()->getProductBaseImage($product) ?: [
                'small_image_url'    => bagisto_asset('images/small-product-placeholder.webp', 'shop'),
                'medium_image_url'   => bagisto_asset('images/medium-product-placeholder.webp', 'shop'),
                'large_image_url'    => bagisto_asset('images/large-product-placeholder.webp', 'shop'),
                'original_image_url' => bagisto_asset('images/large-product-placeholder.webp', 'shop'),
            ];

            return [
                'id'          => $product?->id ?? $flat->id,
                'sku'         => $flat->sku,
                'name'        => $flat->name,
                'description' => $flat->description,
                'url_key'     => $flat->url_key,

                'base_image'  => $baseImage,
                'images'      => product_image()->getGalleryImages($product),

                'is_new'      => (bool) $flat->new,
                'is_featured' => (bool) $flat->featured,
                'on_sale'     => (bool) $productTypeInstance->haveDiscount(),
                'is_saleable' => (bool) $productTypeInstance->isSaleable(),

                'is_wishlist' => (bool) auth()->guard()->user()?->wishlist_items
                    ->where('channel_id', core()->getCurrentChannel()->id)
                    ->where('product_id', $product?->id ?? $flat->id)
                    ->count(),

                'min_price'   => core()->formatPrice($productTypeInstance->getMinimalPrice()),
                'prices'      => $productTypeInstance->getProductPrices(),
                'price_html'  => $productTypeInstance->getPriceHtml(),

                'ratings'     => [
                    'average' => app(\Webkul\Product\Helpers\Review::class)->getAverageRating($product),
                    'total'   => app(\Webkul\Product\Helpers\Review::class)->getTotalRating($product),
                ],
                'reviews'     => [
                    'total'   => app(\Webkul\Product\Helpers\Review::class)->getTotalReviews($product),
                ],
            ];
        })->values();


        return view('shop::offers.index', [
            'offers'           => $offers,
            'initialProducts'  => $initialProducts,
        ]);
    }


    public function downloadPdf()
{
    $user = auth()->guard()->user();

    // Restrict access to only wholesale customers
    if (! $user || $user->customer_group_id != 3) {
        abort(403, 'You are not authorized to download this file.');
    }

    $products = $this->getOfferProducts();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('shop::offers.pdf', compact('products'));

    return $pdf->download('special-offers.pdf');
}

    private function getOfferProducts()
{
    $products = ProductFlat::with(['product', 'product.images'])
        ->select([
            'id',
            'sku',
            'name',
            'price',
            'por_percentage',
            'rrp_price',
            'custom_product_subtitle',
            'product_id',
        ])
        ->whereNotNull('priority')
        ->where('status', 1)
        ->where('visible_individually', 1)
        ->where('channel', core()->getCurrentChannelCode())
        ->where('locale', app()->getLocale())
        ->orderBy('priority')
        ->get();

    foreach ($products as $product) {
        // Get product base image record
        $imageData = $product->product?->images?->first();

        $imagePath = null;

        if ($imageData && !empty($imageData->path)) {
            $imagePath = \Illuminate\Support\Facades\Storage::disk('public')->path($imageData->path);
        }

        // If the primary image doesn't exist, use the local placeholder
        if (! $imagePath || ! file_exists($imagePath)) {
            $imagePath = public_path('vendor/webkul/ui/assets/images/product/large-product-placeholder.png');
        }

        // Encode the final image path (either product image or placeholder) to Base64
        if (file_exists($imagePath)) {
            $mimeType = mime_content_type($imagePath);
            $base64 = base64_encode(file_get_contents($imagePath));
            $product->base64_image = 'data:' . $mimeType . ';base64,' . $base64;
        } else {
            $product->base64_image = ''; // Should not happen if placeholder exists
        }
    }

    return $products;
}

}
