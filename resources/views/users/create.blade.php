@extends('layouts.app')

@section('title', 'Users')
@section('active', 'New')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">User Management</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
@endsection

@section('content')
    <!-- ============================================================== -->
    <!-- basic form  -->
    <!-- ============================================================== -->
    <div class="row" ng-controller="UsersController">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="m-0 pt-1">{{ isset($model) ? 'Edit User' : 'New User' }}</h5>
                    <div class="widget-bar ml-auto">
                        <a type="button" ng-click="save()" class="btn btn-success btn-sm text-light">Save</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-6 col-md-6 pl-0">
                        <form name="dataForm" novalidate>
                            <div class="form-group">

                                <label for="role_id" class="col-form-label required">Role</label>
                                
                                <select name="role_id" id="role_id" ng-model="data.role_id" class="form-control form-control-sm" 
                                ng-class="{'is-invalid' : submitted && dataForm.role_id.$invalid}">
                                <option ng-repeat="role in data.roles" ng-selected="data.role_id == role.id" 
                                ng-value="@{{role.id}}">@{{role.name}}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="user_category_id" class="col-form-label required">Category</label>
                                {{-- <select name="user_category_id" id="user_category_id" class="form-control form-control-sm" ng-model="data.user_category_id" ng-class="{'is-invalid' : submitted && dataForm.user_category_id.$invalid}">
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select> --}}
                                <select name="user_category_id" id="user_category_id" ng-model="data.user_category_id" class="form-control form-control-sm" 
                                ng-class="{'is-invalid' : submitted && dataForm.user_category_id.$invalid}">
                                <option ng-repeat="category in data.categories" ng-selected="data.user_category_id == category.id" 
                                ng-value="@{{category.id}}">@{{category.name}}</option>
                                </select>
                            </div>

                                <div class="form-group pt-3">
                                    <label for="username" class="col-form-label required">User Name</label>
                                    <input id="username" name="username" class="form-control form-control-sm"
                                        ng-model="data.username" ng-class="{'is-invalid' : submitted && dataForm.username.$invalid}"
                                        type="text">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-form-label required">Password</label>
                                    <input id="password" name="password" class="form-control form-control-sm"
                                        ng-model="data.password" ng-class="{'is-invalid' : submitted && dataForm.password.$invalid}"
                                        type="password">
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password" class="col-form-label required">Confirm Password</label>
                                    <input id="confirm_password" name="confirm_password" class="form-control form-control-sm"
                                        ng-model="data.confirm_password" ng-class="{'is-invalid' : submitted && dataForm.confirm_password.$invalid}"
                                        type="password">
                                </div>
                                
                                <div class="form-group">
                                    <label for="email" class="col-form-label required">Email</label>
                                    <input id="email" name="email" class="form-control form-control-sm"
                                        ng-model="data.email" ng-class="{'is-invalid' : submitted && dataForm.email.$invalid}"
                                        type="text">
                                </div>

                                <div class="form-group">
                                    <label for="mobile" class="col-form-label required">Mobile</label>
                                    <input id="mobile" name="mobile" class="form-control form-control-sm"
                                        ng-model="data.mobile" ng-class="{'is-invalid' : submitted && dataForm.mobile.$invalid}"
                                        type="text">
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
                                    ng-init="url='{{ route('users.index') }}'; all_user_roles='{{route('all_user_roles')}}'; all_user_categories='{{route('all_user_categories')}}'; get_all_user_roles(); get_all_user_categories();" />
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
    <script src="{{ asset('assets/libs/js/angular/users.js') }}"></script>

@endsection
