<?php 

namespace PHPR\Shader;

use PHPR\Mesh\Vertex;
use PHPR\Math\Vec4;

abstract class Shader
{
    /**
     * Vertex shader like thing
     */
    abstract public function vertex(Vertex $vertex, array &$out) : Vec4;

    /**
     * Fragment shader like thing
     */
    abstract public function fragment(array &$in, array &$out);
}
