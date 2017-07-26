/**
 * Created by ZSQ on 2016/9/14.
 */

var dataObj = "";

var isHandShake = false;

var qrcode_path = "getqrcode.php";

var uid;

var qid;

var ip =  document.location.hostname;

var ws = new WebSocket("ws://" + ip +":2345");

ws.onopen = handle_on_open;

ws.onerror = function(error){
    console.log("WebSocket Error" + error.data);
};

ws.onmessage = receive;

ws.onclose = function(e) {
    console.log("connect close : " + e.data);
};


function checkConnection()
{
    return isHandShake;
}

function handle_on_open(e)
{
    isHandShake = true;
    console.log("握手成功");
    create_qrcode();
}

function receive(e)
{
    dataObj = JSON.parse(e.data);

    doAction();
}

function handle_send(json)
{
    if(!checkConnection()) {
        return false;
    }

    ws.send(JSON.stringify(json));
}

function doAction()
{
    var action = dataObj.action;

    if(!isExitsFunction(action)) {
        console.log("Action : " + action + "不存在");
    } else {
        var func = action + "()";

        eval(func);
    }

}

function isExitsFunction(funcName) {
    try {
        if (typeof(eval(funcName)) == "function") {
            return true;
        }
    } catch(e) {}
    return false;
}

//生成二维码
function create_qrcode()
{
    if(isNull(uid) == "") {
        get_connection_uid();
    }

    if(isNull(qid) == "") {
        get_qid();
    }
}

function complete_create_qrcode()
{
    var path = "sendClient.php";
    var props = {"path" : path,"qid" : qid, "receive_uid" : uid};
    var src = qrcode_path + "?props=" + JSON.stringify(props);
    O("qrcode").firstChild.src = src.toString();
}

function show_connection_uid()
{
    uid = dataObj.uid;
}

function show_qid()
{
    qid = dataObj.qid;

    complete_create_qrcode();
}

function show_msg()
{
    console.log("you received : " + dataObj.msg);

    var showObj = O('show');

    showObj.innerText = dataObj.msg.toString();
}

var alpha = 0;
var beta = 0;
var gamma = 0;

function show_orientation()
{
    alpha = dataObj.alpha;
    beta = dataObj.beta;
    gamma = dataObj.gamma;

    O("alpha").innerText = alpha;
    O("beta").innerText = beta;
    O("gamma").innerText = gamma;

    create_rect(alpha);
}

function get_connection_uid()
{
    var data = {"action" : "get_connection_uid", "dir" : "server"};
    handle_send(data);
}

function get_qid()
{
    var data = {"action" : "get_connection_qid", "dir" : "server"};
    handle_send(data);

}

function isNull(data){
    return (data == "" || data == undefined || data == null) ? "" : data;
}

function send()//发送按钮事件
{
    var msg = O("sendtext").value;

    var data = {"action" : "show_msg", "msg" : msg, "dir" : "sendClient"};

    if(!msg) {
        alert("内容不能为空");
        return false;
    }

    handle_send(data);

    console.log("you sent : " + data.msg);
}

function O(name)
{
    if(typeof name === "Object") {
        return name;
    }

    return document.getElementById(name);
}
