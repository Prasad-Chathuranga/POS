@extends('layouts.app')

@section('title', 'Event Logs')
@section('active', 'Event Logs')


@section('content')
    <div class="row" ng-controller="ActivityController">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="m-0 pt-1">Event Logs</h5>
                    <div class="widget-bar ml-auto">
                        {{-- <a type="button" href=""
                            class="btn btn-light btn-sm text-light disabled">New</a> --}}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 1%">Actions</th>
                                <th style="width: 1%">#</th>
                                <th style="width: 5%">User</th>
                                <th style="width: 8%">Event</th>
                                <th style="width: 5%">Table</th>
                                <th style="width: 5%">IP</th>
                                <th style="width: 5%">Key</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $key => $log)
                                <tr>
                                    <td>
                                        <a href="javascript:;" ng-click="showInfo({{$log->id}})"><i class="fas fa-binoculars text-info"></i></a>
                                    </td>
                                    <td>{{$key+1}}</td>
                                    <td>{{ $log->user->username }}</td>
                                    <td>{{ $log->event }}</td>
                                    <td>{{ $log->table }}</td>
                                    <td>{{ $log->IP }}</td>
                                    <td>{{ $log->key }}</td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <script type="text/ng-template" id="info.html">

                    <div class="modal-header">
                        <h3 class="modal-title" >Information</h3>
                    </div>
                    <div class="modal-body" >
                        <div style='padding:1em; overflow-y:scroll;max-height:600px;' >
                            <pre ng-bind='data'></pre>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light-custom" type="button" ng-click="close()">Close</button>


                    </div>

                </script>
                <input type="hidden" ng-init="url='{{ route('event-logs.index') }}';" />
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

        app.controller('ActivityController' , ($scope,$http,$uibModal) => {

$scope.showInfo = (id) => {

 var modalInstance =   $uibModal.open(
            {
                size:'md',
                controller: 'ActivityInfoController',
                templateUrl : 'info.html',
                resolve: { ActivityID : ()=>{ return id;}}
            }
            );

    modalInstance.result.then (() => {} ) .catch(() =>{});

};

});

app.controller('ActivityInfoController' , ($scope,$http,$uibModalInstance , Loader , ActivityID ) =>{

$scope.init =() =>{

    var url = '{{route("event-logs.index") }}' + '/' + ActivityID;
    Loader.start();

    $http.get(url).then((response) => {
  
        Loader.stop();
        $scope.data = response.data.data;
    }).catch((error)=>{ Loader.stop(); });

};

$scope.init();

$scope.close = () => {
    $uibModalInstance.close();
};

});

    </script>
    <script src="{{ asset('assets/libs/js/angular/product-category.js') }}"></script>
@endsection
