@extends('layouts.app')

@section('title', 'Customers')
@section('active', 'Customers')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Customer Management</a>
    </li>
@endsection

@section('content')
    <div class="row" ng-controller="CustomerController">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="m-0 pt-1">Customers</h5>
                    <div class="widget-bar ml-auto">
                        <a type="button" href="{{ route('customers.create') }}"
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
                                <th>Phone</th>
                                <th>Earnings</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $key => $customer)
                                <tr>
                                    <td>
                                        <a href="{{ route('customers.edit', $customer->id) }}"><i
                                                class="fas fa-pencil-alt text-info"></i></a>
                                        <a href="" ng-click="delete({{ $customer->id }})" role="button"><i class="fas fas fa-trash-alt text-danger ml-1"></i></a>

                                    </td>
                                    <td>{{$key+1}}</td>
                                    <td>{{ $customer->category->name }}</td>
                                    <td>{{ $customer->role->name }}</td>
                                    <td>{{ $customer->username }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->mobile }}</td>
                                     <td>{{ $customer->phone }}</td>
                                     <td>{{ number_format($customer->earnings,2) }}</td>
                                    <td>
                                        @if($customer->active)
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
                <input type="hidden" ng-init="url='{{ route('customers.index') }}';" />
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
    <script src="{{ asset('assets/libs/js/angular/customers.js') }}"></script>
@endsection
