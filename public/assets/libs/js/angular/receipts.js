
app.controller('ReceiptsController', ($scope, $http, Loader, $timeout) => {

    $scope.data = {};
    $scope.data.products = [];
    $scope.data.payments = [];
    $scope.data.total = 0;
    $scope.data.total_discount = 0;
    $scope.data.gross_total = 0;
    $scope.data.sub_total = 0;


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
            
        }).on('select2:select', function (event) {
            $scope.data.product_category_id = $(this).val();
            // $('#products').val('')
            $scope.init_select2_products();

        });
   
//         new TomSelect('#select-repo',{
//             valueField: 'id',
//             searchField: 'title',
          
            
//                 placeholder: 'test',
            
//             // // fetch remote data
//             load: function(query, callback) {

//                 var self = this;
// 			if( self.loading > 1 ){
// 				callback();
// 				return;
// 			}
    
//                 var url = $scope.all_product_categories+'?category=' + encodeURIComponent(query);
      
//                 fetch(url)
//                     .then(response => 
//                         response.json()
//                         )
//                     .then(json => {
                       
//                         callback(json.items);
//                         self.settings.load = null;
//                     }).catch(()=>{
//                         callback();
//                     });
    
//             },
            
//             // custom rendering functions for options and items
//            render: {
//                 option: function(data, escape) {
//                     return '<div>' +
//                             '<span class="title">' + escape(data.title) + '</span>' +
//                             '<span class="url">' + escape(data.id) + '</span>' +
//                         '</div>';
//                 },
//                 item: function(data, escape) {
//                     return '<div title="' + escape(data.id) + '">' + escape(data.title) + '</div>';
//                 }
//             },
//             onChange : function(data){
//                 $scope.data.product_category_id = data;

//                 const mydivclass = document.querySelector('#select-repo2');
// // if 'hasClass' is exist on 'mydivclass'
// if(!mydivclass.classList.contains('ts-hidden-accessible')) {
//     // do something if 'hasClass' is exist.
//     $scope.init_select2_products(data);
// }


//                 // new TomSelect("#select-repo2").destroy();
                
//             }
//         });

    }


    $scope.init_select2_products = () => {

        var id = $scope.data.product_category_id;

        $('#products').select2({
            ajax: {
                url: location.origin+'/products-by-category/'+ id,
                data: function (params) {

                    var query = {
                        category: params.term
                    }
                    return query;
                },
                dataType: 'json',
            },
            placeholder: "Select a Product",
            
        }).on('select2:select', function (event) {
            
            $scope.data.product_id = event.target.value;
            
            $(this).val(null).trigger("change");

            var found = 0;
          
            $scope.data.products.forEach(element => {
                if($scope.data.product_id==element.id){
                    found++;
                }
            });

            if(found==0 && $scope.data.product_id!=''){
                $scope.add_product_to_order($scope.data.product_id);
            }
 
            
       

        });

    

        // new TomSelect('#select-repo2',{
        //     valueField: 'id',
        //     searchField: 'title',
        //     // // fetch remote data
        //     load: function(query, callback) {
    
        //         var url = location.origin+'/products-by-category/'+ id;
      
        //         fetch(url)
        //             .then(response => 
        //                 response.json()
        //                 )
        //             .then(json => {

        //                 callback(json.items);
                        
        //             }).catch(()=>{
        //                 callback();
        //             });
    
        //     },
            
        //     // custom rendering functions for options and items
        //    render: {
        //         option: function(data, escape) {
        //             return '<div>' +
        //                     '<span class="title">' + escape(data.title) + '</span>' +
        //                     '<span class="url">' + escape(data.id) + '</span>' +
        //                 '</div>';
        //         },
        //         item: function(data, escape) {
        //             return '<div title="' + escape(data.id) + '">' + escape(data.title) + '</div>';
        //         }
        //     },
        //     onChange : function(data){
        //         $scope.data.product_id = data;
        //               var found = 0;
          
        //     $scope.data.products.forEach(element => {

        //         if($scope.data.product_id==element.id){
        //             found++;
        //         }
        //     });

        //     if(found==0){
        //         $scope.add_product_to_order($scope.data.product_id);
        //     }
        //     }
        // });

    }

    $scope.add_product_to_order = (id) => {
    
        if(id!='' || id!=undefined){
  
        $http.get(location.origin+'/product-by-id/'+ id)
        .then((response) => {
                $scope.data.products.push(response.data.data);
                $scope.data.products.forEach(element => {
                    element.gross_total = 0;
                });
        })
        .catch((error) => {
            // pnotify('Error', getErrorAsString(error.data), 'error');
        });
                  
    }
    }

    $scope.removeProduct = (id) =>{
        if($scope.data.products.length >= 1){
            $scope.data.products.splice(id,1);
        }
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

    $scope.calculateTotal = () => {
        $scope.data.total = 0;
        $scope.data.total_discount = 0;
        $scope.data.gross_total = 0;
        $scope.data.sub_total = 0;
        // $scope.data.handling_fee = 0;

        $scope.data.products.forEach(element => {

            element.price = Math.abs(element.price);
            let discount = 0;
            if(element.discountType==1){
                discount = element.price*(element.discount/100);
            }
            else if(element.discountType==2){
                discount = element.discount;
            }


            element.gross_total = (element.price-discount)*element.quantity;
            element.total_display = element.price*element.quantity;
            // element.discount = discount;
            $scope.data.total_discount += element.quantity*discount;
            $scope.data.total += element.gross_total;
            $scope.data.gross_total += element.total_display;
        });


        $scope.data.sub_total  = $scope.data.total;
    }

    $scope.init_select2_customers = () =>{

       
        $('#customer_id').select2({
            ajax: {
                url: $scope.all_customers,
                data: function (params) {
                var query = {
                    search: params.term
                }

                // Query parameters will be ?search=[term]&type=public
                return query;
                },
                dataType: 'json',
            },
            // minimumInputLength: 1,
       
            }).on('change', function (event) {
                $scope.data.customer_id_ = $(this).val();
                $scope.get_customer($(this).val());
            });

           
    }


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

    $scope.get_customer = (id) => {
        $http.get(location.origin+'/customer-by-id/'+ id)
        .then((response) => {
            $scope.data.customer = response.data.data;
        })
        .catch((error) => {
            // pnotify('Error', getErrorAsString(error.data), 'error');
        });
    }

    $scope.addPayment = () =>{
        var new_payment = {};
        $scope.data.payments.push(new_payment);
    }

    $scope.removePayment = function (id) { // remove dynamic fieldsto cargo details
        if ($scope.data.payments.length > 1){
            $scope.data.payments.splice(id,1);
            $scope.calculatePaymentTotal();

            $scope.data.payments.forEach(element => {
                if(element.receiptGroup == 6){
                    $scope.is_credit_payment =  true;
                    $scope.keep_credits_open = true;
                }else{
                    $scope.is_credit_payment =  false;
                    $scope.keep_credits_open = false;

                    $scope.data.crns.forEach(element => {
                        element.paid = 0;
                    });

                }
            });

           
        }

        
       
    }
});
