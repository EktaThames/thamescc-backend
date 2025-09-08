<?php
namespace Webkul\Shop\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;
use Webkul\Product\Models\ProductFlat;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\Product\Helpers\Review;

class OffersController extends Controller
{
    public function getOffers(): JsonResponse
    {
        $limit = (int) (request('limit') ?: 12);

        $offers = ProductFlat::with(['product', 'product.images', 'product.reviews'])
            ->whereNotNull('priority')
            ->where('status', 1)
            ->where('visible_individually', 1)
            ->where('channel', core()->getCurrentChannelCode())
            ->where('locale', app()->getLocale())
            ->orderBy('priority')
            ->paginate($limit)
            ->appends(request()->query());

        $reviewHelper = app(Review::class);

        $transformed = $offers->getCollection()->map(function ($flat) use ($reviewHelper) {
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
                    ->where('product_id', $flat->id)
                    ->count(),
                'min_price'   => core()->formatPrice($productTypeInstance->getMinimalPrice()),
                'prices'      => $productTypeInstance->getProductPrices(),
                'price_html'  => $productTypeInstance->getPriceHtml(),
                'ratings'     => [
                    'average' => $reviewHelper->getAverageRating($product),
                    'total'   => $reviewHelper->getTotalRating($product),
                ],
                'reviews'     => [
                    'total'   => $reviewHelper->getTotalReviews($product),
                ],
            ];
        });

        $payload = [
            'data'  => $transformed,
            'links' => [
                'first' => $offers->url(1),
                'last'  => $offers->url($offers->lastPage()),
                'prev'  => $offers->previousPageUrl(),
                'next'  => $offers->nextPageUrl(),
            ],
            'meta'  => [
                'current_page' => $offers->currentPage(),
                'from'         => $offers->firstItem(),
                'last_page'    => $offers->lastPage(),
                'path'         => URL::current(),
                'per_page'     => $offers->perPage(),
                'to'           => $offers->lastItem(),
                'total'        => $offers->total(),
            ],
        ];

        return response()->json($payload);
    }
}
