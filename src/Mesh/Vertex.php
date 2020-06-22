<?php 

namespace PHPR\Mesh;

use PHPR\Math\Vec3;

class Vertex
{
    /**
     * Attributes
     */
    public Vec3 $position;

    /**
     * Return the vertex value size 
     */
    public static function size() : int
    {
        return 3;
    }

    /**
     * Creates a vertex from array
     */
    public static function list(array $array)
    {
        $v = new Vertex;
        $v->position = new Vec3($array[0], $array[1], $array[2]);

        return $v;
    }

    public static function cP(float $x, float $y, float $z)
    {
        $v = new Vertex;
        $v->position = new Vec3($x, $y, $z);
        
        return $v;
    }
}
