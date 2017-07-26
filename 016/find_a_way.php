<?php

class FindaWay
{
    private $map = null;
    private $path = null;
    private $has_found = false;

    function __construct($map)
    {
        $this->map = $map;

        $this->initMap();
    }

    function initMap()
    {
        $map = $this->map;

        for($i = 0; $i < count($map); $i++) {
            for($j = 0; $j < count($map[$i]); $j++) {

                if($map[$i][$j] == 0) {
                    $map[$i][$j] = [
                        'isObstacle' => true,
                    ];
                } else {
                    $map[$i][$j] = [
                        'isObstacle' => false,
                        'isHasFound' => false,
                        'x' => $i,
                        'y' => $j,
                        'parent_x' => -1,
                        'parent_y' => -1,
                        'top' => false,
                        'down' => false,
                        'left' => false,
                        'right' => false
                    ];
                }

            }
        }

        $this->map = $map;

    }

    function initPoint($point)
    {
        $point['top'] = false;

        $point['down'] = false;

        $point['left'] = false;

        $point['right'] = false;
    }

    public function find($point)
    {
        if($this->has_found) {
            return $this->path;
        }

        if(!$this->isCanMove($point)) {
            if($this->check()) {
                return $this->path;
            }

            $this->initPoint($point);
        }

        if($this->top($point)) {
            return $this->find($map[$point['x']][$point['y'] - 1]);
        }

        if($this->down($point)) {
            return $this->find($map[$point['x']][$point['y'] + 1]);
        }

        if($this->left($point)) {
            return $this->find($map[$point['x'] - 1][$point['y']]);
        }

        if($this->right($point)) {
            return $this->find($map[$point['x'] + 1][$point['y']]);
        }
    }

    /**
    *$point [x => '', y => '']
    **/
    private function isCanMove($point)
    {

    }

    private function top($point)
    {

    }

    private function down($point)
    {

    }

    private function left($point)
    {

    }

    private function right($point)
    {

    }

    private function check()
    {

    }

    public function getMap()
    {
        return $this->map;
    }
}

$map = [[1, 1, 1], [1, 0, 1], [1, 1, 1]];

$findaway = new FindaWay($map);

print_r(json_encode($findaway->getMap()));
