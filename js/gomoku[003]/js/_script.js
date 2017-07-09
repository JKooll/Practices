var chess = $('#chess')[0];
var context = chess.getContext('2d');

var play1 = null;
var play2 = null;

//游戏是否结束
var over = false;

//黑子先手
var me = true;

//保存当前棋局
var chessBoard = [];

//赢法数组
var wins = [];

//赢法个数
var count = 0;

//赢法统计数组
var otherWin = [];
var myWin = [];

//onclick
var click = {x : 0, y : 0};

//now
var now = true;

//绘制棋盘
DrawChessBoard = function () {
    this.draw = function () {
        var logo = new Image();
        logo.src = "src/logo.png";
        logo.onload = function () {
            context.drawImage(logo, 0, 0, 450, 450);
            drawChessBoard();
        }
    }

    var drawChessBoard = function () {
        context.strokeStyle = '#BFBFBF';

        for (var i = 0; i < 15; i++) {
            context.moveTo(15 + i * 30, 15);
            context.lineTo(15 + i * 30, 435);
            context.stroke();

            context.moveTo(15, 15 + i * 30);
            context.lineTo(435, 15 + i * 30);
            context.stroke();
        }
    }
}

//初始化游戏
Init = function () {
    //初始化棋盘
    for (var i = 0; i < 15; i++) {
        chessBoard[i] = [];
        for (var j = 0; j < 15; j++) {
            chessBoard[i][j] = 0;
        }
    }

    //初始化赢法数组
    for (var i = 0; i < 15; i++) {
        wins[i] = [];
        for (var j = 0; j < 15; j++) {
            wins[i][j] = [];
        }
    }

    //初始化所有赢法
    count = 0;
    //所有横线的赢法
    for (var i = 0; i < 15; i++) {
        for (var j = 0; j < 11; j++) {
            for (var k = 0; k < 5; k++) {
                wins[i][j + k][count] = true;
            }
            count++;
        }
    }
    //所有竖线的赢法
    for (var i = 0; i < 15; i++) {
        for (var j = 0; j < 11; j++) {
            for (var k = 0; k < 5; k++) {
                wins[j + k][i][count] = true;
            }
            count++;
        }
    }
    //所有斜线
    for (var i = 0; i < 11; i++) {
        for (var j = 0; j < 11; j++) {
            for (var k = 0; k < 5; k++) {
                wins[i + k][j + k][count] = true;
            }
            count++;
        }
    }
    //所有反斜线
    for (var i = 0; i < 11; i++) {
        for (var j = 14; j > 3; j--) {
            for (var k = 0; k < 5; k++) {
                wins[i + k][j - k][count] = true;
            }
            count++;
        }
    }

    //赢法的统计数组初始化
    for (var i = 0; i < count; i++) {
        otherWin[i] = 0;
        myWin[i] = 0;
    }

    me = true;

    over = false;

    play1 = null;
    play2 = null;

    //初始化click坐标
    click.x = 0;
    click.y = 0;
}


//绘制棋子
var onStep = function (i, j, me) {
    context.beginPath();
    context.arc(15 + i * 30, 15 + j * 30, 13, 0, 2 * Math.PI);
    context.closePath();
    var gradient = context.createRadialGradient(15 + i * 30 + 2, 15 + j * 30 + 2, 13, 15 + i * 30 + 2, 15 + j * 30 + 2, 0);
    if (me) {
        gradient.addColorStop(0, "#0A0A0A");
        gradient.addColorStop(1, "#636766");
    } else {
        gradient.addColorStop(0, "#D1D1D1");
        gradient.addColorStop(1, "#F9F9F9");
    }

    context.fillStyle = gradient;
    context.fill();
}

//下棋
chess.onclick = function (e) {
    if (over) {
        alert('Game Over!');
        return;
    }

    if (!(play1 instanceof Human) && !(play2 instanceof Human)) {
        return;
    }

    var x = e.offsetX;
    var y = e.offsetY;

    var i = Math.floor(x / 30);
    var j = Math.floor(y / 30);

    if (chessBoard[i][j] === 0) {
        click.x = i;
        click.y = j;
    }

    play();
}

