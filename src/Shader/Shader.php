<?php 

namespace PHPR\Shader;

use PHPR\Vec3;

abstract class Shader
{
    public $fragCoords = new Vec3();

    /**
     * Return an int of the current pixel color
     *
     * @return int
     */
    abstract public function fragmentColor() : int;
}
