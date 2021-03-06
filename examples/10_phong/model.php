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

    public Vec3 $viewPosition;

    /**
     * Vertex shader like thing
     */
    public function vertex(Vertex $vertex, array &$out) : Vec4
    {
        $out['uv'] = $vertex->uv;
        $out['position'] = $vertex->position;

        $normal = $this->model->multiplyVec3($vertex->normal);

        $out['normal'] = new Vec3($normal->x, $normal->y, $normal->z);

        return $this->model->multiply($this->view->multiply($this->projection, true), true)->multiplyVec3($vertex->position);
    }

    /**
     * Fragment shader like thing
     */
    public function fragment(array &$in, array &$out)
    {
        $viewDir = Vec3::_substract($this->viewPosition, $in['position'])->normalize();
        $NdotL = max($in['normal']->dot($viewDir->cross(new Vec3(1.0, 1.0, 0.0))), 0.0);

        // diffuse 
        $diffuseSample = $this->diffuse->sampleVec3($in['uv']->x, 1 - $in['uv']->y);
        $diffuseSample->multiplyVec3(new Vec3(1.0, 1.0, 1.0))->multiply($NdotL);

        // ambient
        $ambient = $this->diffuse->sampleVec3($in['uv']->x, 1 - $in['uv']->y);
        $ambient->multiplyVec3(new Vec3(0.3, 0.3, 0.3));

        $out['color'] = $diffuseSample->add($ambient)->clamp()->toColorInt();
        // $out['color'] = $this->diffuse->sampleVec3($in['uv']->x, 1 - $in['uv']->y)->toColorInt();
    }
}


/**
 * Create shader object
 */
$shader = new ModelShader;

// load textures 
$shader->diffuse = new ImageSamplerGD(EXAMPLE_MODEL_DIR . '/chest/Treasurechest_DIFF.png');

// camera
$cameraPos = new Vec3(0, 0, 4);
$shader->viewPosition = $cameraPos;

// projection
$shader->projection = Mat4::perspective(Angle::degreesToRadians(-45.0), EXAMPLE_RENDER_ASPECT_RATIO, 0.5, 10);
$shader->view = (new Mat4())->translate($cameraPos)->inverse();
$shader->model = (new Mat4)->translate(new Vec3(0.0, 0.0, 0.0));


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
$object = ObjParser::loadFromDisk(EXAMPLE_MODEL_DIR . '/chest/chest.obj');


/**
 * Start a new video stream
 */
$stream = video_example_context($context);

for ($i=0; $i<180; $i++)
{
    // clear 
    $context->clear();

    // rotate 
    $shader->model->rotateY(-0.02);
    // $shader->model->rotateX(-0.01);

    // draw the model
    $context->drawVertexArray($object);

    // render to video
    $stream->render();
}

$stream->stop();

/**
 * draw the model
 */
$context->drawVertexArray($object);

render_example_context($context);
render_example_context_depth($context);