function Human(name, myWin) {
    this.name = name;

    this.me = false;

    this.myWin = myWin;

    this.myTurn = false;

    this.otherWin = null;

    this.judge = function(otherWin) {
        this.otherWin = otherWin;
        var i = click.x;
        var j = click.y;
        onStep(i, j, this.me);
        chessBoard[i][j] = 1;
        for(var k = 0; k < count; k++) {
            if(wins[i][j][k]) {
                myWin[k]++;
                otherWin[k] = 6;
                if(myWin[k] == 5) {
                    window.alert("你赢了");
                    over = true;
                }
            }  
        }
    }
}

function AI(name, myWin) {
    this.name = name;

    this.me = false;

    this.myTurn = false;

    this.myWin = myWin;

    this.otherWin = null;

    this.judge = function (otherWin) {
        this.otherWin = otherWin;
        var otherScore = [];
        var aiScore = [];
        var max = 0;
        var u = 0, v = 0;
        //初始化myScore和otherScore
        for (var i = 0; i < 15; i++) {
            otherScore[i] = [];
            aiScore[i] = [];
            for (var j = 0; j < 15; j++) {
                otherScore[i][j] = 0;
                aiScore[i][j] = 0;
            }
        }
        for (var i = 0; i < 15; i++) {
            for (var j = 0; j < 15; j++) {
                if (chessBoard[i][j] == 0) {
                    for (var k = 0; k < count; k++) {
                        if (wins[i][j][k]) {
                            if (this.otherWin[k] == 1) {
                                otherScore[i][j] += 200;
                            } else if (this.otherWin[k] == 2) {
                                otherScore[i][j] += 400;
                            } else if (this.otherWin[k] == 3) {
                                otherScore[i][j] += 2000;
                            } else if (this.otherWin[k] == 4) {
                                otherScore[i][j] = 10000;
                            }

                            if (this.myWin[k] == 1) {
                                myScore[i][j] += 220;
                            } else if (this.myWin[k] == 2) {
                                myScore[i][j] += 420;
                            } else if (this.myWin[k] == 3) {
                                myScore[i][j] += 2200;
                            } else if (this.myWin[k] == 4) {
                                myScore[i][j] = 20000;
                            }
                        }
                    }
                    if (otherScore[i][j] > max) {
                        max = otherScore[i][j];
                        u = i;
                        v = j;
                    } else if (otherScore[i][j] == max) {
                        if (myScore[i][j] > myScore[u][v]) {
                            u = i;
                            v = j;
                        }
                    }

                    if (myScore[i][j] > max) {
                        max = myScore[i][j];
                        u = i;
                        v = j;
                    } else if (myScore[i][j] == max) {
                        if (otherScore[i][j] > otherScore[u][v]) {
                            u = i;
                            v = j;
                        }
                    }
                }
            }
        }
        onStep(u, v, false);
        chessBoard[u][v] = 2;

        for (var k = 0; k < count; k++) {
            if (wins[u][v][k]) {
                myWin[k]++;
                otherWin[k] = 6;
                if (myWin[k] == 5) {
                    window.alert("计算机赢了");
                    over = true;
                }
            }
        }
    }

}

var rule = function () {
    var name = play1.name + ' vs ' + play2.name;

}

//人机对战
var HumanVSAI = function () {
}

//AI vs AI
var AIvsAI = function () {

}

var play = function () {
    if(play1.myTurn) {
        play1.judge(play2.myWin);
    }
    play1.myTurn = !play1.myTurn;

    if(play2.myTurn) {
        play2.judge(play1.myWin);
    }
    play2.myTurn = !play2.myTurn;
}

var test = function () {
}

//初始化游戏
Init();

var drawChessBoard = new DrawChessBoard();

drawChessBoard.draw();

var play1 = new Human('Jerry', myWin, otherWin);

play1.me = true;
play1.myTurn = true;

var play2 = new AI('AI_Tom', myWin, otherWin);

play2.me = false;
play2.myTurn = false;
