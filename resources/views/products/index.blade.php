@extends('layouts.app')

@section('title', 'Products')
@section('active', 'Products')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Stock Management</a>
    </li>
@endsection

@section('content')
    <div class="row" ng-controller="ProductsController">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="m-0 pt-1">Products</h5>
                    <div class="widget-bar ml-auto">
                        <a type="button" href="{{ route('products.create') }}"
                            class="btn btn-primary btn-sm text-light">New</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 6%">Actions</th>
                                <th style="width: 3%">#</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>SOH</th>
                                <th>Price</th>
                                <th>Active</th>
                                <th>Discountable</th>
                                <th>Allow Price Change</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td>
                                        <a href="{{ route('products.edit', $product->id) }}"><i
                                                class="fas fa-pencil-alt text-info"></i></a>
                                        <i ng-click="delete({{ $product->id }})" role="button"
                                            class="fas fas fa-trash-alt text-danger ml-1"></i>

                                    </td>
                                    <td>{{$key+1}}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->soh }}</td>
                                    <td>{{ number_format($product->price, 2) }}</td>
                                    <td>
                                        @if($product->active)
                                            <label class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </label></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->discountable)
                                            <label class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </label></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->allow_price_change)
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
                <input type="hidden" ng-init="url='{{ route('products.index') }}';" />
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
    <script src="{{ asset('assets/libs/js/angular/products.js') }}"></script>
@endsection
