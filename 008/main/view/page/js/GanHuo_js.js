/**
 * Created by ZSQ on 2016/8/5.
 */
var origin = 'http://sinacloud.net/yasi-001';
function run() {
    var url = getRootPath_web() + "/PageManger.php";
    var action = O( 'mark' ).value;
    var param = getParam( action );
    var request = ajaxGet( url , param);
    request.onreadystatechange = function (){
        if( this.readyState == 4 && this.status == 200){
            if( this.responseText != null ){
                var jsonObj = JSON.parse( this.responseText );
                var content = '';

                for( var i = 0 ; i < jsonObj.length ; i++){
                    content += "<li><a href=";
                    content += encodeURI(origin + jsonObj[ i ].path);
                    content += ">";
                    content += jsonObj[ i ].name;
                    content += "</a></li>";
                }

                O( "_list").innerHTML = content;
            }else{
                alert( "No data received!")
            }
        }
    };

    request.send( null );
}

function getParam( action )
{
    switch( action ){
        case 'ppt':
            return ganhuo_ppt();
            break;
        case 'weike':
            return ganhuo_weike();
            break;
        default :
            return '';
    }
}

function ganhuo_ppt()
{
    var param = [
        ["type" , "GanHuo" ],
        [ "action" , "getppts" ]
    ];

    return param;
}

function ganhuo_weike()
{
    var param = [
        ["type" , "GanHuo" ],
        [ "action" , "getweike" ]
    ];

    return param;
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