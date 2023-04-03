@extends('layouts.app')

@section('title', 'Products')
@section('active', 'New')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">Stock Management</a></li>
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
@endsection

@section('content')
    <!-- ============================================================== -->
    <!-- basic form  -->
    <!-- ============================================================== -->
    <div class="row" ng-controller="ProductsController">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="m-0 pt-1">{{ isset($model) ? 'Edit Product' : 'New Product' }}</h5>
                    <div class="widget-bar ml-auto">
                        <a type="button" ng-click="save()" class="btn btn-success btn-sm text-light">Save</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-6 col-md-6 pl-0">
                        <form name="dataForm" novalidate>
                            <div class="form-group">
                                <label for="name" class="col-form-label required">Product Category</label>
                                <select class="select2 form-control form-control-lg" id="product_categories" 
                                    name="product_category">
                                    <option></option>
                                </select>
                                <div class="form-group pt-3">
                                    <label for="name" class="col-form-label required">Product Name</label>
                                    <input id="name" name="name" class="form-control form-control-sm"
                                        ng-model="data.name" ng-class="{'is-invalid' : submitted && dataForm.name.$invalid}"
                                        type="text">
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-form-label required">SOH</label>
                                    <input id="name" name="soh" class="form-control form-control-sm"
                                        ng-model="data.soh" ng-class="{'is-invalid' : submitted && dataForm.soh.$invalid}"
                                        type="text">
                                </div>

                                <div class="form-group">
                                    <label for="name" class="col-form-label required">Price</label>
                                    <input id="name" name="soh" class="form-control form-control-sm"
                                        ng-model="data.price" ng-class="{'is-invalid' : submitted && dataForm.price.$invalid}"
                                        type="text">
                                </div>

                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" ng-model="data.allow_price_change" ng-true-value='1'
                                            ng-false-value='0'
                                            ng-class="{'is-invalid' : submitted && dataForm.allow_orice_change.$invalid}"
                                            name="active" id="active" class="custom-control-input"><span
                                            class="custom-control-label">Allow Price Change</span>
                                    </label>
                                </div>


                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" ng-model="data.discounatble" ng-true-value='1'
                                            ng-false-value='0'
                                            ng-class="{'is-invalid' : submitted && dataForm.discounatble.$invalid}"
                                            name="active" id="active" class="custom-control-input"><span
                                            class="custom-control-label">Discounatble</span>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" ng-model="data.can_delete" ng-true-value='1'
                                            ng-false-value='0'
                                            ng-class="{'is-invalid' : submitted && dataForm.can_delete.$invalid}"
                                            name="active" id="active" class="custom-control-input"><span
                                            class="custom-control-label">Can Delete</span>
                                    </label>
                                </div>


                                <input type="hidden"
                                    ng-init="url='{{ route('products.index') }}'; all_product_categories='{{ route('all_product_categories') }}'; init_select2_product_categories();" />
                                @if (isset($model))
                                    <input type="hidden" ng-init="init({{ $model }})" />
                                @endif
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end basic form  -->
    <!-- ============================================================== -->
@endsection
@section('script')
    <script src="{{ asset('assets/libs/js/angular/products.js') }}"></script>

@endsection
