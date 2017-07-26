/**
 * Created by ZSQ on 2016/8/22.
 */
var path = '002/';

function exeupload()
{

}

function run()
{
    var url = getRootPath_web() + "/PageManger.php";

    var param = [
        ["type" , "Upload"],
        ["action" , "getuploadurl"]
    ];
    var upload_url = "";
    var request = ajaxGet( url , param );
    request.onreadystatechange = function (){
        if( this.readyState == 4 &&　this.status == 200){
            if( this.responseText != null ){
                upload_url = this.responseText;
                O( 'f1' ).action = upload_url;
            }
        }
    };
    request.send( null );

    param = [
        ["type","Upload"],
        ["action","getparams"],
        ["path",path]
    ];

    var params = "";
    request = ajaxGet( url , param );
    request.onreadystatechange = function (){
        if( this.readyState == 4 &&　this.status == 200){
            if( this.responseText != null ){
                params = JSON.parse( this.responseText );
                var content = "";
                for(var i =0 ; i < params.length ; i++) {
                    content += "<input type=\"hidden\" name=\"";
                    content += params[ i ][ 'key' ];
                    content += " \"value=\"";
                    content += params[ i ][ 'val' ];
                    content += "\"/>";
                }
                content += " <input type=\"file\" name=\"file\" />&#160;<input type=\"submit\" value=\"Upload\" />";
                O('f1').innerHTML = content;
            }
        }
    };
    request.send(null);
}

function change()
{
    var obj = O( 'path' );
    var index = obj.selectedIndex;
    path = obj.options[index].value;
    run();
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

function ajaxRequest()
{
    var request = null;
    try{
        request = new XMLHttpRequest();
    }catch( e1 ){
        try{
            request = new ActiveXObject("Msml2.XMLHTTP");
        }catch (e2){
            try{
                request = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(e3){
                request = false;
            }
        }
    }

    return request;
}