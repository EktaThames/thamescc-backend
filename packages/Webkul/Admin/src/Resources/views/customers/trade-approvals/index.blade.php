<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.customers.trade-approvals.title')
    </x-slot:title>

    <div class="flex justify-between items-center">
        <p class="text-[20px] text-gray-800 dark:text-white font-bold">
            @lang('admin::app.customers.trade-approvals.title')
        </p>
    </div>

    {{-- DataGrid --}}
    <x-admin::datagrid :src="route('admin.customers.trade-approvals.index')" />
</x-admin::layouts>
