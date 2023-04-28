@extends('layouts.app')

@section('title', 'Roles')
@section('active', 'Roles')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Access Management</a>
        <a href="{{route('roles.index')}}">Roles</a>
    </li>
@endsection

@section('content')
    <div class="row" ng-controller="RolesController">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="m-0 pt-1">Roles</h5>
                    <div class="widget-bar ml-auto">
                        <a type="button" href="{{ route('roles.create') }}"
                            class="btn btn-primary btn-sm text-light">New</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 6%">Actions</th>
                                <th style="width: 3%">#</th>
                                <th>Role</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td>
                                        <a href="{{ route('roles.edit', $role->id) }}"><i
                                                class="fas fa-pencil-alt text-info"></i></a>
                                        <a href="" ng-click="delete({{ $role->id }})" role="button"><i class="fas fas fa-trash-alt text-danger ml-1"></i></a>

                                    </td>
                                    <td>{{$key+1}}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @if($role->active)
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
                <input type="hidden" ng-init="url='{{ route('roles.index') }}';" />
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
    <script src="{{ asset('assets/libs/js/angular/roles.js') }}"></script>
@endsection
