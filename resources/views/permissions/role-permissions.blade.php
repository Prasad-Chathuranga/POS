@extends('layouts.app')

@section('title', 'Role Permissions')
@section('active', 'Role Permissions')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Access Management</a>
        <a href="{{route('modules.index')}}">Permissions</a>
    </li>
@endsection

@section('content')
    <div class="row" ng-controller="RolePermissionController">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="m-0 pt-1">Role Permissions</h5>
                    <div class="widget-bar ml-auto">
                        <a type="button" role="button" ng-click="save()"
                            class="btn btn-success btn-sm text-light">Save</a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form form-inline">
                        <label>
                            Role
                        </label>
                        <div class="ml-3" style="width:10em!important;display: inline-block">
                            <select ng-change="roleChanged()"  name="role_id" id="role_id" ng-model="role_id" class="form-control ">
                                <option value="">Select</option>
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    <div class="row mt-5">
                        <div class='col-md-12'>
                            <table ng-if="modules" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:20%">Module</th>
                                        <th>Permissions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="module in modules">
                                        <td  ng-bind="module.name">
                                        </td>
                                        <td>
                                            <div class="row">
                                                    <div class="col-md-3" ng-repeat="perm in module.active_permissions">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="perm_@{{module.name}}_@{{$index}}" class="custom-control-input"
                                                                   id="perm_@{{module.name}}_@{{$index}}"
                                                                   ng-model="perm.active" ng-true-value='1' ng-false-value='0' />
                                                            <label class="custom-control-label" for="perm_@{{module.name}}_@{{$index}}" ng-bind="perm.name"></label>
                                                        </div>
                                                    </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" ng-init=" url = '{{route('role_perm')}}' ; init()" />
                
                </div>
                {{-- <input type="hidden" ng-init="url='{{ route('perm_index') }}';" /> --}}
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
    <script src="{{ asset('assets/libs/js/angular/permission.js') }}"></script>
@endsection
