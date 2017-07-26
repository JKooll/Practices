/*
*references:
*Original source: https://yasicyu.com/newarticle/%E5%88%A9%E7%94%A8JS%E5%88%B6%E4%BD%9C%E7%AE%80%E5%8D%95%E7%9A%84ASCII%E5%9B%BE%E5%92%8C%E5%8D%95%E6%9E%81%E5%9B%BE?from=groupmessage
*Cnavas API: https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API
*/

//rgb to gray
function rgb2gray(r, g, b)
{
    return (r + g + b) * 0.333;
}

//main function
var monoImg = function(canvas, sourceImg) {
    canvas.width = sourceImg.width;
    canvas.height = sourceImg.height;

    var ctx = canvas.getContext('2d');

    ctx.drawImage(sourceImg, 0, 0);

    var imgData = ctx.getImageData(0, 0, sourceImg.width, sourceImg.height);

    var imgDataArray = imgData.data;

    //traverse each point
    for(var index = 0; index <= sourceImg.width * sourceImg.height * 4; index += 4) {
        var r = imgDataArray[index];
        var g = imgDataArray[index + 1];
        var b = imgDataArray[index + 2];

        var gray = rgb2gray(r,g,b);

        if(gray < 128) {
            imgData.data[index] = 0;
            imgData.data[index + 1] = 0;
            imgData.data[index + 2] = 0;
        } else {
            imgData.data[index] = 255;
            imgData.data[index + 1] = 255;
            imgData.data[index + 2] = 255;
        }
    }

    ctx.putImageData(imgData, 0, 0);
};

var canvas = document.getElementById('canvas');

var img = document.getElementById('img');

monoImg(canvas, img);
