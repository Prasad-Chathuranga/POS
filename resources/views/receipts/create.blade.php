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
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="text-danger m-0">Customer Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Customer</label>

                                                <select name="customer_id" id="customer_id"
                                                ng-model="data.customer_id"
                                                    ng-class="{'is-invalid' : submitted && dataForm.customer_id.$invalid}"
                                                     class="form-control form-control-sm">

                                                    <option value="">Select</option>

                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="nic" class="required">NIC</label>
                                                <input id="nic" name="nic"
                                                    class="form-control form-control-sm" required ng-model="data.nic"
                                                    ng-class="{'is-invalid' : submitted && dataForm.nic.$invalid}"
                                                    type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="customer_name" class="col-form-label required">Name</label>
                                                <input id="customer_name" name="customer_name"
                                                    class="form-control form-control-sm" ng-model="data.username"
                                                    ng-class="{'is-invalid' : submitted && dataForm.customer_name.$invalid}"
                                                    type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="customer_mobile" class="col-form-label required">Mobile</label>
                                                <input id="customer_mobile" name="customer_mobile"
                                                    class="form-control form-control-sm" ng-model="data.mobile"
                                                    ng-class="{'is-invalid' : submitted && dataForm.customer_mobile.$invalid}"
                                                    type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="customer_phone" class="col-form-label required">Phone</label>
                                                <input id="customer_phone" name="customer_phone"
                                                    class="form-control form-control-sm" ng-model="data.phone"
                                                    ng-class="{'is-invalid' : submitted && dataForm.customer_phone.$invalid}"
                                                    type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="customer_email" class="col-form-label required">Email</label>
                                                <input id="customer_email" name="customer_email"
                                                    class="form-control form-control-sm" ng-model="data.email"
                                                    ng-class="{'is-invalid' : submitted && dataForm.customer_email.$invalid}"
                                                    type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="customer_address">Address</label>
                                            <textarea id="customer_address" name="customer_address" class="form-control form-control-sm" ng-model="data.address"></textarea>
                                        </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header">
                                    <h5 class="text-danger m-0">Product Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="col-form-label required">Product
                                                    Category</label>
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

                                                <select class="select2 form-control form-control-lg" id="products"
                                                    name="product">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3">
                                        <table class="table table-bordered table-responsive-sm">
                                            <thead>
                                                <tr>

                                                    <th>Item</th>
                                                    <th style="width: 150px;text-align: right;">Price</th>
                                                    <th style="width: 175px;text-align: right;">Quantity</th>
                                                    <th style="width: 250px; text-align: right" colspan="2">Discount</th>
                                                    <th style="width: 150px; text-align: right">Gross Total</th>
                                                    <th style="width: 70px;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="(key,product) in data.products">
                                                    <td>
                                                        <p> @{{ product.name }}</p>
                                                    </td>
                                                    <td class="text-right" ng-if="product.allow_price_change != 1">
                                                        @{{ product.price | number: 2 }}</td>
                                                    <td ng-show="product.allow_price_change == 1">
                                                        <input type="number" min="0" required maxlength="200"
                                                            ng-class="{'is-invalid' : submitted && dataForm.price.$invalid}"
                                                            ng-model="product.price"
                                                            class="form-control allow_numeric  text-right"
                                                            ng-change="calculateTotal()" />
                                                    </td>
                                                    <td>
                                                        <input type="number" min="1" required maxlength="200"
                                                            ng-class="{'is-invalid' : submitted && dataForm.quantity.$invalid}"
                                                            ng-model="product.quantity"
                                                            placeholder="Quantity"
                                                            class="form-control allow_numeric  text-right"
                                                            ng-change="calculateTotal()" />
                                                    </td>
                                                    <td>
                                                        <select ng-show="product.discountable"
                                                            ng-model="product.discountType" class="form-control"
                                                            ng-change="calculateTotal()" ng-dropdown>
                                                            <option ng-option value="" disabled>Type</option>
                                                            <option ng-option value="2">Fixed</option>
                                                            <option ng-option value="1">%</option>
                                                        </select>
                                                        <span ng-if="!product.discountable" class="float-right">Fixed</span>
                                                    </td>
                                                    <td>
                                                        <input type="number" ng-if="product.discountable"
                                                            ng-model="product.discount"
                                                            class="form-control allow_numeric text-right"
                                                            placeholder="Discount"
                                                            ng-change="calculateTotal()">
                                                        <span ng-if="!product.discountable" class="float-right">Fixed</span>
                                                    </td>

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

                                                <tr>

                                                    <th colspan="5" class="text-right"><strong>Total</strong></th>

                                                    <th class="text-right">@{{ data.sub_total | number: 2 }}</th>

                                                    <th></th>

                                                </tr>

                                            </tfoot>

                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="text-danger m-0">Payment Details <button type="button" data-toggle="tooltip" data-placement="top" title="Add New Payment Method" ng-click="addPayment()" class="btn btn-sm btn-rounded btn-success"><i class="fa fa-plus"></i></button></h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                <div class="col-md-12">

                                    <table class="table table-bordered table-responsive-sm">

                                        <thead>

                                            <tr>

                                                <th>Payment Method</th>

                                                <th>Card Type</th>

                                                <th style="width: 100px;">Account/Cheque/Card Number</th>

                                                <th style="width: 225px;">Cheque Date</th>

                                                <th style="width: 150px;">Referrence</th>

                                                <th>Notes</th>

                                                <th style="width: 150px;">Amount</th>

                                                <th style="width: 70px;"></th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            <tr ng-repeat="(key,item) in data.payments">

                                                <td>
                                                    <select  required name="receiptGroup" id="receiptGroup"

                                                            ng-class="{'is-invalid' : submitted && dataForm.receiptGroup.$invalid}"

                                                        ng-model="item.payment_method" class="form-control">

                                                        <option value="">Select</option>

                                                        @foreach (payment_methods() as $key => $item)
                                                            <option id="{{$key}}" value="{{$key}}">{{$item}}</option>
                                                        @endforeach

                                                    </select>

                                                </td>

                                                <td>

                                                    <select ng-model="item.cardType" class="form-control" >

                                                        <option value="">SELECT</option>

                                                        <option value="MASTER">MASTER</option>

                                                        <option value="VISA">VISA</option>

                                                        <option value="AMEX">AMEX</option>

                                                    </select>

                                                </td>

                                                <td>

                                                    <input type="text"  maxlength="200" name="accountNumber" id="accountNumber"

                                                    ng-class="{'is-invalid' : submitted && dataForm.accountNumber.$invalid}"

                                                    ng-model="item.accountNumber" class="form-control" />

                                                </td>

                                                <td>

                                                    <input type="text"  maxlength="200" name="chequeDate" id="chequeDate"

                                                    ng-class="{'is-invalid' : submitted && dataForm.chequeDate.$invalid}"

                                                    ng-model="item.chequeDate" class="form-control" />

                                                </td>

                                                <td>

                                                    <input type="text"  maxlength="200" name="referenceNumber" id="referenceNumber"

                                                    ng-class="{'is-invalid' : submitted && dataForm.referenceNumber.$invalid}"

                                                    ng-model="item.referenceNumber" class="form-control" />

                                                </td>

                                                <td><input type="text"  maxlength="200" name="notes" id="notes"

                                                    ng-class="{'is-invalid' : submitted && dataForm.notes.$invalid}"

                                                    ng-model="item.notes" class="form-control" />

                                                </td>

                                                <td><input type="text" required ng-disabled="item.receiptGroup==6"  maxlength="200" ng-change="calculatePaymentTotal()" class="allow_decimal"

                                                    ng-class="{'is-invalid' : submitted && dataForm.amount.$invalid}"

                                                    ng-model="item.amount" class="form-control" />


                                                </td>

                                                <td>

                                                    <div class="button-list">

                                                        <button type="button" ng-click="removePayment(key)" class="btn btn-sm"><i
                                                            class="fa fa-trash text-danger"></i></button>

                                                    </div>

                                                </td>

                                            </tr>

                                        </tbody>

                                        <tfoot>

                                            <tr>

                                                <th colspan="6" class="text-right"><strong>Total</strong></th>

                                                <th class="text-right">@{{data.payment_total | number : 2}}</th>

                                                <th></th>

                                            </tr>

                                            <tr>

                                                <th colspan="6" class="text-right"><strong>Due Amount</strong></th>

                                                <th class="text-right">@{{(data.sub_total-data.payment_total) | number : 2}}</th>

                                                <th></th>

                                            </tr>

                                        </tfoot>

                                    </table>

                                </div>

                            </div>

                                </div>
                            </div>

                            <input type="hidden"
                                ng-init="url='{{ route('orders.index') }}'; 
                                all_product_categories='{{ route('all_product_categories') }}'; 
                                all_customers='{{ route('all_customers') }}';
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
