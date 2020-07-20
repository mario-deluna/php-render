<?php 
define('EXAMPLE_DIR', __DIR__);
require __DIR__ . '/../example_base.php';

use PHPR\Context;
use PHPR\Shader\Shader;
use PHPR\Mesh\{ObjParser, Vertex};
use PHPR\Mesh\Vertex\{VertexPNU};
use PHPR\Mesh\VertexArray;
use PHPR\Math\{Vec3, Vec4, Mat4, Angle};
use PHPR\Sampler\ImageSamplerGD;

/**
 * Simpel cube shader
 */
class ModelShader extends Shader
{
    public Mat4 $projection;
    public Mat4 $view;
    public Mat4 $model;

    public ImageSamplerGD $diffuse;

    /**
     * Vertex shader like thing
     */
    public function vertex(Vertex $vertex, array &$out) : Vec4
    {
        $out['uv'] = $vertex->uv;
        $mvp = $this->model->multiply($this->view->multiply($this->projection, true), true);
        return $mvp->multiplyVec3($vertex->position);
    }

    /**
     * Fragment shader like thing
     */
    public function fragment(array &$in, array &$out)
    {
        $out['color'] = $this->diffuse->sample($in['uv']->x, 1 - $in['uv']->y);
    }
}


/**
 * Create shader object
 */
$shader = new ModelShader;

// load textures 
$shader->diffuse = new ImageSamplerGD(EXAMPLE_MODEL_DIR . '/chest/Treasurechest_DIFF.png');

// camera
$cameraPos = new Vec3(0, 0, 5);

// projection
$shader->projection = Mat4::perspective(Angle::degreesToRadians(-45.0), EXAMPLE_RENDER_ASPECT_RATIO, 0.5, 10);
$shader->view = (new Mat4())->translate($cameraPos)->inverse();
$shader->model = (new Mat4)->translate(new Vec3(0.0, 0.2, 0.0));
$shader->model->rotateX(0.4);
$shader->model->rotateY(-0.2);


/**
 * Build the context
 */
$context = create_exmaple_context();
$context->bindShader($shader);
$context->enableDepthTesting();
// $context->setDrawMode(Context::DRAW_MODE_LINES);
// $context->disableBackfaceCulling();

/**
 * Define the model
 */
$object = ObjParser::loadFromDisk(EXAMPLE_MODEL_DIR . '/chest/chest.obj');

/**
 * draw the model
 */
$context->drawVertexArray($object);

render_example_context($context);
render_example_context_depth($context);
