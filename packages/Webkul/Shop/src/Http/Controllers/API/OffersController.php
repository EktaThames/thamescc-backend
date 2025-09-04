<?php
namespace Webkul\Shop\Http\Controllers\API;

use Webkul\Product\Repositories\ProductRepository;
use Webkul\Shop\Http\Controllers\Controller;

class OffersController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getOffers()
    {
        // Fetch products with priority > 0 and order by priority
        $offers = $this->productRepository
            ->getModel()
            ->whereNotNull('priority')
            ->orderBy('priority', 'asc')
            ->paginate(12); // paginate for grid

        return response()->json($offers);
    }
}
