@extends('admin::layouts.master')

@section('page_title')
    {{ __('Import Products') }}
@stop

@section('content')
    <div class="content">
        <form method="POST" action="{{ route('admin.catalog.products.import.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="csv_file">Upload CSV File</label>
                <input type="file" name="csv_file" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Import</button>
        </form>
    </div>
@stop
