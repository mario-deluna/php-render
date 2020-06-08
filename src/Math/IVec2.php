<?php 

namespace PHPR\Math;

class IVec2
{
    public int $x;
    public int $y;

    public function __construct(int $x, int $y) {
        $this->x = $x;
        $this->y = $y;
    }
}
