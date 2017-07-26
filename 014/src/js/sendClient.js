/**
 * Created by ZSQ on 2016/9/16.
 */
//连接服务器
var dataObj;

var qid;

var uid;

var isHandShake = false;

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
    get_qid();
    get_uid();
    bind_send_to_receive();
}

function receive(e)
{
    dataObj = JSON.parse(e.data);

    doAction();
}

function handle_send(json)
{
    json.qid = qid;
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

function show_msg()
{
    console.log("you received : " + dataObj.msg);

    var showObj = O('show');

    showObj.innerText = dataObj.msg;
}

function bind_send_to_receive()
{

    if(uid == '') {
        console.log("receive_uid为空");
    } else if(!checkConnection()) {
        console.log("未连接服务器");
    } else {
        var data = {"action" : "bind_send_to_receive" , "receive_uid" : uid, "dir" : "server"};
        handle_send(data);
    }
}

function get_uid()
{
    uid = O("uid").value;
}

function get_qid()
{
    qid = O("qid").value;
}

//按钮事件
function send()
{
    var msg = O("send").value;


    var data = {"action" : "show_msg","msg" : msg, "dir" : "receive"};

    handle_send(data);
}


//监听设备
var alpha = 0;
var beta = 0;
var gamma = 0;

function handleOrientation(orientData)
{
    var temp_alpha = parseInt(orientData.alpha);
    var temp_beta = parseInt(orientData.beta);
    var temp_gamma = parseInt(orientData.gamma);

    //降低发送相同信息次数，减轻服务器压力，解决信息发送间断现象
    if(temp_alpha != alpha || temp_beta != beta || temp_gamma != gamma) {
        alpha = temp_alpha;
        beta = temp_beta;
        gamma = temp_gamma;

        send_orientation();
    }

    show();
}

function send_orientation()
{
    var data = {"action" : "show_orientation", "qid" : qid, "alpha" : alpha, "beta" : beta, "gamma" : gamma, "dir" : "receive"};
    handle_send(data);
}

function show()
{
    O("alpha").innerText = alpha;
    O("beta").innerText = beta;
    O("gamma").innerText = gamma;
}

function O(name)
{
    if(typeof name == "Object") {
        return name;
    }

    return document.getElementById(name);

}

window.addEventListener("deviceorientation", handleOrientation, true);


