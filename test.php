<?php 

require __DIR__ . '/bootstrap.php';

use PHPR\{
    Context,
    Buffer\Buffer2D,
    Math\Vec3, 
    Mesh\Vertex,
    Shader\TriangleTestShader,
    Render\HTMLRender
};

$canvas = new PHPR\Context(80, 60);
$canvas->attachBuffer(Buffer2D::TYPE_INT, 'color');
$canvas->setOutputBuffer('color');
$canvas->bindShader(new TriangleTestShader);

$tris = 10;

for($y=0;$y<$tris;$y++) 
{
    for($x=0;$x<$tris;$x++) 
    {
        $w = 2 / $tris;
        $txl = ($w * $x) - 1;
        $txr = $txl + $w / 2;
        $tyt = ($w * $y) - 1;
        $tyb = $tyt + $w;
        $t3x = $txr + ($w * 0.5);
        //_dd($txl, $txr, $tyt, $tyb, $t3x);

        $v1 = Vertex::cP($txl, $tyt, 0.0);
        $v2 = Vertex::cP($txr, $tyt, 0.0);
        $v3 = Vertex::cP($t3x, $tyb, 0.0);

        $v1->color = new Vec3(1.0, 0.0, 0.0);
        $v2->color = new Vec3(0.0, 1.0, 0.0);
        $v3->color = new Vec3(0.0, 0.0, 1.0);

        $canvas->drawTriangle($v1, $v2, $v3);
    }
}

$v1 = Vertex::cP(-0.8, -0.8, 0.0);
$v2 = Vertex::cP(0.8, -0.8, 0.0);
$v3 = Vertex::cP(0.0, 0.8, 0.0);

$v1->color = new Vec3(1.0, 0.0, 0.0);
$v2->color = new Vec3(0.0, 1.0, 0.0);
$v3->color = new Vec3(0.0, 0.0, 1.0);

$canvas->drawTriangle($v1, $v2, $v3);

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


