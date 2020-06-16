<?php 

require __DIR__ . '/../example_base.php';

use PHPR\Shader\TriangleTestShader;
use PHPR\Mesh\Vertex;
use PHPR\Math\Vec3;

$context = create_exmaple_context();
$context->bindShader(new TriangleTestShader);

/**
 * Vertex subclass with color attribute
 */
class ExampleVertex extends Vertex
{
    public static function c(float $x, float $y, float $z, float $r, float $g, float $b)
    {
        $v = ExampleVertex::cP($x, $y, $z);
        $v->color = new Vec3($r, $g, $b);

        return $v;
    }

    public Vec3 $color;
}

/**
 * Draw the tirangle
 */
$context->drawTriangle(
    //               | position       | color
    ExampleVertex::c(-0.8, -0.8, 0.0, 1.0, 0.0, 0.0),
    ExampleVertex::c( 0.8, -0.8, 0.0, 0.0, 1.0, 0.0),
    ExampleVertex::c( 0.0,  0.8, 0.0, 0.0, 0.0, 1.0),
);

render_example_context($context);
