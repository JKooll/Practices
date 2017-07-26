angular.module("mylol",[])
.controller('loginCtrl',function($scope,$http){
    $scope.result = [];
    $scope.submit = function(){
        var data = $scope.user;
            $http.post(server,data)
                    .success(function(response)
                    {
                        $scope.result= response.data;
                    }
                );
            }
    });
