@extends('layouts.app')

@section('title', 'Products')
@section('active', 'New')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">Customer Management</a></li>
    <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
@endsection

@section('content')
    <!-- ============================================================== -->
    <!-- basic form  -->
    <!-- ============================================================== -->
    <div class="row" ng-controller="CustomersController">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="m-0 pt-1">{{ isset($model) ? 'Edit Customer' : 'New Customer' }}</h5>
                    <div class="widget-bar ml-auto">
                        <a type="button" ng-click="save()" class="btn btn-success btn-sm text-light">Save</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-6 col-md-6 pl-0">
                        <form name="dataForm" novalidate>
                            
                                <div class="form-group pt-3">
                                    <label for="username" class="col-form-label required">Customer Name</label>
                                    <input id="username" name="username" class="form-control form-control-sm"
                                        ng-model="data.username" ng-class="{'is-invalid' : submitted && dataForm.username.$invalid}"
                                        type="text">
                                </div>
                                <div class="form-group">
                                    <label for="mobile" class="col-form-label required">Mobile</label>
                                    <input id="mobile" name="mobile" class="form-control form-control-sm"
                                        ng-model="data.mobile" ng-class="{'is-invalid' : submitted && dataForm.mobile.$invalid}"
                                        type="text">
                                </div>

                                <div class="form-group">
                                    <label for="phone" class="col-form-label required">Phone</label>
                                    <input id="phone" name="phone" class="form-control form-control-sm"
                                        ng-model="data.phone" ng-class="{'is-invalid' : submitted && dataForm.phone.$invalid}"
                                        type="text">
                                </div>

                                <div class="form-group">
                                    <label for="nic" class="col-form-label required">NIC</label>
                                    <input id="nic" name="nic" class="form-control form-control-sm"
                                        ng-model="data.nic" ng-class="{'is-invalid' : submitted && dataForm.nic.$invalid}"
                                        type="text">
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-form-label required">Email</label>
                                    <input id="email" name="email" class="form-control form-control-sm"
                                        ng-model="data.email" ng-class="{'is-invalid' : submitted && dataForm.email.$invalid}"
                                        type="text">
                                </div>

                                <div class="form-group">
                                    <label for="address" class="col-form-label required">Address</label>
                                    <textarea id="address" name="soh" class="form-control form-control-sm"
                                        ng-model="data.address" ng-class="{'is-invalid' : submitted && dataForm.address.$invalid}"
                                        type="text"></textarea>
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
                                    ng-init="url='{{ route('customers.index') }}';" />
                                @if (isset($model))
                                    <input type="hidden" ng-init="init({{ $model }});" />
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
    <script src="{{ asset('assets/libs/js/angular/customers.js') }}"></script>

@endsection
