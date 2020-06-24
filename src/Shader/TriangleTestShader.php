<?php 

namespace PHPR\Shader;

use PHPR\Color;
use PHPR\Mesh\Vertex;
use PHPR\Math\Vec4;

class TriangleTestShader extends Shader
{
    /**
     * Vertex shader like thing
     */
    public function vertex(Vertex $vertex, array &$out) : Vec4
    {
        $out['color'] = $vertex->color;

        return Vec4::fromVec3($vertex->position);
    }

    /**
     * Fragment shader like thing
     */
    public function fragment(array &$in, array &$out)
    {
        $out['color'] = $in['color']->toColorInt();
    }
}
