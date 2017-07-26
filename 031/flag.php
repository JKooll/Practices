<?php
header("Content-Type: image/png");
class Flag
{
    //国旗大小
    private $size;
    private $flag = null;

    public function __construct($size = 200)
    {
        $this->size = $size;
        $width = $this->getFlagWidth();
        $height = $this->getFlagHeight();

        //创建图像
        $flag = imagecreatetruecolor($width, $height);
        $this->flag = $flag;
    }

    public function drawFlag()
    {
        $flag = $this->flag;

        $bgcolor = $this->getFlagBgcolor();

        imagefill($flag, 0, 0, $bgcolor);

        $this->drawGrid();

        $this->drawBigStar();

        $this->drawSmallStar();

        //输出图片
        imagepng($flag);

        //销毁图片
        imagedestroy($flag);
    }

    public function drawGrid()
    {
        $flag = $this->flag;
        $width = $this->getFlagWidth();
        $height = $this->getFlagHeight();
        $linecolor = $this->getColor(0, 0, 0);

        //将图像四等分
        imageline($flag, 0, $height / 2, $width, $height / 2, $linecolor);
        imageline($flag, $width / 2, 0, $width / 2, $height, $linecolor);

        //将图像左上角小矩形分成15 * 10个小方格
        for($i = 1; $i < 10; $i++) {
            imageline($flag, 0, $height / 20 * $i, $width / 2, $height / 20 * $i, $linecolor);
        }
        for($i = 1; $i < 15; $i++) {
            imageline($flag, $width / 30 * $i, 0, $width / 30 * $i, $height / 2, $linecolor);
        }

        //小正方形尺寸
        $smallSize = $this->getSmallSize();

        $ellipsecolor =  $this->getColor(0, 0, 255);
        //确定大五星的位置
        imageellipse($flag, 5 * $smallSize, 5 * $smallSize, 6 * $smallSize, 6 * $smallSize, $ellipsecolor);

        //确定小五星的位置
        $smallStarBasePoints = [
            10, 2,
            12, 4,
            12, 7,
            10, 9
        ];

        for($i = 0; $i < count($smallStarBasePoints); $i += 2) {
            $this->drawLine(5, 5, $smallStarBasePoints[$i], $smallStarBasePoints[$i + 1]);
        }

        for($i = 0; $i < count($smallStarBasePoints); $i += 2) {
            $this->drawEllipise($smallStarBasePoints[$i], $smallStarBasePoints[$i + 1], 2, 2);
        }
    }

    public function drawLine($x_1, $y_1, $x_2, $y_2)
    {
        $color = $this->getColor(0, 0, 0);

        $smallSize = $this->getSmallSize();

        imageline($this->flag, $x_1 * $smallSize, $y_1 * $smallSize, $x_2 * $smallSize, $y_2 * $smallSize, $color);
    }

    public function drawEllipise($x, $y, $height, $width)
    {
        $color = $this->getColor(0, 0, 255);

        $smallSize = $this->getSmallSize();

        imageellipse($this->flag, $x * $smallSize, $y * $smallSize, $width * $smallSize, $height * $smallSize, $color);
    }

    public function getFlagWidth()
    {
        return 3 * $this->size;
    }

    public function getFlagHeight()
    {
        return 2 * $this->size;
    }

    //获取两点连线与水平方向的夹角
    function getAngle($x_1, $y_1, $x_2, $y_2)
    {
        $x = $x_2 - $x_1;
        $y = $y_2 - $y_1;
        $tan = $y / $x;
        $angle = round(rad2deg(atan($tan)), 2);
        return $angle;
    }

    //绘制大五角星
    public function drawBigStar()
    {
        $smallSize = $this->getSmallSize();

        //绘制大五星
        $radius = 3 * $smallSize;

        $basePoint = array("x" => 5 * $smallSize, "y" => 5 * $smallSize);

        $points = $this->getPoints($basePoint, $radius);

        $this->drawStar($points);
    }

    public function drawSmallStar()
    {
        $smallSize = $this->getSmallSize();

        $bigStarBasePoint = array('x' => 5 * $smallSize, 'y' => 5 * $smallSize);

        $radius = 1 * $smallSize;

        $basePoints = [
            10, 2,
            12, 4,
            12, 7,
            10, 9
        ];

        for($i = 0; $i < count($basePoints); $i += 2) {
            $basePoint = array("x" => $basePoints[$i] * $smallSize, "y" => $basePoints[$i + 1] * $smallSize);

            $points = $this->getPoints($basePoint, $radius);

            $angle = $this->getAngle($bigStarBasePoint['x'], $bigStarBasePoint['y'], $points[8], $points[9]);

            $points = $this->getPoints($basePoint, $radius, $angle);

            $this->drawStar($points);
        }

    }

    /*
    *$basePoints 五角星外接圆的圆心
    *$points 五角星五个角的坐标
    *$radius 五角星外接圆半径
    *$angle 五角星相对于水平方向旋转角度
    */
    public function drawStar($points)
    {
        $color = $this->getColor(252,209,22);

        $drawStarPoints = [
                              $points[0], $points[1],
                              $points[4], $points[5],
                              $points[8], $points[9],
                              $points[2], $points[3],
                              $points[6], $points[7],
                              $points[0], $points[1]
                          ];
        $points = $drawStarPoints;

        imagepolygon($this->flag, $points, count($points) / 2, $color);
    }

    /*
    *$basePoint 五角星外接圆的圆心
    *$radius 五角星外接圆半径
    *$angle 五角星相对于水平方向旋转角度
    *返回五角星五个角的坐标
    */
    public function getPoints($basePoint, $radius, $angle = 0)
    {
        $points = array();
        //求出各点坐标，-18°旋转下，看起来正一点
        for ($degree = -18 + $angle;$degree < (360 - 18 + $angle);$degree += 72)
        {
            $x = round(cos(deg2rad($degree)) * $radius + $basePoint["x"],2);
            $y = round(sin(deg2rad($degree)) * $radius + $basePoint["y"],2);

            array_push($points,
                       $x, $y
                   );
        }

        return $points;
    }

    public function getFlagBgcolor()
    {
        return $this->getColor(206, 17, 38);
    }

    public function getColor($red, $green, $blue)
    {
        return imagecolorallocate($this->flag, $red, $green, $blue);
    }

    /*
    *flag左上角分割出的小网格是有小正方形组成的
    */
    public function getSmallSize()
    {
        return $this->getFlagWidth() / 30;
    }
}

$flag = new Flag(200);
$flag->drawFlag();
