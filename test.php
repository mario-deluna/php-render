<?php 

require __DIR__ . '/vendor/autoload.php';

use PHPR\{
    Canvas, Color,

    Render\HTMLRender
};

$canvas = new PHPR\Canvas(50, 50);

// foreach($canvas->bitmap as &$color) {
//     $color = mt_rand(0x000000, 0xFFFFFF);
// }

// https://medium.com/@thiagoluiz.nunes/rasterization-algorithms-computer-graphics-b9c3600a7587

//$canvas->drawLine(0,0, 50,50, 0x000000);
//$canvas->drawLine(0,20, 50,40, 0x000000);


// BR
$canvas->drawLine(25, 25, 50, 50, 0x000000);
$canvas->drawLine(25, 25, 50, 25, 0x888888);
$canvas->drawLine(25, 25, 50, 36, 0xAAAAAA);

// TR
$canvas->drawLine(25, 25, 50, 12, 0xFF0000);
$canvas->drawLine(25, 25, 0, 0, 0xFF0000);


// $canvas->drawLine(25, 25, 50, 50, 0xFF0000);
// $canvas->drawLine(0, 0, 50, 25, 0xFFFF00);
//$canvas->drawLine(25,0, 25,50, 0x000000);

// $line = [mt_rand(0,50), mt_rand(0,50), mt_rand(0,50), mt_rand(0,50)];
// $canvas->drawLine($line[0], $line[1], $line[2], $line[3], 0x000000);

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


