/**
 * Created by ZSQ on 2016/7/31.
 */
function trans()
{
    var url = getRootPath_web() + "/PageManger.php";
    var toBeTrans = O("ready_trans").value;
    var trans_method = O( "trans_method" ).value;
    var param = [
        [ "type" , "Translation" ],
        [ "action" , "trans" ],
        [ "toBeTrans" , toBeTrans ],
        [ "trans_method" , trans_method ]
    ];

    var request = ajaxGet( url , param );
    request.onreadystatechange = function (){
        if( this.readyState == 4 &&　this.status == 200){
            if( this.responseText != null ){
                O( "result_trans" ).value = this.responseText;
            }
        }
    };

    request.send( null );
}

function test()
{
    alert(document.getElementById( "trans_method" ).value);
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
    var start_pos = 0;
    var end_pos = curWwwPath.indexOf( "/" );
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