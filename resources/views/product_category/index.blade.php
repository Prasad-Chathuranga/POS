@extends('layouts.app')

@section('title', 'Product Categories')
@section('active', 'Product Categories')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Stock Management</a>
    </li>
@endsection

@section('content')
    <div class="row" ng-controller="ProductCategoryController">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="m-0 pt-1">Product Categories</h5>
                    <div class="widget-bar ml-auto">
                        <a type="button" href="{{ route('product-categories.create') }}"
                            class="btn btn-primary btn-sm text-light">New</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 6%">Actions</th>
                                <th style="width: 3%">#</th>
                                <th>Name</th>
                                <th>SOH</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $key => $category)
                                <tr>
                                    <td>
                                        <a href="{{ route('product-categories.edit', $category->id) }}"><i
                                                class="fas fa-pencil-alt text-info"></i></a>
                                        <i ng-click="delete({{ $category->id }})" role="button"
                                            class="fas fas fa-trash-alt text-danger ml-1"></i>

                                    </td>
                                    <td>{{$key+1}}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->soh }}</td>
                                    <td>
                                        @if ($category->active)
                                            <label class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </label></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <input type="hidden" ng-init="url='{{ route('product-categories.index') }}';" />
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end basic form  -->
    <!-- ============================================================== -->
@endsection
@section('script')
    <script>
        $(() => {
            $('table').dataTable({
                "deferRender": true,
                language: {
                    search: 'Search',
                    paginate: {
                        previous: 'Prev'
                    }
                },
                'pageLength': 25,
                "columnDefs": [{
                    "orderable": false,
                    "targets": 0
                }],
                "order": [1, 'asc']
            });
        });
    </script>
    <script src="{{ asset('assets/libs/js/angular/product-category.js') }}"></script>
@endsection
