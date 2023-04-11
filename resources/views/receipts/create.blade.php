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
    <div class="row" ng-cloak ng-controller="ReceiptsController">
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
                                <div class="col-md-8">
                                    <div class="form-group">

                                        <label>Customer</label>
        
                                        <select name="customer_id" id="customer_id"
                                            ng-class="{'is-invalid' : submitted && dataForm.customer_id.$invalid}"
                                            ng-model="data.customer_id" class="form-control form-control-sm">
        
                                            <option value="">Select</option>
        
                                        </select>
        
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="customer_name" class="required">Code</label>
                                    <input id="customer_code" name="customer_code" class="form-control form-control-sm"
                                        ng-model="data.customer.customer_code" ng-class="{'is-invalid' : submitted && dataForm.customer_code.$invalid}"
                                        type="text">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="customer_name" class="col-form-label required">Name</label>
                                    <input id="customer_name" name="customer_name" class="form-control form-control-sm"
                                        ng-model="data.customer.username" ng-class="{'is-invalid' : submitted && dataForm.customer_name.$invalid}"
                                        type="text">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="customer_mobile" class="col-form-label required">Mobile</label>
                                    <input id="customer_mobile" name="customer_mobile" class="form-control form-control-sm"
                                        ng-model="data.customer.mobile" ng-class="{'is-invalid' : submitted && dataForm.customer_mobile.$invalid}"
                                        type="text">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="customer_phone" class="col-form-label required">Phone</label>
                                    <input id="customer_phone" name="customer_phone" class="form-control form-control-sm"
                                        ng-model="data.customer.phone" ng-class="{'is-invalid' : submitted && dataForm.customer_phone.$invalid}"
                                        type="text">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="customer_email" class="col-form-label required">Email</label>
                                    <input id="customer_email" name="customer_email" class="form-control form-control-sm"
                                        ng-model="data.customer.email" ng-class="{'is-invalid' : submitted && dataForm.customer_email.$invalid}"
                                        type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label required">Product Category</label>
                                        <select class="select2 form-control form-control-lg" id="product_categories"
                                            name="product_category">
                                            <option></option>
                                        </select>
                                        {{-- <select id="select-repo" class="select2" placeholder="Pick a category..." ></select> --}}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label required">Product</label>
                                        {{-- <select id="select-repo2" placeholder="Pick a Product..." ></select> --}}

                                        <select class="select2 form-control form-control-lg" id="products" name="product">
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

                                            <td>
                                                <p> @{{ product.name }}</p>

                                                {{-- <input type="hidden" name="categoryItem_id" ng-model="data.categoryItem_id">

                                        <input type="hidden" name="price" ng-model="data.price"> --}}

                                            </td>

                                            <td class="text-right" ng-if="product.allow_price_change != 1">
                                                @{{ product.price | number: 2 }}</td>

                                            <td ng-show="product.allow_price_change == 1">

                                                <input type="number" min="0" required maxlength="200"
                                                    ng-class="{'is-invalid' : submitted && dataForm.price.$invalid}"
                                                    ng-model="product.price" class="form-control allow_numeric  text-right"
                                                    ng-change="calculateTotal()" />

                                            </td>

                                            <td>

                                                <input type="number" min="0" required maxlength="200"
                                                    ng-class="{'is-invalid' : submitted && dataForm.quantity.$invalid}"
                                                    ng-model="product.quantity"
                                                    class="form-control allow_numeric  text-right"
                                                    ng-change="calculateTotal()" />

                                            </td>



                                            <td>

                                                <select ng-show="product.discountable" ng-model="product.discountType"
                                                    class="form-control" ng-change="calculateTotal()">

                                                    <option ng-value="2">Fixed</option>

                                                    <option ng-value="1">%</option>

                                                </select>
                                                <span ng-if="!product.discountable">Fixed</span>

                                            </td>
                                            <td>

                                                <input type="number" ng-if="product.discountable"
                                                    ng-model="product.discount"
                                                    class="form-control allow_numeric text-right"
                                                    ng-change="calculateTotal()">
                                                <span ng-if="!product.discountable">Fixed</span>
                                            </td>


                                            {{-- <td> --}}



                                            {{--  <label ng-if="item.discountType==1">%</label> --}}

                                            {{-- <select ng-show="product.discountable" ng-model="product.discount_type" class="form-control" ng-change="calculateTotal()">
                                                <option ng-value="2">Fixed</option>

                                                <option ng-value="1">%</option>

                                            </select> --}}

                                            {{-- </td> --}}

                                            <td class="text-right">@{{ product.gross_total | number: 2 }}</td>

                                            <td>

                                                <div class="button-list">

                                                    <button type="button" ng-click="removeProduct(key)"
                                                        class="btn btn-round btn-danger-rgba"><i
                                                            class="fa fa-trash"></i></button>

                                                </div>

                                            </td>

                                        </tr>

                                    </tbody>

                                    <tfoot>

                                        <tr>

                                            <th colspan="5" class="text-right"><strong>Sub Total</strong></th>

                                            <th class="text-right">@{{ data.gross_total | number: 2 }}</th>

                                            <th></th>

                                        </tr>



                                        <tr>

                                            <th colspan="5" class="text-right"><strong>Discount</strong></th>

                                            <th class="text-right">@{{ data.total_discount | number: 2 }}</th>

                                            <th></th>

                                        </tr>



                                        {{-- <tr>

                                        <th colspan="5" class="text-right"><strong>Handling Fee</strong></th>

                                        <th class="text-right">

                                            <input type="text" ng-model="data.handling_fee" class="form-control allow_numeric" ng-change="calculateTotal()">

                                        </th>

                                        <th></th>

                                    </tr> --}}



                                        <tr>

                                            <th colspan="5" class="text-right"><strong>Total</strong></th>

                                            <th class="text-right">@{{ data.sub_total | number: 2 }}</th>

                                            <th></th>

                                        </tr>

                                    </tfoot>

                                </table>
                            </div>




                            <input type="hidden"
                                ng-init="url='{{ route('orders.index') }}'; 
                                all_product_categories='{{ route('all_product_categories') }}'; 
                                all_customers='{{route('all_customers')}}';
                                init_select2_product_categories(); init_select2_products(); 
                                init_select2_customers();" />
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

    <script>
        //*
        $(".allow_decimal").on("input", function(evt) {
            var self = $(this);
            self.val(self.val().replace(/[^0-9\.]/g, ''));
            if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
                evt.preventDefault();
            }
        });
        //*

        //*
        $(".allow_numeric").on("input", function(evt) {
            var self = $(this);
            self.val(self.val().replace(/\D/g, ""));
            if ((evt.which < 48 || evt.which > 57)) {
                evt.preventDefault();
            }
        });
        //*
    </script>

@endsection
