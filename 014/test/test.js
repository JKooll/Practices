/**
 * Created by ZSQ on 2016/9/18.
 */
window.addEventListener('DOMContentLoaded', domcontentloaded);

function domcontentloaded()
{
    var canvas = document.getElementById('renderCanvas');

    var engine = new BABYLON.Engine(canvas, true);
}

var createScene = function() {
    var scene = new BABYLON.Scene(engine);

    var camera = new BABYLON.FreeCamera('camers1', new BABYLON.Vector3(0, 5, -10), scene);

    camera.setTarget(BABYLON.Vector3.Zero());

    camera.attachControl(canvas, false);

};