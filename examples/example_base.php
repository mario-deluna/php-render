<?php 

require __DIR__ . '/../bootstrap.php';

use PHPR\{
    Context,
    Buffer\Buffer2D, Buffer\BufferInt
};

define('EXAMPLE_RENDER_WIDTH', 800);
define('EXAMPLE_RENDER_HEIGHT', 600);
define('EXAMPLE_RENDER_ASPECT_RATIO', EXAMPLE_RENDER_WIDTH / EXAMPLE_RENDER_HEIGHT);

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
function render_example_context(Context $canvas)
{
    $renderer = new \PHPR\Render\TGARenderer;
    $renderer->render($canvas, EXAMPLE_DIR . '/image.tga');
}

/**
 * Render depth buffer of example context
 */
function render_example_context_depth(Context $canvas)
{
    $depthBO = $canvas->getDepthBuffer()->getBufferObject();
    $depthData = $depthBO->rawCopy();

    $depthColorBuffer = new BufferInt($depthBO->getSize());
    $depthColorBufferRef = &$depthColorBuffer->raw();

    $depthData = array_filter($depthData);
    $max = max($depthData);
    $min = min($depthData);

    $max = $max - $min;

    if ($max != 0) 
    {
        foreach($depthData as $k => $value) 
        {
            $value = ($value - $min) / $max;
            $depthColorBufferRef[$k] = (($value * 255 & 0xff) << 16) + (($value * 255 & 0xff) << 8) + ($value * 255  & 0xff);
        }
    }

    $canvas->getOutputBuffer()->replaceBufferObject($depthColorBuffer);

    $renderer = new \PHPR\Render\TGARenderer;
    $renderer->render($canvas, EXAMPLE_DIR . '/image_depth.tga');
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
