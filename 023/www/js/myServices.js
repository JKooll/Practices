angular.module('myApp.myServices', [])
.filter('changeMsgType',['my_checkMsgType',function(my_checkMsgType){
    return function(msgType){
        return my_checkMsgType.englishName(msgType);
    };
}])

.factory('my_checkMsgType',function(){
    var msgTypes = [
        {chinese : '大区' , english : 'area'},
        {chinese : '用户基本' , english : 'userHotInfo'},
        {chinese : '用户详细' , english : 'userExtInfo'}
    ];

    return {
        englishName : function(msgtype){
            var has = 0;
            for(var i = 0; i < msgTypes.length; i++){
                if(msgTypes[i].chinese == msgtype){
                    return msgTypes[i].english;
                }
            }

            if(has == 0)
                return "没有";
        }
    };
})

.factory('myQuery',function($http){
    return {
        queryArea : function(scope){
            var data = {msgType : 'Area'};
            $http.post(server,data)
                    .success(function(response){
                        scope.options = response;
                    }
                )
                .error(function(){
                    return "error";
                });
        },

        queryUserArea : function(data,scope){

        },

        queryCombatList : function(data,scope){

            data.msgType = 'CombatList';
            data.q = 1;
            $http.post(server,data)
                    .success(function(response){
                        scope.combatList = response;
                    }
                )
                .error(function(){
                    alert("error");
                });
        },

        getImg : function(data,scope){
            $http.post(server,data)
                    .success(function(response){
                        scope.result = response;
                    })
                    .error(function(){
                        alert("error");
                    });
        }

    };
})
