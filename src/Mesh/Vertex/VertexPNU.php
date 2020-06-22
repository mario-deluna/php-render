<?php 

namespace PHPR\Mesh\Vertex;

use PHPR\Mesh\Vertex;
use PHPR\Math\{Vec3, Vec2};

class VertexPNU extends Vertex
{
    /**
     * Attributes
     */
    public Vec3 $position;
    public Vec3 $normal;
    public Vec2 $uv;

    /**
     * Return the vertex value size 
     */
    public static function size() : int
    {
        return 8;
    }

    /**
     * Creates a vertex from array
     */
    public static function list(array $array)
    {
        $v = parent::list($array);
        $v->normal = new Vec3($array[3], $array[4], $array[5]);
        $v->uv = new Vec2($array[6], $array[7]);

        return $v;
    }
}
