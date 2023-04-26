@extends('layouts.app')

@section('title','Dashboard')
    

@section('content')
<div class="ecommerce-widget"  ng-cloak ng-controller="HomeController">

    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-muted">Total Revenue (@{{data.currentYear}})</h5>
                    <div class="metric-value d-inline-block">
                        <h1 class="mb-1">LKR @{{data.totalRevenue | number:2}}</h1>
                    </div>
                    <div ng-if="data.revenueYearPrecentageStatus==1" class="metric-label d-inline-block float-right text-success font-weight-bold">
                        <span><i class="fa fa-fw fa-arrow-up"></i></span><span>@{{data.revenueYearPrecentage}}</span>
                    </div>
                    <div ng-if="data.revenueYearPrecentageStatus==0" class="metric-label d-inline-block float-right text-secondary font-weight-bold">
                        <span><i class="fa fa-fw fa-arrow-down"></i></span><span>@{{data.revenueYearPrecentage}}</span>
                    </div>
                </div>
                <div id="sparkline-revenue"></div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-muted">Current Month Revenue (@{{data.currentYear}} - @{{data.currentMonth}})</h5>
                    <div class="metric-value d-inline-block">
                        <h1 class="mb-1">LKR @{{data.currentMonthRevenue | number:2}}</h1>
                    </div>
                    <div ng-if="data.revenueMonthPrecentageStatus==1" class="metric-label d-inline-block float-right text-success font-weight-bold">
                        <span><i class="fa fa-fw fa-arrow-up"></i></span><span>@{{data.revenueMonthPrecentage}}</span>
                    </div>
                    <div ng-if="data.revenueMonthPrecentageStatus==0" class="metric-label d-inline-block float-right text-secondary font-weight-bold">
                        <span><i class="fa fa-fw fa-arrow-down"></i></span><span>@{{data.revenueMonthPrecentage}}</span>
                    </div>
                </div>
                <div id="sparkline-revenue2"></div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-muted">Refunds</h5>
                    <div class="metric-value d-inline-block">
                        <h1 class="mb-1">LKR 0.00</h1>
                    </div>
                    <div class="metric-label d-inline-block float-right text-primary font-weight-bold">
                        <span>N/A</span>
                    </div>
                </div>
                <div id="sparkline-revenue3"></div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-muted">Avg. Revenue Per User (@{{data.currentYear}})</h5>
                    <div class="metric-value d-inline-block">
                        <h1 class="mb-1">LKR @{{data.averageOrderAmountCurrentYear | number : 2}}</h1>
                    </div>
                    <div ng-if="data.revenueYearPrecentageStatusAverageOrder==1" class="metric-label d-inline-block float-right text-success font-weight-bold">
                        <span><i class="fa fa-fw fa-arrow-up"></i></span><span>@{{data.revenueYearPrecentageAverageOrder}}</span>
                    </div>
                    <div ng-if="data.revenueYearPrecentageStatusAverageOrder==0" class="metric-label d-inline-block float-right text-secondary font-weight-bold">
                        <span><i class="fa fa-fw fa-arrow-down"></i></span><span>@{{data.revenueYearPrecentageAverageOrder}}</span>
                    </div>
                </div>
                <div id="sparkline-revenue4"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- ============================================================== -->
        <!-- total revenue  -->
        <!-- ============================================================== -->

        
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- category revenue  -->
        <!-- ============================================================== -->
        <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">Revenue by Product Category</h5>
                <div class="card-body">
                    <div id="c3chart_category" style="height: 420px;"></div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end category revenue  -->
        <!-- ============================================================== -->

        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header"> Total Revenue</h5>
                <div class="card-body">
                    <div id="morris_totalrevenue"></div>
                </div>
                <div class="card-footer">
                    <p class="display-7 font-weight-bold"><span class="text-primary d-inline-block">$26,000</span><span class="text-success float-right">+9.45%</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- ============================================================== -->
  
        <!-- ============================================================== -->
  <!-- ============================================================== -->
                                  <!-- product category  -->
        <!-- ============================================================== -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header"> Product Category</h5>
                <div class="card-body">
                    <div class="ct-chart-category ct-golden-section" style="height: 315px;"></div>
                    <div class="text-center m-t-40">
                        <span class="legend-item mr-3">
                                <span class="fa-xs text-primary mr-1 legend-tile"><i class="fa fa-fw fa-square-full "></i></span><span class="legend-text">Man</span>
                        </span>
                        <span class="legend-item mr-3">
                            <span class="fa-xs text-secondary mr-1 legend-tile"><i class="fa fa-fw fa-square-full"></i></span>
                        <span class="legend-text">Woman</span>
                        </span>
                        <span class="legend-item mr-3">
                            <span class="fa-xs text-info mr-1 legend-tile"><i class="fa fa-fw fa-square-full"></i></span>
                        <span class="legend-text">Accessories</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end product category  -->

               <!-- product sales  -->
        <!-- ============================================================== -->
        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <!-- <div class="float-right">
                            <select class="custom-select">
                                <option selected>Today</option>
                                <option value="1">Weekly</option>
                                <option value="2">Monthly</option>
                                <option value="3">Yearly</option>
                            </select>
                        </div> -->
                    <h5 class="mb-0"> Product Sales</h5>
                </div>
                <div class="card-body">
                    <div class="ct-chart-product ct-golden-section"></div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end product sales  -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- customer acquistion  -->
        <!-- ============================================================== -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">Customer Acquisition</h5>
                <div class="card-body">
                    <div class="ct-chart ct-golden-section" style="height: 354px;"></div>
                    <div class="text-center">
                        <span class="legend-item mr-2">
                                <span class="fa-xs text-primary mr-1 legend-tile"><i class="fa fa-fw fa-square-full"></i></span>
                        <span class="legend-text">Returning</span>
                        </span>
                        <span class="legend-item mr-2">

                                <span class="fa-xs text-secondary mr-1 legend-tile"><i class="fa fa-fw fa-square-full"></i></span>
                        <span class="legend-text">First Time</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end customer acquistion  -->
        <!-- ============================================================== -->
    </div>

    
    
    <input type="hidden" ng-init="url='{{ route('revenue_stats') }}'; init();
                                all_product_categories='{{ route('all_product_categories') }}'; 
                                all_customers='{{ route('all_customers') }}';
                                init_select2_product_categories(); init_select2_products(); 
                                init_select2_customers();" />
</div>
@endsection

@section('script')
    <!-- sparkline js -->
    <script src="{{asset('assets/vendor/charts/sparkline/jquery.sparkline.js')}}"></script>
    <script src="{{asset('assets/vendor/charts/morris-bundle/raphael.min.js')}}"></script>
    <script src="{{asset('assets/vendor/charts/morris-bundle/morris.js')}}"></script>
    <script src="{{asset('assets/vendor/charts/c3charts/C3chartjs.js')}}"></script>
    <script src="{{ asset('assets/libs/js/angular/home.js') }}"></script>
@endsection
