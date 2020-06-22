<?php

namespace PHPR\Math;

class Vec2 
{
    public float $x;
    public float $y;

    public function __construct(float $x, float $y) 
    {
        $this->x = $x;
        $this->y = $y;
    }
    
    /**
     * Add two vectors together
     */
    public static function _add(Vec2 $left, Vec2 $right, ?Vec2 &$result = null)
    {
        if (is_null($result)) $result = new Vec2(0, 0);
        
        $result->x = $left->x + $right->x;
        $result->y = $left->y + $right->y;

        return $result;
    }
    
    /**
     * Add a vector to the current one
     */
    public function add(Vec2 $right)
    {
        Vec2::_add($this, $right, $this); return $this;
    }
    
    /**
     * Substract a vector of another one
     */
    public static function _substract(Vec2 $left, Vec2 $right, ?Vec2 &$result = null)
    {
        if (is_null($result)) $result = new Vec2(0, 0);
        
        $result->x = $left->x - $right->x;
        $result->y = $left->y - $right->y;

        return $result;
    }

    /**
     * Substract a vector to the current one
     */
    public function substract(Vec2 $right)
    {
        Vec2::_substract($this, $right, $this); return $this;
    }
    
    /**
     * Multiply a vector by a scalar value
     */
    public static function _multiply(Vec2 $left, float $value, ?Vec2 &$result = null)
    {
        if (is_null($result)) $result = new Vec2(0, 0);
        
        $result->x = $left->x * $value;
        $result->y = $left->y * $value;

        return $result;
    }

    /**
     * Multiply the current vector by a scalar value
     */
    public function multiply(float $value)
    {
        Vec2::_multiply($this, $value, $this); return $this;
    }
    
    /**
     * Divide a vector by a scalar value
     */
    public static function _divide(Vec2 $left, float $value, ?Vec2 &$result = null)
    {
        if ($value == 0) throw new \Exception("Division by zero. Please don't...");

        if (is_null($result)) $result = new Vec2(0, 0);
        
        $result->x = $left->x / $value;
        $result->y = $left->y / $value;

        return $result;
    }

    /**
     * Divide the current vector by a scalar value
     */
    public function divide(float $value)
    {
        Vec2::_divide($this, $value, $this); return $this;
    }

    /**
     * Converts the vector into an integer representing a color or anything you want it to be 
     */
    public function toColorInt() : int
    {
        return (($this->x * 255 & 0xff) << 8) + ($this->y * 255  & 0xff);
    }

    /**
     * Just return the data as array
     */
    public function raw() : array
    {
        return [$this->x, $this->y];
    }
}
