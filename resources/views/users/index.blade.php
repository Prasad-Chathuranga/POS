@extends('layouts.app')

@section('title', 'Users')
@section('active', 'Users')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">User Management</a>
    </li>
@endsection

@section('content')
    <div class="row" ng-controller="UsersController">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="m-0 pt-1">Users</h5>
                    <div class="widget-bar ml-auto">
                        <a type="button" href="{{ route('users.create') }}"
                            class="btn btn-primary btn-sm text-light">New</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 6%">Actions</th>
                                <th style="width: 3%">#</th>
                                <th>Category</th>
                                <th>Role</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Last login</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>
                                        <a href="{{ route('users.edit', $user->id) }}"><i
                                                class="fas fa-pencil-alt text-info"></i></a>
                                        <a href="" ng-click="delete({{ $user->id }})" role="button"><i class="fas fas fa-trash-alt text-danger ml-1"></i></a>

                                    </td>
                                    <td>{{$key+1}}</td>
                                    <td>{{ $user->category->name }}</td>
                                    <td>{{ $user->role->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile }} </td>
                                    <td>{{ $user->last_login != null ? date('Y-m-d H:i A',strtotime($user->last_login)) : '' }}</td>
                                    <td>
                                        @if($user->active)
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
                <input type="hidden" ng-init="url='{{ route('users.index') }}';" />
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
    <script src="{{ asset('assets/libs/js/angular/users.js') }}"></script>
@endsection
