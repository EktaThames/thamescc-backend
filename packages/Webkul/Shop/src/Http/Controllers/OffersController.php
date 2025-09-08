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
        $products = $this->getOfferProducts();

        $pdf = PDF::loadView('shop::offers.pdf', compact('products'));

        return $pdf->download('special-offers.pdf');
    }

    private function getOfferProducts()
    {
        return ProductFlat::with(['product', 'product.images', 'product.reviews'])
            ->whereNotNull('priority')
            ->where('status', 1)
            ->where('visible_individually', 1)
            ->where('channel', core()->getCurrentChannelCode())
            ->where('locale', app()->getLocale())
            ->orderBy('priority')
            ->get(); // no pagination for PDF
    }
}
