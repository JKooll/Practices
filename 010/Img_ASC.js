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

//gray to ascii
function gray2asc(gray) {
    /*ASCII--I'mYasic*/
    /*32 64 96 128 160 192 224 256*/
    gray = 255 - gray;
    if (gray < 128){
        if (gray < 64){
            if (gray < 32){
                return '\''
            }
            else {
                return 'c'
            }
        }
        else {
            if (gray < 96){
                return 'i'
            }
            else {
                return 's'
            }
        }
    }
    else {
        if (gray < 192){
            if (gray < 160){
                return 'I'
            }
            else {
                return 'm'
            }
        }
        else {
            if (gray < 224){
                return 'a'
            }
            else {
                return 'Y'
            }
        }
    }
}

//main function
var img2ASC = function(canvas, sourceImg)
{
    console.log(sourceImg.width + " " + sourceImg.height);

    var ctx = canvas.getContext('2d');

    ctx.drawImage(img, 0, 0);

    var imgData = ctx.getImageData(0, 0, sourceImg.width, sourceImg.height);

    var imgDataArray = imgData.data;

    var result = "";

    for(var lineHeight = 0; lineHeight < sourceImg.height; lineHeight += 10) {
        var lineASC = "";

        for(var lineFlag = 0; lineFlag < sourceImg.width; lineFlag += 4) {
            lineIndex = (lineHeight * sourceImg.width + lineFlag) * 4;

            var r = imgDataArray[lineIndex];
            var g = imgDataArray[lineIndex + 1];
            var b = imgDataArray[lineIndex + 2];
            var a = imgDataArray[lineIndex + 3];
            lineASC += gray2asc(rgb2gray(r, g, b));
        }

        lineASC += "\n";

        result += lineASC;
    }

    return result;
}

var canvas = document.getElementById('canvas');

var img = document.getElementById('img');//HTMLImageElement

//use 'pre' html tag
document.getElementById('result').innerHTML = img2ASC(canvas, img);
