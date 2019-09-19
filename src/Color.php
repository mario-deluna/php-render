<?php 

namespace PHPR;

class Color
{
    public $r;
    public $g;
    public $b;
    public $a;

    public static function intToRGB(int $color) : array
    {
        return [($color >> 16) & 0xFF, ($color >> 8) & 0xFF, $color & 0xFF];
    }

    public static function intToRGBA(int $color) : array
    {
        return [($color >> 24) & 0xFF, ($color >> 16) & 0xFF, ($color >> 8) & 0xFF, $color & 0xFF];
    }

    public static function fromInt3(int $color)
    {
        $c = static::intToRGB($color);
        return new static($c[0] / 0xFF, $c[1] / 0xFF, $c[2] / 0xFF);
    }

    public static function fromInt4(int $color)
    {
        $c = static::intToRGBA($color);
        return new static($c[0] / 0xFF, $c[1] / 0xFF, $c[2] / 0xFF, $c[3] / 0xFF);
    }

    public function __construct(float $r, float $g, float $b, float $a = null) 
    {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
        $this->a = $a;
    }
}
