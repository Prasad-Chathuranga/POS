@extends('layouts.app')

@section('title', 'Product Categories')
@section('active', 'New')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">Stock Management</a></li>
    <li class="breadcrumb-item"><a href="{{ route('product-categories.index') }}">Product Categories</a></li>
@endsection

@section('content')
    <!-- ============================================================== -->
    <!-- basic form  -->
    <!-- ============================================================== -->
    <div class="row" ng-controller="ProductCategoryController">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="m-0 pt-1">{{ isset($model) ? 'Edit Product Category' : 'New Product Category' }}</h5>
                    <div class="widget-bar ml-auto">
                        <a type="button" ng-click="save()" class="btn btn-success btn-sm text-light">Save</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-6 pl-0">
                        <form name="dataForm" novalidate>
                            <div class="form-group">
                                <label for="name" class="col-form-label required">Category Name</label>
                                <input id="name" name="name" ng-model="data.name" ng-class="{'is-invalid' : submitted && dataForm.name.$invalid}" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" ng-model="data.active" ng-true-value='1' ng-false-value='0' ng-class="{'is-invalid' : submitted && dataForm.active.$invalid}" name="active" id="active" class="custom-control-input"><span
                                        class="custom-control-label">Active</span>
                                </label>
                            </div>
                            <input type="hidden" ng-init="url='{{route('product-categories.index')}}';" />
                            @if(isset($model))
                                <input type="hidden" ng-init="init({{$model}})" />
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
<script src="{{asset('assets/libs/js/angular/product-category.js')}}"></script>
@endsection
