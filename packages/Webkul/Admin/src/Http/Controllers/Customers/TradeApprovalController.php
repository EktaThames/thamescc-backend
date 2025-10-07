<?php

namespace Webkul\Admin\Http\Controllers\Customers;

use Illuminate\Http\JsonResponse;
use Webkul\Admin\DataGrids\Customers\CustomerDataGrid;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Customer\Repositories\CustomerRepository;

class TradeApprovalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct(protected CustomerRepository $customerRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return datagrid(CustomerDataGrid::class)->process();
        }

        return view('admin::customers.trade-approvals.index');
    }

    /**
     * Approve the trade customer.
     */
    public function approve(int $id): JsonResponse
    {
        try {
            $this->customerRepository->update([
                'status' => 1,
            ], $id);

            return new JsonResponse([
                'message' => trans('admin::app.customers.trade-approvals.approve-success'),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => trans('admin::app.customers.trade-approvals.approve-failed'),
            ], 500);
        }
    }

    /**
     * Reject the trade customer.
     */
    public function reject(int $id): JsonResponse
    {
        try {
            $this->customerRepository->update(
                ['status' => 2], // 2 for rejected
                $id
            );

            return new JsonResponse([
                'message' => trans('admin::app.customers.trade-approvals.reject-success'),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => trans('admin::app.customers.trade-approvals.reject-failed'),
            ], 500);
        }
    }
}
