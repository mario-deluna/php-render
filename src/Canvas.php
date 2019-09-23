<?php 

namespace PHPR;

class Canvas
{
    public $buffer = [];
    public $depth = [];

    public $width;
    public $height;

    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
        $this->buffer = array_fill(0, $width * $height, 0xFFFFFF);
        $this->depth = array_fill(0, $width * $height, 0x000000);
    }

    public function drawPoint(int $x, int $y, int $color)
    {
        $this->buffer[(($y * $this->width) + $x)] = $color;
    }

    public function drawTriangle(Vec3 $v1, Vec3 $v2, Vec3 $v3, int $color)
    {
        $this->drawLine($v1->x, $v1->y, $v2->x, $v2->y, $color);
        $this->drawLine($v2->x, $v2->y, $v3->x, $v3->y, $color);
        $this->drawLine($v3->x, $v3->y, $v1->x, $v1->y, $color);
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

    public function getTriangleRanges(Vec3 $v1, Vec3 $v2, Vec3 $v3)
    {
        $a = array_chunk($this->getLinePoints($v1->x, $v1->y, $v2->x, $v2->y), 2);
        $b = array_chunk($this->getLinePoints($v2->x, $v2->y, $v3->x, $v3->y), 2);
        $c = array_chunk($this->getLinePoints($v3->x, $v3->y, $v1->x, $v1->y), 2);

        var_dump($a, $b, $c); die;
    }

    public function getLinePoints(int $x1, int $y1, int $x2, int $y2)
    {
        $dx = abs($x2 - $x1);
        $dy = -abs($y2 - $y1);

        $sx = $x1 < $x2 ? 1 : -1;
        $sy = $y1 < $y2 ? 1 : -1;

        $e = $dx + $dy;

        $p = [];

        while (1) 
        {
            $p[] = $x1;
            $p[] = $y1;

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

        return $p;
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
            $this->drawPoint($x1, $y1, $color);

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


    // public function drawLine(int $x1, int $y1, int $x2, int $y2, int $color)
    // {
    //     $dx = $x2 - $x1;
    //     $dy = $y2 - $y1;

    //     $tdy = 2 * $dy;
    //     $tdydx = $tdy - 2 * $dx;

    //     $x = $x1;
    //     $y = $y1;

    //     if ($dy < 0) 
    //     {
    //         $d = $tdy - $dx;
    //         var_dump($d);
    //         var_dump('top');
    //         while($x < $x2) 
    //         {   
    //             $this->drawPoint($x++, $y, $color);

    //             if ($d < 0) {
    //                 $d += $tdy;
    //             } else {
    //                 $d += $tdydx;
    //                 $y--;
    //             }
    //         }
    //     }
    //     else 
    //     {
    //         $d = $tdy - $dx;
    //         var_dump($d);
    //         var_dump('bottom');
    //         while($x < $x2) 
    //         {   
    //             $this->drawPoint($x++, $y, $color);

    //             if ($d < 0) {
    //                 $d += $tdy;
    //             } else {
    //                 $d += $tdydx;
    //                 $y++;
    //             }
    //         }
    //     }   
    // }

        // public function drawLine(int $x1, int $y1, int $x2, int $y2, int $color)
    // {
    //     $dx = $x2 - $x1;
    //     $dy = $y2 - $y1;

    //     // $m = $dy / $dx;
    //     // $b = $y1 - ($m * $x1);

    //     // for($i=0;$i<$dx;$i++) {
    //     //     $this->buffer[(int)((ceil($m * ($x1 + $i) + $b) * $this->width) + ($x1 + $i))] = $color;
    //     // }

    //     $d = 2 * $dy - $dx;
    //     $incr_e = 2 * $dy;
    //     $incr_ne = 2 * ($dy - $dx);
    //     $x = $x1;
    //     $y = $y1;

    //     //putPixel(x,y, myRGBA);

    //     while($x < $x2) 
    //     {
    //         if ($d <= 0) {
    //             $d += $incr_e;
    //             $x++;
    //         } else {
    //             $d += $incr_ne;
    //             $x++;
    //             $y++;
    //         }

    //         $this->buffer[(($y * $this->width) + $x)] = $color;
    //     }
    // }

    // public function drawLine(int $x1, int $y1, int $x2, int $y2, int $color)
    // {
    //     $tx = ($x2 - $x1) / $this->width;

    //     $x = (float) $x1;
    //     $y = $y1;

    //     while($x < $x2)
    //     {
    //         $x += $tx;
    //         $y++;
    //         $this->drawPoint($x, $y, $color);
    //     }
    // }

}
