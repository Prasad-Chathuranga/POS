@extends('layouts.app')

@section('title', 'View Receipt')
@section('active', 'View Receipt')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">Receipt Management</a></li>
    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Receipts</a></li>
@endsection

@section('content')
    <!-- ============================================================== -->
    <!-- basic form  -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="m-0 pt-1">View Receipt</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered table-responsive-lg table-striped">
                        <tr>
                            <td>Name</td>
                            <td>{{$order->customer->username}}</td>
                        </tr>
                        <tr>
                            <td>NIC</td>
                            <td>{{$order->customer->nic}}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>
                                {!!$order->customer->address!!}
                            </td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>{{$order->customer->mobile}}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>{{$order->customer->phone}}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{$order->customer->email}}</td>
                        </tr>
                    </table>
                    </div>
                    <h5 class="mt-3 text-secondary">Items</h5>
                    @php
                    $total_discount = 0;
                    $total = 0;
                @endphp
                    <table class="table table-bordered table-responsive-lg table-striped">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Name</th>
                                <th class="text-right">Price</th>
                                <th class="text-right">Quantity</th>
                                <th class="text-right">Discount</th>
                                <th class="text-right">Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                                           
                            <tr>
                                    <td>{{$item->item->category->name}}</td>
                                    <td>{{$item->item->name}}</td>
                                    <td class="text-right">
                                        {{number_format(($item->price_user),2)}}
                                    </td>
                                    <td class="text-right">{{$item->quantity}}</td>


                                    @php

                                    $discount = 0;

                                    if($item->discountType=='1'){

                                        $discount = ($item->price_user*($item->discount/100))*$item->QTY;

                                    }

                                    else if($item->discountType=='2'){

                                        $discount = $item->discount;

                                    }



                                    $total_discount += $discount*$item->quantity;

                                    $total += $item->price_user*$item->quantity;

                                    @endphp

                                    <td style="text-align: right;">{{number_format(($discount*$item->quantity),2)}}</td>

                                    <td style="text-align: right;">{{number_format(($item->price_user*$item->quantity),2)}}</td>

                                </tr>
                              
                            @endforeach
                            <tr>
                                <td colspan="5" class="text-right"><strong>Sub Total</strong></td>
                                <td class="text-right">{{number_format($total,2)}}</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right"><strong>Total Discount</strong></td>
                                <td class="text-right">{{number_format($total_discount,2)}}</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right"><strong>Order Total</strong></td>
                                <td class="text-right">{{number_format($order->amount,2)}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h5 class="mt-3 text-secondary">Payments</h5>
                        @php
                            $groups = payment_methods();
                        @endphp
                        <table class="table table-bordered table-responsive-lg table-striped">
                            <thead>
                                <tr>
                                    <th>Payment Mode</th>
                                    <th>Receipt No</th>
                                    <th>Account Number</th>
                                    <th>Cheque Date</th>
                                    <th>Reference Number</th>
                                    <th>Notes</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->payments as $item)
                                    <tr>
                                        <td>{{$groups[$item->method]}}</td>
                                        <td>{{$item->receipt_no}}
                                            @if($item->status == $item::STATUS_REJECTED)
                                                <div class="badge badge-danger"><em>Rejected</em></div>
                                            @endif
                                        </td>
                                        <td>{{$item->data->accountNumber ?? ''}}</td>
                                        <td>{{$item->data->chequeDate ?? ''}}</td>
                                        <td>{{$item->data->referenceNumber ?? ''}}</td>
                                        <td>{{$item->data->notes ?? ''}}</td>
                                        <td class="text-right">{{number_format($item->amount,2)}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6">Total</td>
                                    <td class="text-right">{{number_format($order->paid,2)}}</td>
                                </tr>

                            </tbody>
                        </table>

                        <h5 class="mt-3 text-secondary">Summary</h5>
                        <table class="table table-bordered table-responsive-lg table-striped">
                            <tr>
                                <td>Total</td>
                                <td class="text-right">{{number_format($order->amount,2)}}</td>
                            </tr>
                            <tr>
                                <td>Total Paid</td>
                                <td class="text-right">{{number_format($order->paid,2)}}</td>
                            </tr>
                            <tr>
                                <td>Amount Due</td>
                                <td class="text-right">{{number_format(($order->amount-$order->paid),2)}}</td>
                            </tr>
                        </table>
                </div>

            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end basic form  -->
    <!-- ============================================================== -->
@endsection

