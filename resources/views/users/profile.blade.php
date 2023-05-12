@extends('layouts.app')

@section('title', 'Profile')
@section('active', 'Profile')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">User</a></li>
@endsection

@section('content')
    <!-- ============================================================== -->
    <!-- basic form  -->
    <!-- ============================================================== -->
    <div class="row" ng-controller="ProfileController">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="m-0 pt-1">Profile</h5>
                    <div class="widget-bar ml-auto">
                        <a type="button" ng-click="save()" class="btn btn-success btn-sm text-light">Save</a>
                    </div>
                </div>
                <div class="card-body">
                    <form name="dataForm" novalidate>

                        <div class="row">

                            <div class="col-md-3">

                                <div class="form-group">
                                    <label class="required">Name</label>
                                    <input type="text" required maxlength="50" name="username" id="username"
                                           ng-class="{'is-invalid' : submitted && dataForm.username.$invalid}"
                                           ng-model="data.username" class="form-control" />
                                </div>


                                <div class="form-group">
                                    <label >Image <code>(2MB Max)</code></label>
                                    <input type="file" ng-model="data.image"  accept="image/jpeg,image/png" name="image" id="image"
                                           onchange="angular.element('#image').scope().imageChanged(this)"

                                            class="form-control" />
                                </div>

                                <div ng-cloak class="form-group mt-3" ng-if='data.image'>

                                    <img style="max-width: 300px ; max-height: 300px;" ng-src='{{url('assets/images/profile/')}}/@{{data.image}}' />

                                </div>

                            </div>

                            <div class="col-md-3 offset-md-1">
                                <div class="form-group">
                                    <label class="required">Mobile</label>
                                    <input type="text" required maxlength="100" name="mobile" id="mobile" 
                                           ng-class="{'is-invalid' : submitted && dataForm.mobile.$invalid}"
                                           ng-model="data.mobile" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label class="required">Email</label>
                                    <input type="email" required maxlength="100" name="email" id="email" ng-disabled='true'
                                           ng-class="{'is-invalid' : submitted && dataForm.email.$invalid}"
                                           ng-model="data.email" class="form-control" />
                                </div>

                                <div class="form-group">
                                    <label ng-class="{'required' : !data.id}" >Password</label>
                                    <input type="password" ng-required='!data.id' maxlength="20" name="password" id="password"
                                           ng-class="{'is-invalid' : submitted && dataForm.password.$invalid}"
                                           ng-model="data.password" class="form-control" />
                                </div>

                                <div class="form-group">
                                    <label ng-class="{'required' : !data.id}">Confirm</label>
                                    <input type="password" ng-required='!data.id' maxlength="20" name="confirm" id="confirm"
                                           ng-class="{'is-invalid' : submitted && dataForm.confirm.$invalid}" ng-change="calculatePWScore()"
                                           ng-model="data.confirm" class="form-control" />
                                </div>

                                <div class="progress">
                                    <div class="progress-bar"
                                         ng-class="{ 'w-0' : pwScore ==0 , 'w-0' : pwScore == 1 , 'w-50': pwScore==2, 'w-75': pwScore==3  , 'w-100'  : pwScore > 3 }"
                                         role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>


                            </div>

                        </div>



                        @if(isset($model))
                            <input type="hidden" ng-init="url='{{route('profile')}}';init()" />
                        @endif
                    </form>
                </div>
            </div>
        </div>

    </div>
   
    <!-- ============================================================== -->
    <!-- end basic form  -->
    <!-- ============================================================== -->
@endsection
@section('script')
    <script src="{{ asset('assets/libs/js/angular/profile.js') }}"></script>

@endsection
