<?php

namespace Webkul\Admin\DataGrids\Customers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Webkul\DataGrid\DataGrid;

class CustomerDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function prepareQueryBuilder()
{
    $queryBuilder = DB::table('customers')
        ->leftJoin('customer_groups', 'customers.customer_group_id', '=', 'customer_groups.id')
        ->addSelect(
            'customers.id',
            'customers.email',
            'customer_groups.name as group',
            'customers.phone',
            'customers.gender',
            'customers.status',
            'customers.is_suspended',
            DB::raw('CONCAT(' . DB::getTablePrefix() . 'customers.first_name, " ", ' . DB::getTablePrefix() . 'customers.last_name) as full_name')
        );

    // ✅ Filter only wholesale customers pending approval
    if (Route::currentRouteName() === 'admin.customers.trade-approvals.index') {
        $queryBuilder->where('customers.customer_group_id', 3)
                     ->where('customers.status', 0);
    }

    // Add filters
    $this->addFilter('id', 'customers.id');
    $this->addFilter('full_name', DB::raw('CONCAT(' . DB::getTablePrefix() . 'customers.first_name, " ", ' . DB::getTablePrefix() . 'customers.last_name)'));
    $this->addFilter('group', 'customer_groups.name');
    $this->addFilter('email', 'customers.email');
    $this->addFilter('phone', 'customers.phone');
    $this->addFilter('gender', 'customers.gender');
    $this->addFilter('status', 'customers.status');
    $this->addFilter('is_suspended', 'customers.is_suspended');

    return $queryBuilder;
}


    /**
     * Add columns.
     *
     * @return void
     */
    public function prepareColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('admin::app.customers.customers.index.datagrid.id'),
            'type'       => 'integer',
            'searchable' => false,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'full_name',
            'label'      => trans('admin::app.customers.customers.index.datagrid.name'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'email',
            'label'      => trans('admin::app.customers.customers.index.datagrid.email'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'group',
            'label'      => trans('admin::app.customers.customers.index.datagrid.group'),
            'type'       => 'string',
            'searchable' => false,
            'filterable' => true,
            'sortable'   => true,
            'closure'    => function ($row) {
                return $row->group;
            },
            'hidden'     => Route::currentRouteName() === 'admin.customers.trade-approvals.index',
        ]);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        if (Route::currentRouteName() == 'admin.customers.trade-approvals.index') {
            $this->addAction([
                'icon'   => 'icon-view',
                'title'  => trans('admin::app.customers.customers.index.datagrid.view'),
                'method' => 'GET',
                'url'    => function ($row) {
                    return route('admin.customers.customers.view', $row->id);
                },
            ]);

            $this->addAction([
                'icon'   => 'icon-tick',
                'title'  => trans('admin::app.customers.trade-approvals.approve'),
                'method' => 'POST',
                'url'    => function ($row) {
                    return route('admin.customers.trade-approvals.approve', $row->id);
                },
            ]);

            $this->addAction([
                'icon'   => 'icon-cross',
                'title'  => trans('admin::app.customers.trade-approvals.reject'),
                'method' => 'POST',
                'url'    => function ($row) {
                    return route('admin.customers.trade-approvals.reject', $row->id);
                },
            ]);
        } else {
            $this->addAction([
                'icon'   => 'icon-view',
                'title'  => trans('admin::app.customers.customers.index.datagrid.view'),
                'method' => 'GET',
                'url'    => function ($row) {
                    return route('admin.customers.customers.view', $row->id);
                },
            ]);
        }
    }
}
