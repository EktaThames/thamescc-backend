<?php
namespace Webkul\Shop\Http\Controllers;

use Webkul\Product\Models\ProductFlat;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class OffersController extends Controller
{
    public function index()
{
    $offers = ProductFlat::with(['product', 'product.images', 'product.reviews'])
        ->whereNotNull('priority')
        ->where('status', 1)
        ->where('visible_individually', 1)
        ->where('channel', core()->getCurrentChannelCode())
        ->where('locale', app()->getLocale())
        ->orderBy('priority')
        ->paginate(12);

    return view('shop::offers.index', compact('offers'));
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
