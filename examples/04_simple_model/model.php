<?php 
define('EXAMPLE_DIR', __DIR__);
require __DIR__ . '/../example_base.php';

use PHPR\Context;
use PHPR\Shader\Shader;
use PHPR\Mesh\{ObjParser, Vertex};
use PHPR\Mesh\Vertex\{VertexPNU};
use PHPR\Mesh\VertexArray;
use PHPR\Math\{Vec3, Vec4, Mat4, Angle};

/**
 * Simpel cube shader
 */
class CubeShader extends Shader
{
    public Mat4 $mvp;

    /**
     * Vertex shader like thing
     */
    public function vertex(Vertex $vertex, array &$out) : Vec4
    {
        $out['color'] = $vertex->normal;

        return $this->mvp->multiplyVec3($vertex->position);
    }

    /**
     * Fragment shader like thing
     */
    public function fragment(array &$in, array &$out)
    {
        $out['color'] = $in['color']->normalize()->toColorInt();
        // $out['color'] = 0xFFFFFF;
    }
}

/**
 * Build a model view projection
 */
$projection = Mat4::perspective(Angle::degreesToRadians(-45.0), EXAMPLE_RENDER_ASPECT_RATIO, 0.5, 10);

$view = (new Mat4())->inverse();

$model = (new Mat4)->translate(new Vec3(0.1, -0.3, -2.5));
$model->rotateX(0.4);
$model->rotateY(-0.6);
//$model->rotateY(-0.05);

/**
 * Create shader object
 */
$shader = new CubeShader;
$shader->mvp = $model->multiply($view->multiply($projection, true), true);

/**
 * Build the context
 */
$context = create_exmaple_context();
$context->bindShader($shader);
$context->enableDepthTesting();
// $context->setDrawMode(Context::DRAW_MODE_LINES);

/**
 * Define the model
 */
$model = ObjParser::loadFromDisk(EXAMPLE_DIR . '/suv.obj');

/**
 * draw the model
 */
$context->drawVertexArray($model);

render_example_context($context);
render_example_context_depth($context);
