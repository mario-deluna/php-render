<?php 

namespace PHPR\Mesh;

use PHPR\Math\Vec3;

class Vertex
{
    public static function cP(float $x, float $y, float $z)
    {
        $v = new Vertex;
        $v->position = new Vec3($x, $y, $z);
        
        return $v;
    }

    /**
     * Attributes
     */
    public Vec3 $position;
}
