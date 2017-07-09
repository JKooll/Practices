<?php
session_start();

$image = imagecreatetruecolor(100, 30);
$bgcolor = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $bgcolor);

$fontcode = '';
for($i = 0; $i < 4; $i++){
    $fontsize = 6;
    $fontcolor = imagecolorallocate($image, rand(0, 120), rand(0, 120), rand(0, 120));
    $data = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o',
            'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
    $fontcontent = $data[rand(0, 35)];
    $fontcode .= $fontcontent;

    $x = ($i * 100 / 4) + rand(5, 10);
    $y = rand(5, 10);
     imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);
}
$_SESSION['authcode'] = $fontcode;
for($i = 0; $i < 200; $i++){
    $pointcolor = imagecolorallocate($image, rand(50, 200), rand(50, 200), rand(50, 200));
    imagesetpixel($image, rand(1,99), rand(1, 29), $pointcolor);
}

for($i = 0; $i < 3; $i++){
    $linecolor = imagecolorallocate($image, rand(80, 200), rand(80, 200), rand(80, 200));
    imageline($image, rand(1, 99), rand(1, 29), rand(1, 99), rand(1, 29), $linecolor);
}

header('Content-type:image/png');
imagepng($image);

imagedestroy($image);
