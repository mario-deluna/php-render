<?php 

require __DIR__ . '/../bootstrap.php';

use PHPR\{
    Context,
    Buffer\Buffer2D, Buffer\BufferInt
};

define('EXAMPLE_RENDER_WIDTH', 800);
define('EXAMPLE_RENDER_HEIGHT', 600);
// define('EXAMPLE_RENDER_WIDTH', 1280);
// define('EXAMPLE_RENDER_HEIGHT', 720);
// define('EXAMPLE_RENDER_WIDTH', 360);
// define('EXAMPLE_RENDER_HEIGHT', 240);
define('EXAMPLE_RENDER_ASPECT_RATIO', EXAMPLE_RENDER_WIDTH / EXAMPLE_RENDER_HEIGHT);
define('EXAMPLE_RES_DIR', __DIR__ . '/../example-resources');
define('EXAMPLE_MODEL_DIR', EXAMPLE_RES_DIR . '/models');

/**
 * Creates example context
 */ 
function create_exmaple_context() : Context
{
    $context = new Context(EXAMPLE_RENDER_WIDTH, EXAMPLE_RENDER_HEIGHT);
    //$context = new Context(1920, 1080);
    $context->attachBuffer(Buffer2D::TYPE_INT, 'color');
    $context->setOutputBuffer('color');

    return $context;
}

/**
 * Render a example context
 */
function render_example_context(Context $canvas, ?string $file = null)
{
    if (is_null($file)) {
        $file = EXAMPLE_DIR . '/image.tga';
    }

    $renderer = new \PHPR\Render\TGARenderer;
    $renderer->renderToFile($canvas, $file);
}

/**
 * Render depth buffer of example context
 */
function render_example_context_depth(Context $canvas, ?string $file = null)
{
    $depthBO = $canvas->getDepthBuffer()->getBufferObject();
    $depthData = $depthBO->rawCopy();

    $depthColorBuffer = new BufferInt($depthBO->getSize());
    $depthColorBufferRef = &$depthColorBuffer->raw();

    $depthData = array_filter($depthData);
    $max = max($depthData);
    $min = min($depthData);

    echo "Max Depth $max" . PHP_EOL;
    echo "Min Depth $min" . PHP_EOL;

    // $min = 0;
    // $max = 1;

    $max = $max - $min;

    if ($max != 0) 
    {
        foreach($depthData as $k => $value) 
        {
            $value = ($value - $min) / $max;

            $depthColorBufferRef[$k] = (($value * 255 & 0xff) << 16) + (($value * 255 & 0xff) << 8) + ($value * 255  & 0xff);
            // $depthColorBufferRef[$k] = $value;
        }
    }

    $canvas->getOutputBuffer()->replaceBufferObject($depthColorBuffer);

    if (is_null($file)) {
        $file = EXAMPLE_DIR . '/image_depth.tga';
    }

    $renderer = new \PHPR\Render\TGARenderer;
    $renderer->renderToFile($canvas, $file);
}

/**
 * Render a video example
 */
function video_example_context(Context $canvas, ?string $file = null) : \PHPR\Render\FFMPEGStream
{
    if (is_null($file)) {
        $file = EXAMPLE_DIR . '/video.mp4';
    }

    $stream = new \PHPR\Render\FFMPEGStream($canvas);
    $stream->start($file);

    return $stream;
}


function render_example_context_html(Context $canvas)
{
    $renderer = new \PHPR\Render\HTMLRender;
    $renderer->pixelSize = 1;

    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <title>PHP Render Test</title>
    </head>
    <body>
        ".$renderer->render($canvas)."
    </body>
    </html>";
}
