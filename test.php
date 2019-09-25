<?php 

require __DIR__ . '/bootstrap.php';

use PHPR\{
    Context, Color, Vec3,

    Render\HTMLRender
};

$canvas = new PHPR\Context(50, 50);

// foreach($canvas->buffer as &$color) {
//     $color = mt_rand(0x000000, 0xFFFFFF);
// }

//$canvas->drawLine(0,0, 50,50, 0x000000);
//$canvas->drawLine(0,20, 50,40, 0x000000);


// BR
// $canvas->drawLine(25, 25, 50, 50, 0x000000);
// $canvas->drawLine(25, 25, 50, 25, 0x888888);
// $canvas->drawLine(25, 25, 50, 36, 0xAAAAAA);

// // TR
// $canvas->drawLine(25, 25, 50, 12, 0xFF0000);
// $canvas->drawLine(25, 25, 0, 0, 0xFF0000);

//$canvas->bufferDrawLine(0, 0, 200, 100, 0xFF0000);

$canvas->drawLine(-1, 0, 1, 0, 0xFF00FF);

// $pixels = [];
// $canvas->getLine(-1, 0, 1, 0, $pixels);
// var_dump($pixels);

// $canvas->drawLine(25, 25, 50, 50, 0xFF0000);
// $canvas->drawLine(0, 0, 50, 25, 0xFFFF00);
//$canvas->drawLine(25,0, 25,50, 0x000000);

// $line = [mt_rand() / mt_getrandmax(), mt_rand() / mt_getrandmax(), mt_rand() / mt_getrandmax(), mt_rand() / mt_getrandmax()];
// $canvas->drawLine($line[0], $line[1], $line[2], $line[3], 0x000000);

$canvas->drawTriangleLines(
    new Vec3(-0.5, -0.5, 0.0),
    new Vec3(0.5, -0.5, 0.0),
    new Vec3(0.0, 0.5, 0.0),
    0x000000
);


$pixels = [];
$canvas->getTriangle(
    new Vec3(-0.5, -0.5, 0.0),
    new Vec3(0.5, -0.5, 0.0),
    new Vec3(0.0, 0.5, 0.0),
    $pixels
);

_d($pixels);

// $canvas->getTriangleRanges(
//     new Vec3(0, 0, 0.0),
//     new Vec3(49, 0, 0.0),
//     new Vec3(24, 49, 0.0),
//     0x000000
// );

// var_dump($canvas->getLinePoints(0, 0, 50, 50)); die;

$renderer = new HTMLRender;
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP Render Test</title>
</head>
<body>
    <?php //var_dump($line); ?>
    <?php echo $renderer->render($canvas); ?>
</body>
</html>


