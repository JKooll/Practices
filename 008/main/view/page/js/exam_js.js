/**
 * Created by ZSQ on 2016/7/30.
 */
function next_title() {
    var url = getRootPath_web() + "/PageManger.php";
    var param = [
        [ "type" , "ExeSys" ],
        [ "action" , "next_title" ]
    ];
    var request = ajaxGet( url , param );

    request.onreadystatechange = function (){
        if( this.readyState == 4){
            if( this.status == 200){
                if( this.responseText != null ){
                    response = this.responseText ;
                    var obj = JSON.parse( response );
                    O( "title" ).innerHTML = obj.title;
                    O( "title_id" ).value = obj.id;
                }else{
                    //TODO:do something
                }
            }else{
                alert( "Ajax error : " + this.statusText );
            }
        }
    };

    request.send( null );

}

function answer() {
    var url = getRootPath_web() + "/PageManger.php";
    var title_id = O( "title_id" ).value;
    var selects = C( "answer_check" );
    var select = '';
    for( var i = 0 ; i < selects.length ; ++i ){
        if( selects[ i ].checked ){
            select = selects[ i ].value;
            break;
        }
    }

    var param = [
        [ "type" , "ExeSys" ],
        [ "action" , "answer" ],
        [ "title_id" , title_id ],
        [ "select" , select ]
    ];

    removeNode( "answer_status" );
    removeNode( "answer_detail" );
    var div_answer_status = document.createElement( 'div' );
    div_answer_status.id = 'answer_status';
    div_answer_status.innerHTML = "结果：<br />";
    O( "main" ).appendChild( div_answer_status );

    var request = ajaxGet( url , param );

    request.onreadystatechange = function (){
        if( this.readyState == 4){
            if( this.status == 200){
                if( this.responseText != null ){
                    response = this.responseText ;
                    var obj = JSON.parse( response );
                    var result_code = obj.result_code;
                    if( result_code == 1){
                        O( "answer_status" ).innerHTML += obj.content;
                        if( obj.detail != '' ) {
                            var div_answer_detail = document.createElement("div");
                            div_answer_detail.id = "answer_detail";
                            div_answer_detail.innerHTML = "详解:<br />";
                            O( "main" ).appendChild(div_answer_detail);

                            O("answer_detail").innerHTML += obj.detail;
                        }
                    }else if(result_code == 0){
                        O( "answer_status" ).innerHTML += obj.content;
                    }
                }else{
                    //TODO:do something
                }
            }else{
                alert( "Ajax error : " + this.statusText );
            }
        }
    };

    request.send( null );
}

function removeNode( obj )
{
    var node = O( obj );
    if( node != null)
        node.parentNode.removeChild( node );
}

function O( obj )
{
    if( typeof obj == 'object' ){
        return obj;
    }
    return document.getElementById( obj );
}

function S( obj )
{
    return O(obj).style;
}

function C( name )
{
    var elements = document.getElementsByTagName( "*" );
    var objects = [];

    for( var i = 0 ;i < elements.length ; ++i){
        if( elements[ i ].className == name ){
            objects.push( elements[ i ] );
        }
    }

    return objects;
}
function getRootPath_web() {
    var rootDir = 'ecing';
    //获取当前网址，如： http://localhost:8083/uimcardprj/share/meun.jsp
    var curWwwPath = window.document.location.href;
    var url = '';
    var result = curWwwPath.split( '/' );
    for( var i = 0 ; i < result.length ; i++ ){
        if( result[ i ] == rootDir ){
            url = result.slice( 0 , i + 1 ).join( '/' );
        }
    }
    return url;
}

function ajaxPost( url , data )
{
    var request = new ajaxRequest();
    request.open( "POST" , url );
    request.setRequestHeader( "Content-type" , "application/x-www-form-urlencoded");
    request.setRequestHeader( "Content-length" , date.length );
    request.setRequestHeader( "Connection" , "close" );

    request.onreadystatechange = function (){
        if( this.readyState == 4){
            if( this.status == 200){
                if( this.responseText != null ){
                    return this.responseText;
                }else{
                    //TODO:do something
                }
            }else{
                alert( "Ajax error : " + this.statusText );
            }
        }
    };

    request.send( data );

}

function ajaxGet( url , param )
{
    var nocache = "nocache=" + Math.random() * 1000000;
    var request = new ajaxRequest();
    url += "?" + nocache;
    if( param.length != 0){
        for( var i = 0 ; i < param.length ; i++ ){
            url += "&" + param[ i ][ 0 ] + "=" + param[ i ][ 1 ];
        }
    }
    request.open( "GET" , url , true );

    return request;
}

function ajaxRequest() {
    var request = null;
    try{
        request = new XMLHttpRequest();
    }catch( e1 ){
        try{
            request = new ActiveXObject("Msxml2.XMLHTTP");
        }catch( e2 ){
            try{
                request = new ActiveXObject("Microsoft.XMLHTTP");
            }catch( e3 ){
                request = false;
            }
        }
    }

    return request;
}