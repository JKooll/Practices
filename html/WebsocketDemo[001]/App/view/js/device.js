//var ip = '52.42.239.114';
var ip = config.ip;
var port = config.port;

ws = new WebSocket("ws://" + ip + ":" + port);

ws.onopen = function() {
    console.log("connection succeeded!");
    ws.send(requestBind());
};

ws.onmessage = function(e) {
    var div = document.getElementsByTagName('div')[0];
    div.innerText = "收到服务端的消息：" + JSON.parse(e.data).content;
};

window.addEventListener('input', function (e) {
    e.preventDefault();
    console.log(e.target.value);
    sendMessage(e.target.value);
}, false);

function requestBind()
{
    $room_id = document.getElementsByName('room_id')[0].value;
    return JSON.stringify({'action' : 'bind', 'room_id' : $room_id});
}

function sendMessage(con)
{
    var content = con;
    var msg = {"action" : "sendMessage", "content" : content};
    ws.send(JSON.stringify(msg));
}

