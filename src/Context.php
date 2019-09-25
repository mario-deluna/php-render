<?php 

namespace PHPR;

use Shader\Shader;

class Context
{
    /**
     * Color Buffer
     *
     * @var array[int] 
     */
    public $buffer = [];

    /** 
     * Depth Buffer 
     *
     * @var array[int]
     */
    public $depth = [];

    /**
     * Dimensions
     *
     * @var int
     */
    public $width;
    public $height;

    /**
     * Shader instance 
     * 
     * @var Shader
     */
    private $shader;

    /**
     * Construct
     *
     * @param int                   $width
     * @param int                   $height
     */
    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
        $this->buffer = array_fill(0, $width * $height, 0xFFFFFF);
        $this->depth = array_fill(0, $width * $height, 0x000000);
    }

    /**
     * Draw a single pixel
     */
    public function setPixel(int $x, int $y, int $color)
    {
        $this->buffer[(($y * $this->width) + $x)] = $color;
    }

    /**
     * Draw an array of pixels
     *
     * @param array             $pixels
     */
    public function drawArray(array &$pixels)
    {
        for ($i=0;$i<count($pixels);$i+=2) 
        {
            $x = $v[$i];
            $y = $v[$i + 1];

            // set frag coords
            $this->shader->fragCoords->x = $x;
            $this->shader->fragCoords->y = $y;

            // calculate the fragment color
            $this->buffer[(($y * $this->width) + $x)] = $this->shader->fragmentColor();
        }
    }

    public function drawTriangleLines(Vec3 $v1, Vec3 $v2, Vec3 $v3, int $color)
    {
        $this->drawLine($v1->x, $v1->y, $v2->x, $v2->y, $color);
        $this->drawLine($v2->x, $v2->y, $v3->x, $v3->y, $color);
        $this->drawLine($v3->x, $v3->y, $v1->x, $v1->y, $color);
    }

    public function getTriangle(Vec3 $v1, Vec3 $v2, Vec3 $v3, array &$p)
    {
        $a = $b = $c = [];

        $this->getLine($v1->x, $v1->y, $v2->x, $v2->y, $a);
        $this->getLine($v2->x, $v2->y, $v3->x, $v3->y, $b);
        $this->getLine($v3->x, $v3->y, $v1->x, $v1->y, $c);

        // get pixels per row
        $r = [];
        foreach([$a, $b, $c] as $v)
        {
            for ($i=0;$i<count($v);$i+=2) 
            {
                $x = $v[$i];
                $y = $v[$i + 1];
                $r[$y] = $r[$y] ?? [];
                $r[$y][] = $x;
            }
        }

        // build pixel array
        foreach($r as $y => $xa)
        {
            for($x=min($xa); $x<max($xa); $x++) {
                $p[] = $x;
                $p[] = $y;
            }
        }
    }


    public function drawLine(float $x1, float $y1, float $x2, float $y2, int $color)
    {
        $x1 = ($x1 + 1) / 2;
        $x2 = ($x2 + 1) / 2;
        $y1 = ($y1 + 1) / 2;
        $y2 = ($y2 + 1) / 2;

        $this->bufferDrawLine(
            ($x1 * $this->width),
            ($y1 * $this->height),
            ($x2 * $this->width),
            ($y2 * $this->height),
            $color
        );
    }

    public function getLine(float $x1, float $y1, float $x2, float $y2, array &$pixels)
    {
        $x1 = ($x1 + 1) / 2;
        $x2 = ($x2 + 1) / 2;
        $y1 = ($y1 + 1) / 2;
        $y2 = ($y2 + 1) / 2;

        $this->bufferGetLine(
            ($x1 * $this->width),
            ($y1 * $this->height),
            ($x2 * $this->width),
            ($y2 * $this->height),
            $pixels
        );
    }

    public function bufferGetLine(int $x1, int $y1, int $x2, int $y2, array &$pixels)
    {
        $dx = abs($x2 - $x1);
        $dy = -abs($y2 - $y1);

        $sx = $x1 < $x2 ? 1 : -1;
        $sy = $y1 < $y2 ? 1 : -1;

        $e = $dx + $dy;

        while (1) 
        {
            $pixels[] = $x1;
            $pixels[] = $y1;

            if ($x1 >= $this->width - 1) break;
            if ($y1 >= $this->height - 1) break;

            $e2 = $e * 2;

            if ($e2 >= $dy) {
                if ($x1 === $x2) break;
                $e += $dy;
                $x1 += $sx;
            }
            if ($e2 <= $dx) {
                if ($y1 === $y2) break;
                $e += $dx;
                $y1 += $sy;
            }
        }
    }

    public function bufferDrawLine(int $x1, int $y1, int $x2, int $y2, int $color)
    {
        $dx = abs($x2 - $x1);
        $dy = -abs($y2 - $y1);

        $sx = $x1 < $x2 ? 1 : -1;
        $sy = $y1 < $y2 ? 1 : -1;

        $e = $dx + $dy;

        while (1) 
        {
            $this->setPixel($x1, $y1, $color);

            if ($x1 >= $this->width - 1) break;
            if ($y1 >= $this->height - 1) break;

            $e2 = $e * 2;

            if ($e2 >= $dy) {
                if ($x1 === $x2) break;
                $e += $dy;
                $x1 += $sx;
            }
            if ($e2 <= $dx) {
                if ($y1 === $y2) break;
                $e += $dx;
                $y1 += $sy;
            }
        }
    }
}
