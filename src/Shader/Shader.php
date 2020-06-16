<?php 

namespace PHPR\Shader;

use PHPR\Mesh\Vertex;

abstract class Shader
{
    /**
     * Vertex shader like thing
     */
    abstract public function vertex(Vertex $vertex, array &$out);

    /**
     * Fragment shader like thing
     */
    abstract public function fragment(array &$in, array &$out);
}
