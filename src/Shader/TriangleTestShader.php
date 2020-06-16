<?php 

namespace PHPR\Shader;

use PHPR\Color;
use PHPR\Mesh\Vertex;
use PHPR\Math\Vec3;

class TriangleTestShader extends Shader
{
    /**
     * Vertex shader like thing
     */
    public function vertex(Vertex $vertex, array &$out)
    {
        $out['position'] = $vertex->position;
        $out['color'] = $vertex->color;
    }

    /**
     * Fragment shader like thing
     */
    public function fragment(array &$in, array &$out)
    {
        $out['color'] = $in['color']->toColorInt();
    }
}
