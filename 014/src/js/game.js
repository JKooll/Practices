/**
 * Created by ZSQ on 2016/9/17.
 */

var canvas = document.getElementById('view');

canvas.width = 800;
canvas.height = 600;
canvas.style.backgroundColor = '#7B68EE';

var ctx = canvas.getContext('2d');

ctx.fillStyle = '#FF0000';

var old_angle = 0;

function create_rect(angle)
{
    ctx.clearRect(300 - 1, 200 - 1, 10 + 2, 50 + 2);

    ctx.translate(300 + 10 / 2, 200 + 50 / 2);

    ctx.rotate((old_angle - angle) * Math.PI / 180);

    ctx.translate(-300 - 10 / 2, -200 - 50 / 2);

    ctx.fillRect(300, 200, 10, 50);

    old_angle = angle;
}

function stroke()
{

    ctx.rotate(20 * Math.PI / 180);

    ctx.beginPath();

    ctx.moveTo(20, 20);

    ctx.lineTo(20, 100);

    ctx.lineTo(70, 100);

    ctx.lineTo(70, 20);

    ctx.closePath();

    ctx.stroke();
}

create_rect();
