/**
 * Created by ZSQ on 2016/9/16.
 */
var game = new Phaser.Game(800, 600, Phaser.CANVAS, '', { create: create, render: render });

var circle;
var floor;

function create() {

    circle = new Phaser.Circle(game.world.centerX, 100,64);

}

function render () {

    game.debug.geom(circle,'#cfffff');
    game.debug.text('Diameter : '+circle.diameter,50,200);
    game.debug.text('Circumference : '+circle.circumference(),50,230);

}
