<?php

namespace Webkul\Shop\Http\Controllers\API;

use Illuminate\Http\Resources\Json\JsonResource;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Shop\Http\Resources\AttributeResource;
use Webkul\Shop\Http\Resources\CategoryResource;
use Webkul\Shop\Http\Resources\CategoryTreeResource;
use Illuminate\Support\Facades\DB;

class CategoryController extends APIController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected AttributeRepository $attributeRepository,
        protected CategoryRepository $categoryRepository,
        protected ProductRepository $productRepository
    ) {}

    /**
     * Get all categories.
     */
    public function index(): JsonResource
    {
        /**
         * These are the default parameters. By default, only the enabled category
         * will be shown in the current locale.
         */
        $defaultParams = [
            'status' => 1,
            'locale' => app()->getLocale(),
        ];

        $categories = $this->categoryRepository->getAll(array_merge($defaultParams, request()->all()));

        return CategoryResource::collection($categories);
    }

    /**
     * Get all categories in tree format.
     */
    public function tree(): JsonResource
    {
        $categories = $this->categoryRepository->getVisibleCategoryTree(core()->getCurrentChannel()->root_category_id);

        return CategoryTreeResource::collection($categories);
    }

    /**
     * Get filterable attributes for category.
     */
    public function getAttributes(): JsonResource
    {
        $filters = [];

        $categories = $this->categoryRepository->getModel()
            ->where('id', '!=', 1)
            ->get();

        $filters[] = [
            'code'    => 'category_id',
            'name'    => 'All Categories',
            'type'    => 'custom',
            'options' => $categories->map(function ($category) {
                return [
                    'id'   => $category->id,
                    'name' => $category->name,
                ];
            })->values(),
        ];

        $subtitles = DB::table('product_attribute_values as pav')
            ->join('attributes as a', 'a.id', '=', 'pav.attribute_id')
            ->where('a.code', 'custom_product_subtitle')
            ->whereNotNull('pav.text_value')
            ->distinct()
            ->pluck('pav.text_value')
            ->filter()
            ->values();

        if ($subtitles->isNotEmpty()) {
            $filters[] = [
                'code'    => 'custom_product_subtitle',
                'name'    => 'Sizes',
                'type'    => 'custom',
                'options' => $subtitles->map(fn($value) => ['id' => $value, 'name' => $value]),
            ];
        }

        $filters[] = [
            'code'    => 'offer_title',
            'name'    => 'Offer',
            'type'    => 'custom',
            'options' => collect([
                ['id' => 'pmp',        'name' => 'PMP'],
                ['id' => 'promotion',  'name' => 'PROMOTION'],
                ['id' => 'clearance',  'name' => 'CLEARANCE'],
            ]),
        ];

        if (! request('category_id')) {
            $filterableAttributes = $this->attributeRepository->getFilterableAttributes();
        } else {
            $category = $this->categoryRepository->findOrFail(request('category_id'));
            $filterableAttributes = $category->filterableAttributes ?: $this->attributeRepository->getFilterableAttributes();
        }

        foreach ($filterableAttributes as $attribute) {
            $filters[] = (new \Webkul\Shop\Http\Resources\AttributeResource($attribute))->toArray(request());
        }

        return new JsonResource($filters);
    }

    /**
     * Get product maximum price.
     */
    public function getProductMaxPrice($categoryId = null): JsonResource
    {
        $maxPrice = $this->productRepository->getMaxPrice(['category_id' => $categoryId]);

        return new JsonResource([
            'max_price' => core()->convertPrice($maxPrice),
        ]);
    }
}
