angular.module('myApp', ['ionic','myApp.myControllers','myApp.myServices'])

.config(function($stateProvider){
    $stateProvider
        .state('me',{
            templateUrl:'templates/me/main.html'
        })
        .state('query',{
            templateUrl:'templates/query/main.html',
        })
        .state('friends',{
            templateUrl:'templates/friends/main.html'
        })
        .state('discover',{
            templateUrl:'templates/discover/main.html'
        });
})
