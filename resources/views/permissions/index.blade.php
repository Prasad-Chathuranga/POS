@extends('layouts.app')

@section('title', 'Permissions')
@section('active', 'Permissions')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Access Management</a>
        <a href="{{route('perm_index')}}">Permissions</a>
    </li>
@endsection

@section('content')
    <div class="row" >
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="m-0 pt-1">Permissions</h5>
                </div>
                <div class="card-body" ng-controller="PermissionsController">
                    <h6>Modules</h6>
                    <div class="row mt-5">



                        <div class="module col-md-3 mt-2" ng-repeat="module in modules">
                            <div class="">
                            <a ng-click="loadPermissions(module)" class="d-block" href="javascript:;" style="text-align: center">
                                <span ng-bind="module.name"></span>
                            </a>
                            </div>
                        </div>

                    </div>

                    <input type="hidden" ng-init=" url = '{{route('perm_index')}}' ; init()" />

                    <script type="text/ng-template" id="permissions.html">

                        <div class="modal-header">
                            <h3 class="modal-title" >Permissions</h3>
                        </div>
                        <div class="modal-body" >

                            <div class='row'>
                                <div class='col-md-4'>

                                <input type='text' placeholder='New Permission' ng-model='obj.name' name='tmpName' id='tmpName' class='form-control form-control-sm' />
                                </div><div class='col-md-1'>
                                    <button ng-click='addNewPerm()' class='btn btn-sm btn-primary' type="button">Add</button></div>
                            </div>

                            <div class='row pt-5'>

                            <div class='col-md-12'>
                                <div class='row pt-1 pb-2' >
                                        <div class='col-md-6 '>
                                        <strong>Name</strong>
                                           </div>

                                        <div class='col-md-2'>
                                            <strong>Active </strong>
                                        </div>

                                        <div class='col-md-2'>
                                           <strong> Actions </strong>
                                        </div>

                                    </div>
                            </div>
                                <div class='permission col-md-12' ng-repeat='perm in data'>



                                    <div class='row' ng-if='!perm.remove'>
                                        <div class='col-md-6'>
                                            <input type='text' ng-readonly='!perm.edit' ng-model='perm.name' name='perm_name_@{{$index}}' id='perm_name_@{{$index}}' class='form-control form-control-sm' />
                                        </div>

                                        <div class='col-md-2'>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="perm_active_@{{$index}}" id="perm_active_@{{$index}}" ng-model="perm.active"
                                                       class="custom-control-input" ng-true-value='1' ng-false-value='0' />
                                                <label title='Active' for="perm_active_@{{$index}}"  class="custom-control-label"></label>
                                            </div>
                                        </div>

                                        <div class='col-md-2'>
                                            <button type='button' ng-click='enableEdit(perm)' ng-disabled='perm.edit' class='btn btn-icon btn-sm btn-outline-primary'><i class='fa fa-pencil'></i></button>
                                        </div>
                                        <div class='col-md-2'>

                                            <button ng-click='removePerm(perm)' type='button' class='btn btn-icon btn-sm btn-outline-danger'><i class='fa fa-trash'></i></button>

                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light-custom" type="button" ng-click="cancel()">Cancel</button>
                            <button class="btn btn-success" type="button" ng-click="ok()">Save</button>

                        </div>

                    </script>
                </div>
             

            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end basic form  -->
    <!-- ============================================================== -->
@endsection

@section('script')
    <script src="{{ asset('assets/libs/js/angular/permission.js') }}"></script>
@endsection

