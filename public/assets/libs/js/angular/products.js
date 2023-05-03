
app.controller('ProductsController', ($scope, $http, Loader, $timeout) => {

    $scope.data = {};
    $scope.data.active = 1;

    $scope.init = (id) => {

        $http.get($scope.url + '/' + id)
            .then((response) => {

                $scope.data = response.data.data;

                $('#product_categories').append($('<option>', {
                    value:  $scope.data.category.id,
                    text:$scope.data.category.name + ' - SOH (' + $scope.data.category.soh + ')',
                    selected: true,
                }));

                if (typeof (initDone) == 'function') {
                    initDone($scope.data);
                }

            })
            .catch((error) => {
                // pnotify('Error', getErrorAsString(error.data), 'error');
            });

    };

    $scope.init_select2_product_categories = () => {

        $('#product_categories').select2({
            ajax: {
                url: $scope.all_product_categories,
                data: function (params) {

                    var query = {
                        category: params.term
                    }
                    return query;
                },
                dataType: 'json',
            },
            placeholder: "Select a Product Category"
            
        }).on('change', function (event) {
          
            $scope.data.product_category_id = $(this).val();

        });

    }


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
