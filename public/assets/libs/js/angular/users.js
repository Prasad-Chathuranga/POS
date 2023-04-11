
app.controller('UsersController', ($scope, $http, Loader, $timeout) => {

    $scope.data = {};


    $scope.init = (id) => {

        $http.get($scope.url + '/' + id)
            .then((response) => {

                $scope.data = response.data.data;
                $scope.get_all_user_roles();
                $scope.get_all_user_categories();
              
                

            })
            .catch((error) => {
                // pnotify('Error', getErrorAsString(error.data), 'error');
            });

    };

    $scope.get_all_user_roles = () => {

        $http.get($scope.all_user_roles)
            .then((response) => {

                $scope.data.roles = response.data.data;


                if (typeof (initDone) == 'function') {
                    initDone($scope.data);
                }

            })
            .catch((error) => {
                // pnotify('Error', getErrorAsString(error.data), 'error');
            });

    };

    $scope.get_all_user_categories = () => {

        $http.get($scope.all_user_categories)
            .then((response) => {

                $scope.data.categories = response.data.data;


                if (typeof (initDone) == 'function') {
                    initDone($scope.data);
                }

            })
            .catch((error) => {
                // pnotify('Error', getErrorAsString(error.data), 'error');
            });

    };





    $scope.save = () => {


        $scope.submitted = true;
        var url = $scope.url;

        if (typeof (beforeSubmit) == 'function') {
            beforeSubmit($scope.data);
        }

        if ($scope.dataForm.$invalid) {
            return pnotify('Error', 'There is something wrong with your input.', 'error');
        }


        if ($scope.data.id) {
            url += '/' + $scope.data.id;
            $scope.data._method = 'put';
        }

        Loader.start();

        $http.post(url, $scope.data)
            .then((response) => {

                Loader.stop();

                // pnotify('Success', response.data.message, 'success');

                $timeout(() => {
                    window.location = response.data.url;
                }, 2000);

            })
            .catch((error) => {
                console.log(error);
                // pnotify('Error', getErrorAsString(error.data), 'error');
                Loader.stop();
            });

    };


    $scope.delete = (id) => {

        var result = confirm('Do you want to delete this record?');



        if (result === true) {

            var url = $scope.url + '/' + id;

            Loader.start();

            $http.delete(url)
                .then((response) => {
                    $scope.data = {};
                    Loader.stop();
                    // pnotify('Success', response.data.message, 'success');

                    $timeout(() => {
                        window.location = response.data.url;
                    }, 2000);

                })
                .catch((error) => {
                    // pnotify('Error', getErrorAsString(error.data), 'error');
                    Loader.stop();
                });

        }



    };
});
