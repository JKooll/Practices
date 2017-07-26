var mainState = {
    preload: function() {
        game.load.image('paddle', 'assets/paddle.png');
        game.load.image('brick', 'assets/brick.png');
        game.load.image('ball', 'assets/ball.png');
    },

    create: function() {
        game.stage.backgroundColor = '#3598db';

        game.physics.startSystem(Phaser.Physics.ARCADE);

        game.world.enableBody = true;

        this.left = game.input.keyboard.addKey(Phaser.Keyboard.LEFT);
        this.right = game.input.keyboard.addKey(Phaser.Keyboard.RIGHT);

        this.paddle = game.add.sprite(200, 400, 'paddle');

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
        if(this.left.isDown) {
            this.paddle.body.velocity.x = -300;
        } else if(this.right.isDown) {
            this.paddle.body.velocity.x = 300;
        } else {
            this.paddle.body.velocity.x = 0;
        }

        game.physics.arcade.collide(this.paddle, this.ball);

        game.physics.arcade.collide(this.ball, this.bricks, this.hit, null, this);

        if(this.ball.y > this.paddle.y) {
            alert('Game Over!!!');
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