@extends('layouts.app')

@section('title', 'Orders')
@section('active', 'Orders')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Order Management</a>
    </li>
@endsection

@section('content')
    <div class="row" ng-controller="OrdersController">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="m-0 pt-1">Orders</h5>
                    <div class="widget-bar ml-auto">
                        <a type="button" href="{{ route('orders.create') }}"
                            class="btn btn-primary btn-sm text-light">New</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 6%">Actions</th>
                                <th style="width: 3%">Serial</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <th>Payments</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $order)
                                <tr>
                                    <td>
                                        <a href="" ng-click="delete({{ $order->id }})" role="button"><i class="fas fas fa-trash-alt text-danger ml-1"></i></a>
                                        <a href="{{route('view_order', $order->id)}}" role="button"><i class="fas fas fa-binoculars text-info ml-1"></i></a>
                                        <a href="{{route('print_order', $order->id)}}" role="button"><i class="fas fas fa-print text-primary ml-1"></i></a>
                                        {{-- <a href="{{route('refund', $order->id)}}" role="button"><i class="fas fas fa-refund text-primary ml-1"></i></a> --}}
                                    </td>
                                    <td>{{$order->id}}
                                        <span class="letter-circle bg-secondary" title="" data-toggle="tooltip" @if($order->customer->order_count->count() > 1) data-original-title="Recurring Customer" @else data-original-title="New Customer" @endif;>{{$order->customer->order_count->count() > 1 ? 'R':'N'}}</span> 
                                        @if($order->status == $order::ORDER_STATUS_OK && $order->active == $order::ORDER_STATUS_ACTIVE)
                                            <label class="badge badge-success">
                                                Completed
                                            </label>
                                        @endif</td>
                                    <td>{{ $order->customer->username }}</td>
                                    <td>{{ $order->customer->email }}</td>
                                    <td>{{ $order->customer->mobile}}</td>
                                    <td>{{ number_format($order->amount, 2) }}</td>
                                    <td>{{ number_format($order->paid, 2) }}</td>
                                    <td>
                                    @foreach ($order->payments as $payment)
                                        <span>{{$payment->receipt_no}}</span> <br>
                                    @endforeach
                                </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <input type="hidden" ng-init="url='{{ route('orders.index') }}';" />
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
                "ordering": false,
                'pageLength': 25,
                "columnDefs": [{
                    "orderable": false,
                    "targets": 0
                }],
                "order": [1, 'asc']
            });
        });
    </script>
    <script src="{{ asset('assets/libs/js/angular/receipts.js') }}"></script>
@endsection
