
app.controller('HomeController', ($scope, $http, Loader, $timeout) => {

    $scope.data = {};


    $scope.init = () => {

        $http.get($scope.url)
            .then((response) => {

                $scope.data = response.data.data;

                $scope.drawRevenueSparkLines();
                $scope.drawTotalRevenueCard();

                if (typeof (initDone) == 'function') {
                    initDone($scope.data);
                }

            })
            .catch((error) => {
                // pnotify('Error', getErrorAsString(error.data), 'error');
            });

    };



    $scope.drawRevenueSparkLines = () => {

        $("#sparkline-revenue").sparkline($scope.data.monthlyRevenue, {
            type: 'line',
            width: '99.5%',
            height: '100',
            lineColor: '#5969ff',
            fillColor: '#dbdeff',
            lineWidth: 2,
            spotColor: undefined,
            minSpotColor: undefined,
            maxSpotColor: undefined,
            highlightSpotColor: undefined,
            highlightLineColor: undefined,
            resize: true
        });

        $("#sparkline-revenue2").sparkline($scope.data.weeklyRevenue, {
            type: 'line',
            width: '99.5%',
            height: '100',
            lineColor: '#ff407b',
            fillColor: '#ffdbe6',
            lineWidth: 2,
            spotColor: undefined,
            minSpotColor: undefined,
            maxSpotColor: undefined,
            highlightSpotColor: undefined,
            highlightLineColor: undefined,
            resize: true
        });

        $("#sparkline-revenue4").sparkline($scope.data.monthlyOrders, {
            type: 'line',
            width: '99.5%',
            height: '100',
            lineColor: '#fec957',
            fillColor: '#fff2d5',
            lineWidth: 2,
            spotColor: undefined,
            minSpotColor: undefined,
            maxSpotColor: undefined,
            highlightSpotColor: undefined,
            highlightLineColor: undefined,
            resize: true,
        });
    }

    $scope.drawTotalRevenueCard = () => {
          // ============================================================== 
    // Total Revenue
    // ============================================================== 

    // $scope.data.lastFiveYears
    // $scope.data.lastFiveYearsRevenue

    // $scope.data.lastFiveYears = $scope.data.lastFiveYears.concat($scope.data.lastFiveYears, $scope.data.lastFiveYearsRevenue);
    // console.log($scope.data.lastFiveYears);

    Morris.Area({
        element: 'morris_totalrevenue',
        behaveLikeLine: true,
        data:$scope.data.lastFiveYears,
        xkey: 'x',
        ykeys: ['y'],
        labels: ['Y'],
        lineColors: ['#5969ff'],
        resize: true

    });

      // ============================================================== 
    // Revenue By Categories
    // ============================================================== 

    var chart = c3.generate({
        bindto: "#c3chart_category",
        data: {
            columns: $scope.data.columns,
            type: 'donut',

            // onclick: function(d, i) { console.log("onclick", d, i); },
            // onmouseover: function(d, i) { console.log("onmouseover", d, i); },
            // onmouseout: function(d, i) { console.log("onmouseout", d, i); },

            // colors: {
            //     Men: '#5969ff',
            //     Women: '#ff407b',
            //     Accessories: '#25d5f2',
            //     Children: '#ffc750',
            //     Apperal: '#2ec551',



            // }
        },
        donut: {
            label: {
               show: true
            }
        },



    });


    // ============================================================== 
        // Product Sales
        // ============================================================== 

        new Chartist.Bar('.ct-chart-product', {
            labels: ['Q1', 'Q2', 'Q3', 'Q4'],
            series: [
                [800000, 1200000, 1400000, 1300000],
                [200000, 400000, 500000, 300000],
                [100000, 200000, 400000, 600000]
            ]
        }, {
            stackBars: true,
            axisY: {
                labelInterpolationFnc: function(value) {
                    return (value / 1000) + 'k';
                }
            }
        }).on('draw', function(data) {
            if (data.type === 'bar') {
                data.element.attr({
                    style: 'stroke-width: 40px'
                });
            }
        });

    }
});
