var width = 0; //棋盘宽度
var height = 0; //棋盘高度
var board = new Object(); //保存当前局面, <=0 : 障碍点, 1 : 未落子，2 落子
var canvas = null; //笔布
var size = 50; //画布放大的倍数
var padding = 25; //棋盘边框距离画布外边框的距离

$(function(){
    load_game();
});

function load_game()
{
    //初始化变量
    init();

    //绑定事件
    $("div[name=init_board] button[name=draw]").click(function(event) {
        get_board_size();
        init_board();
        draw_board();
    });

    $("div[name=set_obstacles] button[name=set]").click(function(event) {
        set_obstacles();
    });

    $("button[name=calculate]").click(function(event) {
        calculate();
    });
}

//初始化变量
function init()
{
    width = 0; //棋盘宽度
    height = 0; //棋盘高度
    board = []; //保存棋盘
    get_canvas();
}

//初始化棋盘
function init_board()
{
    for(let i = 0; i <= width; i++) {
        board[i] = [];//未落子
        for(let j = 0; j <= height; j++) {
            board[i][j] = 1;
        }
    }
}


//获取棋盘高度和宽度
function get_board_size()
{
    width = $("div[name=init_board] input:eq(0)").val();
    if(!width) {
        alert('请输入棋盘宽度');
        return false;
    }

    height = $("div[name=init_board] input:eq(1)").val();
    if(!height) {
        alert('请输入棋盘高度');
        return false;
    }
}

//绘制棋盘
function draw_board()
{
    if(!canvas) {
        get_canvas();
    }

    //设置画布大小
    canvas.attr({'width' : width * size + padding * 2, 'height' : height * size + padding * 2});

    //画竖线
    for(var i = 0; i <= width; i++) {
        canvas.drawLine({
                strokeStyle : '#000',
                strokeWidth : 1,
                x1 : i * size + padding, y1 : 0 * size + padding,
                x2 : i * size + padding, y2 : height * size + padding
            });
    }

    //画横线
    for(let j = 0; j <= height; j++) {
        canvas.drawLine({
                strokeStyle : '#000',
                strokeWidth : 1,
                x1 : 0 * size + padding, y1 : j * size + padding,
                x2 : width * size + padding, y2 : j * size + padding
            });
    }

    //画点
    for(let i = 1; i <= width; i++) {
        for(let j = 1; j <= height; j++) {
            //绘制障碍点
            if(board[i][j] === 0) {
                canvas.drawPolygon({
                    strokeStyle : '#483D8B',
                    strokeWidth : 2,
                    //画图总结公式
                    x : ((i - 0.5) * size + padding), y : ((j - 0.5) * size + padding),
                    radius : 10,
                    sides : 3
                });
            }
        }
    }

}

//获取画布
function get_canvas()
{
    canvas = $("#board");
}

//设置障碍点
function set_obstacles()
{
    if(!width || !height) {
        alert("请先初始化棋盘");
    }

    let set_x = $("div[name=set_obstacles] input[name=x]").val();

    let set_y = $("div[name=set_obstacles] input[name=y]").val();

    if(set_x > width || set_y > height) {
        alert("输入点无效,请输入x <= " + width + "y <= " + height);
        return false;
    }

    board[set_x][set_y] = 0;

    draw_board();
}

function calculate()
{
    let data = JSON.stringify(board);

    console.log(data);

    $.get('find_a_way.php', {'query' : data}, function(result, testStatus){
        alert(JSON.stringify(result));
    }, "json");
}
