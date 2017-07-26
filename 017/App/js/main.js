var mainState = {
    preload: function() {
        game.load.image('paddle', '../assets/paddle.png');
        game.load.image('brick', '../assets/brick.png');
        game.load.image('ball', '../assets/ball.png');
    },

    create: function() {
        this.client = new Client();
        this.client.openConnection();
        this.paddle_present = .5;
        this.client.mainstate = this;

        game.stage.backgroundColor = '#3598db';

        game.physics.startSystem(Phaser.Physics.ARCADE);

        game.world.enableBody = true;

        /*this.left = game.input.keyboard.addKey(Phaser.Keyboard.LEFT);
        this.right = game.input.keyboard.addKey(Phaser.Keyboard.RIGHT);*/

        this.paddle_x = 400;
        this.paddle_y = 400;

        this.paddle = game.add.sprite(this.paddle_x * this.paddle_present, this.paddle_y, 'paddle');

        this.paddle.body.immovable = true;

        this.bricks = game.add.group();

        for(var i = 0; i < 5; i++) {
            for(var j = 0; j < 5; j++) {
                var brick = game.add.sprite(30 + i * 70, 55 + j * 25, 'brick');

                brick.body.immovable = true;

                this.bricks.add(brick);
            }
        }

        this.ball = game.add.sprite(200, 300, 'ball');

        this.ball.body.velocity.x = 200;
        this.ball.body.velocity.y = 200;

        this.ball.body.bounce.setTo(1);
        this.ball.body.collideWorldBounds = true;
    },

    update: function() {
        /*if(this.left.isDown) {
            this.paddle.body.velocity.x = -300;
        } else if(this.right.isDown) {
            this.paddle.body.velocity.x = 300;
        } else {
            this.paddle.body.velocity.x = 0;
        }*/
        console.log(this.paddle.x);
        this.paddle.x = this.paddle_x * this.paddle_present;

        game.physics.arcade.collide(this.paddle, this.ball);

        game.physics.arcade.collide(this.ball, this.bricks, this.hit, null, this);

        if(this.ball.y > this.paddle.y) {
            //alert('Game Over!!!');
            //game.state.start('main');
        }
    },

    hit: function(ball, brick) {
        brick.kill();
    }
};

var game = new Phaser.Game(400, 500);
game.state.add('main', mainState);
game.state.start('main');

var ip = config.ip;
var port = config.port;
var connection_id;

function Client() {
    this.mainstate = null;
}

Client.prototype.openConnection = function() {
    this.ws = new WebSocket("ws://" + ip + ":" + port);
    this.connected = false;
    this.ws.onmessage = this.onMessage.bind(this);
    this.ws.onerror = this.displayError.bind(this);
    this.ws.onopen = this.connectionOpen.bind(this);
};

Client.prototype.connectionOpen = function() {
    this.connected = true;
    console.log("连接成功");
    var getqrcode = {"action" : "getqrcode", "url" : document.URL};
    this.ws.send(JSON.stringify(getqrcode));
};

Client.prototype.onMessage = function(e) {
    var data = JSON.parse(e.data);

    if(data.type == "qrcode") {
        return getQrCode(data.src);
    }

    if(!isNaN(data.content)) {
        this.mainstate.paddle_present = data.content / 100;

        //console.log(data.content / 100);
    }

    console.log(data.content / 100);
};

Client.prototype.displayError = function(err) {
    console.log('Websocketerror: ' + err);
};

function getQrCode(src)
{
    var img = document.createElement("img");
    img.setAttribute('src', src);
    document.body.appendChild(img);
}

/*var client = new Client();
client.openConnection();*/
