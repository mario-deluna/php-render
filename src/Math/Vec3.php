<?php 

namespace PHPR\Math;

class Vec3
{
    public $x;
    public $y;
    public $z;

    public function __construct($x, $y, $z) {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }
}
