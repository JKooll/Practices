var app = angular.module('myApp',[]);
app.controller('myHeader',function($scope,$interval){
    $scope.theTime = new Date().toLocaleTimeString();
    $interval(function(){
        $scope.theTime = new Date().toLocaleTimeString();
    },1000);
});

app.service('hexafy',function(){
    this.myFunc = function(x){
        return x.toString(16);
    }
});

app.controller('myCtrl', function($scope, hexafy) {
    $scope.num = 0;
    $scope.myTest = hexafy.myFunc(255);
});

app.filter('myFormat',['hexafy',function(hexafy){
    return function(x){
        return hexafy.myFunc(x);
    };
}]);

app.controller('getApiCtrl',function($scope,$http){
    $http({
        method: 'GET',
        url: 'http://localhost:8080/mylol/www/php/main.php'
    }).success(function (response){
        $scope.myTest = response;
    });
});

app.controller('selecteNameCtrl',function($scope,$http){
    var url = "http://localhost:8080/mylol/www/php/Customers.php"
    $http.get(url).success(function(response){
        $scope.names = response.records;
    });
});

app.controller('setHideCtrl',function($scope){
    $scope.myVar = false;
    $scope.toggle = function(){
        $scope.myVar = !$scope.myVar;
    }
})

app.controller('changeNameCtrl',function($scope){
    $scope.changeName = angular.uppercase($scope.name);
});

app.controller("myTestCtrl", function($scope) {
    $scope.firstName = "John";
    $scope.lastName = "Doe";
});
