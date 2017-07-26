angular.module('myApp.myControllers', [])

.controller('changeTabCtrl', function($scope,$ionicNavBarDelegate,$state) {
    $scope.changeTab = function(title){
        $state.go(title);
    };
})

.controller('meMainCtrl',function($scope,myQuery){
    $scope.getImg = function(){
        var data = {msgType : 'ChampionENName',id : '100'};
        myQuery.getImg(data,$scope);
    };
})

.controller('queryMainCtrl',function($scope,$http,my_checkMsgType,myQuery){
})

.controller('queryMainCtrl.queryUserCombatList',function($scope,myQuery){
    //获取大区列表
    myQuery.queryArea($scope);

    $scope.submit = function(){
        //获取用户信息
        var data = $scope.user;
        //获取结果
        myQuery.queryCombatList(data,$scope);
    };
})
