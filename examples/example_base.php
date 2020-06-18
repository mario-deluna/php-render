<?php 

require __DIR__ . '/../bootstrap.php';

use PHPR\{
    Context,
    Buffer\Buffer2D
};

/**
 * Creates example context
 */ 
function create_exmaple_context() : Context
{
    $context = new Context(800, 600);
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
