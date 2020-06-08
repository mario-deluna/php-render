<?php 

namespace PHPR;

use PHPR\Buffer\Buffer2D;
use PHPR\Math\IVec2;

class Rasterizer
{
    /**
     * Canvas size
     */
    private int $width;
    private int $height;

    /**
     * Constructor
     */
    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    /** 
     * Raster a single line in buffer cords
     *
     * @param int           $x1
     * @param int           $y1
     * @param int           $x2
     * @param int           $y2
     * @param array         $pixels 
     */
    public function rasterLine(int $x1, int $y1, int $x2, int $y2, ?array &$pixels, bool $tailless = false)
    {
        // Bresenham Algorithm
        // --

        $dx = abs($x2 - $x1);
        $dy = -abs($y2 - $y1);

        $sx = $x1 < $x2 ? 1 : -1;
        $sy = $y1 < $y2 ? 1 : -1;

        $e = $dx + $dy;

        while (1) 
        {
            if ($tailless && ($x1 === $x2 && $y1 === $y2)) break;

            $pixels[] = $x1;
            $pixels[] = $y1;

            if ($x1 >= $this->width) break;
            if ($y1 >= $this->height) break;

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

    /** 
     * Raster a triangle in buffer cords
     *
     * @param int           $x1
     * @param int           $y1
     * @param int           $x2
     * @param int           $y2
     * @param int           $x3
     * @param int           $y3
     * @param array         $pixels 
     */
    public function rasterTriangle(int $x1, int $y1, int $x2, int $y2, int $x3, int $y3, ?array &$pixels)
    {
        $tripixels = [];

        $this->rasterLine($x1, $y1, $x2, $y2, $tripixels, true);
        $this->rasterLine($x2, $y2, $x3, $y3, $tripixels, true);
        $this->rasterLine($x3, $y3, $x1, $y1, $tripixels, true);

        $miny = min($y1, $y2, $y3);
        $maxy = max($y1, $y2, $y3);

        // we know the y range from the lines
        $scanlineMax = $scanlineMin = array_fill_keys(range($miny, $maxy), null);

        // find min max x values for each line
        for($i = 0; $i < count($tripixels); $i+=2) 
        {
            $x = $tripixels[$i+0];
            $y = $tripixels[$i+1];

            $currMin = &$scanlineMin[$y];
            $currMax = &$scanlineMax[$y];

            if (is_null($currMin) || $x < $currMin) {
                $currMin = $x;
            }

            if (is_null($currMax) || $x > $currMax) {
                $currMax = $x;
            }
        }

        // now reduce the edge
        foreach($scanlineMin as $y => $min) 
        {
            $max = $scanlineMax[$y];

            // skip if they are the same meaning we 
            // are already covered by the line itslef
            if ($max === $min) continue;

            // reduce one of each side
            $min++;
            $max--;

            // add the filling
            for($i=$min; $i<$max; $i++) {
                $tripixels[] = $i;
                $tripixels[] = $y;
            }
        }

        // append the pixels
        array_push($pixels, ...$tripixels);
    }
}
