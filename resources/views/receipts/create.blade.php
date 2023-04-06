@extends('layouts.app')

@section('title', 'Products')
@section('active', 'New')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">Receipt Management</a></li>
    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Receipts</a></li>
@endsection

@section('content')
    <!-- ============================================================== -->
    <!-- basic form  -->
    <!-- ============================================================== -->
    <div class="row" ng-controller="ReceiptsController">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="m-0 pt-1">New Receipt</h5>
                    <div class="widget-bar ml-auto">
                        <a type="button" ng-click="save()" class="btn btn-success btn-sm text-light">Save</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-12 col-md-12 pl-0">
                        <form name="dataForm" novalidate>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label required">Product Category</label>
                                        <select class="select2 form-control form-control-lg" id="product_categories" 
                                            name="product_category">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label required">Product</label>
                                        <select class="select2 form-control form-control-lg" id="products" 
                                            name="product">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                        <div class="form-group">
                            <table class="table table-bordered table-responsive-sm">

                                <thead>

                                    <tr>

                                        <th>Item</th>

                                        <th style="width: 150px;">Price</th>

                                        <th style="width: 175px;">Quantity</th>

                                        <th style="width: 250px;" colspan="2">Discount</th>

                                        <th style="width: 150px;">Gross Total</th>

                                        <th style="width: 70px;"></th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <tr ng-repeat="(key,product) in data.products">

                                        <td><p> @{{product.name}}</p>

                                        {{-- <input type="hidden" name="categoryItem_id" ng-model="data.categoryItem_id">

                                        <input type="hidden" name="price" ng-model="data.price"> --}}

                                        </td>

                                        <td class="text-right" ng-if="product.allow_price_change != 1">@{{product.price | number : 2}}</td>

                                        <td  ng-show="product.allow_price_change == 1">

                                            <input type="number" required maxlength="200"

                                            ng-class="{'is-invalid' : submitted && dataForm.price.$invalid}"

                                            ng-model="product.price" class="form-control allow_numeric" ng-change="calculateTotal()" />

                                        </td>

                                        <td>

                                            <input type="number" required maxlength="200"

                                            ng-class="{'is-invalid' : submitted && dataForm.quantity.$invalid}"

                                            ng-model="product.quantity" class="form-control allow_numeric" ng-change="calculateTotal()" />

                                        </td>

                                        {{-- <td class="text-right">@{{item.discount_display_info}}</td> --}}

                                        <td ng-if="!product.discountable">

                                            Fixed

                                        </td>
                                        <td ng-if="product.discountable">

                                            <input type="number" ng-model="product.discount" class="form-control allow_numeric" ng-change="calculateTotal()">

                                        </td>
                                        <td ng-if="!product.discountable">

                                            Fixed

                                        </td>

                                        <td>

                                         

                                            {{--  <label ng-if="item.discountType==1">%</label> --}}

                                            <select ng-show="product.discountable" ng-model="product.discount_type" class="form-control" ng-change="calculateTotal()">
                                                <option ng-value="2">Fixed</option>

                                                <option ng-value="1">%</option>

                                            </select>

                                        </td>

                                        <td class="text-right">@{{item.total_display | number : 2}}</td>

                                        <td>

                                            <div class="button-list">

                                                <button type="button" ng-click="removeProduct(key)" class="btn btn-round btn-danger-rgba"><i class="fa fa-trash"></i></button>

                                            </div>

                                        </td>

                                    </tr>

                                </tbody>

                                <tfoot>

                                    <tr>

                                        <th colspan="5" class="text-right"><strong>Sub Total</strong></th>

                                        <th class="text-right">@{{data.gross_total | number : 2}}</th>

                                        <th></th>

                                    </tr>



                                    <tr>

                                        <th colspan="5" class="text-right"><strong>Discount</strong></th>

                                        <th class="text-right">@{{data.total_discount | number : 2}}</th>

                                        <th></th>

                                    </tr>



                                    <tr>

                                        <th colspan="5" class="text-right"><strong>Handling Fee</strong></th>

                                        <th class="text-right">

                                            <input type="text" ng-model="data.handling_fee" class="form-control allow_numeric" ng-change="calculateTotal()">

                                        </th>

                                        <th></th>

                                    </tr>



                                    <tr>

                                        <th colspan="5" class="text-right"><strong>Total</strong></th>

                                        <th class="text-right">@{{data.sub_total | number : 2}}</th>

                                        <th></th>

                                    </tr>

                                </tfoot>

                            </table>
                        </div>

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
                                        <input type="checkbox" ng-model="data.discountable" ng-true-value='1'
                                            ng-false-value='0'
                                            ng-class="{'is-invalid' : submitted && dataForm.discountable.$invalid}"
                                            name="discountable" id="discountable" class="custom-control-input"><span
                                            class="custom-control-label">Discountable</span>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" ng-model="data.can_delete" ng-true-value='1'
                                            ng-false-value='0'
                                            ng-class="{'is-invalid' : submitted && dataForm.can_delete.$invalid}"
                                            name="can_delete" id="can_delete" class="custom-control-input"><span
                                            class="custom-control-label">Can Delete</span>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" ng-model="data.allow_price_change" ng-true-value='1'
                                            ng-false-value='0'
                                            ng-class="{'is-invalid' : submitted && dataForm.allow_price_change.$invalid}"
                                            name="allow_price_change" id="allow_price_change" class="custom-control-input"><span
                                            class="custom-control-label">Allow Price Change</span>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" ng-model="data.active" ng-true-value='1'
                                            ng-false-value='0'
                                            ng-class="{'is-invalid' : submitted && dataForm.active.$invalid}"
                                            name="active" id="active" class="custom-control-input"><span
                                            class="custom-control-label">Active</span>
                                    </label>
                                </div>


                                <input type="hidden"
                                    ng-init="url='{{ route('orders.index') }}'; all_product_categories='{{ route('all_product_categories') }}'; init_select2_product_categories();" />
                                {{-- @if (isset($model))
                                    <input type="hidden" ng-init="init({{ $model }}); init_select2_product_categories();" />
                                @endif --}}
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
    <script src="{{ asset('assets/libs/js/angular/receipts.js') }}"></script>

@endsection
