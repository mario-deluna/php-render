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

    public function toColorInt() : int
    {
        return (($this->x * 255 & 0xff) << 16) + (($this->y * 255  & 0xff) << 8) + ($this->z * 255  & 0xff);
    }
}
