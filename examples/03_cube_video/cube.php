<?php 
define('EXAMPLE_DIR', __DIR__);
require __DIR__ . '/../example_base.php';

use PHPR\Context;
use PHPR\Shader\Shader;
use PHPR\Mesh\{Vertex, Vertex\VertexPNU};
use PHPR\Mesh\VertexArray;
use PHPR\Math\{Vec3, Vec4, Mat4, Angle};

use PHPR\Render\FFMPEGStream;

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
        $v = $in['color']->normalize();
        $v->add(new Vec3(1.0, 1.0, 1.0))->multiply(0.5);

        $out['color'] = $v->toColorInt();
        // $out['color'] = 0xFFFFFF;
    }
}


/**
 * Create shader object
 */
$shader = new CubeShader;

/**
 * Build a model view projection
 */
$projection = Mat4::perspective(Angle::degreesToRadians(45.0), EXAMPLE_RENDER_ASPECT_RATIO, 0.1, 100);

$view = (new Mat4())->inverse();

$model = (new Mat4)->translate(new Vec3(0.0, 0.0, -3));

$model->rotateX(0.45);
$model->rotateY(-0.45);

// multiply them togethrer
$shader->mvp = $model->multiply($view->multiply($projection, true), true);

/**
 * Build the context
 */
$context = create_exmaple_context();
$context->bindShader($shader);
$context->enableDepthTesting();
// $context->setDrawMode(Context::DRAW_MODE_LINES);

/**
 * Define the cube
 */
$cube = new VertexArray(VertexPNU::class, [
    // position        // normal        // uv
     0.5, -0.5, -0.5,  0.0,  0.0, -1.0, 1.0, 0.0,
    -0.5, -0.5, -0.5,  0.0,  0.0, -1.0, 0.0, 0.0,
     0.5,  0.5, -0.5,  0.0,  0.0, -1.0, 1.0, 1.0,
    -0.5,  0.5, -0.5,  0.0,  0.0, -1.0, 0.0, 1.0,
     0.5,  0.5, -0.5,  0.0,  0.0, -1.0, 1.0, 1.0,
    -0.5, -0.5, -0.5,  0.0,  0.0, -1.0, 0.0, 0.0,
    //
    -0.5, -0.5,  0.5,  0.0,  0.0,  1.0, 0.0, 0.0,
     0.5, -0.5,  0.5,  0.0,  0.0,  1.0, 1.0, 0.0,
     0.5,  0.5,  0.5,  0.0,  0.0,  1.0, 1.0, 1.0,
     0.5,  0.5,  0.5,  0.0,  0.0,  1.0, 1.0, 1.0,
    -0.5,  0.5,  0.5,  0.0,  0.0,  1.0, 0.0, 1.0,
    -0.5, -0.5,  0.5,  0.0,  0.0,  1.0, 0.0, 0.0,
    //
    -0.5,  0.5,  0.5, -1.0,  0.0,  0.0, 1.0, 0.0,
    -0.5,  0.5, -0.5, -1.0,  0.0,  0.0, 1.0, 1.0,
    -0.5, -0.5, -0.5, -1.0,  0.0,  0.0, 0.0, 1.0,
    -0.5, -0.5, -0.5, -1.0,  0.0,  0.0, 0.0, 1.0,
    -0.5, -0.5,  0.5, -1.0,  0.0,  0.0, 0.0, 0.0,
    -0.5,  0.5,  0.5, -1.0,  0.0,  0.0, 1.0, 0.0,
    //
     0.5,  0.5, -0.5,  1.0,  0.0,  0.0, 1.0, 1.0,
     0.5,  0.5,  0.5,  1.0,  0.0,  0.0, 1.0, 0.0,
     0.5, -0.5, -0.5,  1.0,  0.0,  0.0, 0.0, 1.0,
     0.5, -0.5,  0.5,  1.0,  0.0,  0.0, 0.0, 0.0,
     0.5, -0.5, -0.5,  1.0,  0.0,  0.0, 0.0, 1.0,
     0.5,  0.5,  0.5,  1.0,  0.0,  0.0, 1.0, 0.0,
    //
    -0.5, -0.5, -0.5,  0.0, -1.0,  0.0, 0.0, 1.0,
     0.5, -0.5, -0.5,  0.0, -1.0,  0.0, 1.0, 1.0,
     0.5, -0.5,  0.5,  0.0, -1.0,  0.0, 1.0, 0.0,
     0.5, -0.5,  0.5,  0.0, -1.0,  0.0, 1.0, 0.0,
    -0.5, -0.5,  0.5,  0.0, -1.0,  0.0, 0.0, 0.0,
    -0.5, -0.5, -0.5,  0.0, -1.0,  0.0, 0.0, 1.0,

     0.5,  0.5, -0.5,  0.0,  1.0,  0.0, 1.0, 1.0,
    -0.5,  0.5, -0.5,  0.0,  1.0,  0.0, 0.0, 1.0,
     0.5,  0.5,  0.5,  0.0,  1.0,  0.0, 1.0, 0.0,
    -0.5,  0.5,  0.5,  0.0,  1.0,  0.0, 0.0, 0.0,
     0.5,  0.5,  0.5,  0.0,  1.0,  0.0, 1.0, 0.0,
    -0.5,  0.5, -0.5,  0.0,  1.0,  0.0, 0.0, 1.0,
]);

/**
 * Start a new video stream
 */
$stream = video_example_context($context);

for ($i=0; $i<360; $i++)
{
    // clear 
    $context->clear();

    // rotate 
    $model->rotateX(-0.01);
    $model->rotateY(-0.01);
    $shader->mvp = $model->multiply($view->multiply($projection, true), true);

    // draw the cube
    $context->drawVertexArray($cube);

    // render to video
    $stream->render();
}

$stream->stop();
