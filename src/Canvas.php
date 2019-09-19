<?php 

namespace PHPR;

class Canvas
{
    public $bitmap = [];

    public $width;
    public $height;

    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
        $this->bitmap = array_fill(0, $width * $height, 0xFFFFFF);
    }

    public function colorIntToRGB(int $color) : array
    {
        return [($color >> 16) & 0xFF, ($color >> 8) & 0xFF, $color & 0xFF];
    }

    public function colorIntToVec3(int $color) : array
    {
        return [($color >> 16) & 0xFF, ($color >> 8) & 0xFF, $color & 0xFF];
    }

    public function colorIntToHex(int $color) : string
    {
        return dechex($color);
    }

    // public function drawLine(int $x1, int $y1, int $x2, int $y2, int $color)
    // {
    //     $dx = $x2 - $x1;
    //     $dy = $y2 - $y1;

    //     // $m = $dy / $dx;
    //     // $b = $y1 - ($m * $x1);

    //     // for($i=0;$i<$dx;$i++) {
    //     //     $this->bitmap[(int)((ceil($m * ($x1 + $i) + $b) * $this->width) + ($x1 + $i))] = $color;
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

    //         $this->bitmap[(($y * $this->width) + $x)] = $color;
    //     }
    // }

    public function drawPoint(int $x, int $y, int $color)
    {
        $this->bitmap[(($y * $this->width) + $x)] = $color;
    }

    public function drawLine(int $x1, int $y1, int $x2, int $y2, int $color)
    {
        $dx = $x2 - $x1;
        $dy = $y2 - $y1;

        $tdy = 2 * $dy;
        $tdydx = $tdy - 2 * $dx;

        $x = $x1;
        $y = $y1;

        if ($dy < 0) 
        {
            $d = $tdy - $dx;
            var_dump('top');
            while($x < $x2) 
            {   
                $this->drawPoint($x++, $y, $color);

                if ($d < 0) {
                    $d += $tdy;
                } else {
                    $d += $tdydx;
                    $y--;
                }
            }
        }
        else 
        {
            $d = $tdy - $dx;
            var_dump('bottom');
            while($x < $x2) 
            {   
                $this->drawPoint($x++, $y, $color);

                if ($d < 0) {
                    $d += $tdy;
                } else {
                    $d += $tdydx;
                    $y++;
                }
            }
        }

        
    }

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
