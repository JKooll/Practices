/**
 * Created by ZSQ on 2016/8/4.
 */
var origin = 'http://sinacloud.net/yasi-001';
function run()
{
    var mark = O("mark");
    switch(mark.value){
        case "kewen":
            diyKewen();
            break;
        case "opera":
            diyOpera();
            break;
        case "music":
            diyMusic();
            break;
        case "ad":
            diyAd();
            break;
        default:
            break;
    }
}

function diyKewen()
{
    var param = [
        [ "type" , "DIY" ],
        [ "diy_id" , "kewen"]
    ];

    getMsg( param);
}

function diyOpera()
{
    var param = [
        ["type" , "DIY"],
        [ "diy_id" , "opera"]
    ];

    getMsg(param);
}

function diyMusic()
{
    var param = [
        [ "type" , "DIY" ],
        [ "diy_id" , "music" ]
    ];

    getMsg( param );
}

function diyAd()
{
    var param = [
        [ "type" , "DIY" ],
        [ "diy_id" , "ad" ]
    ];

    getMsg( param );
}

function getMsg( param)
{
    var url = getRootPath_web() + "/PageManger.php";
    var request = ajaxGet( url , param );
    request.onreadystatechange = function (){
        if( this.readyState == 4){
            if( this.status == 200){
                if( this.responseText != null ){
                    var _json = JSON.parse( this.responseText );
                    var content = "";
                    for( var i = 0 ; i < _json.length ; i++){
                        if( i == 0){
                            check( _json[ i ].name , _json[ i ].path );
                        }
                        content += "<option value=" + _json[i].path + ">" + _json[ i ].name+"</option>"
                    }
                    O( "items" ).innerHTML = content;
                }else{
                    alert( "Ajax error : No date received");
                }
            }else{
                alert( "Ajax error : " + this.statusText);
            }
        }
    };

    request.send( null );
}

function check( text , value )
{
    O( "video_title" ).innerText = text;
    O( "video_src" ).src = origin + value;
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