<?php

namespace PHPR\Math;

class Vec4 
{
    public float $x;
    public float $y;
    public float $z;
    public float $w;

    public function __construct(float $x, float $y, float $z, float $w) 
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
        $this->w = $w;
    }

    /**
     * Vector length
     */
    public function length() : float
    {
        return sqrt($this->x * $this->x + $this->y * $this->y + $this->z * $this->z + $this->w * $this->w);
    }

    /**
     * Normalize the given vector
     */
    public static function _normalize(Vec4 $vector, ?Vec4 &$result = null)
    {
        if (is_null($result)) $result = new Vec4(0, 0, 0, 0);

        $length = $vector->length();

        if ($length > 0) { 
           $result->x = $vector->x / $length;
           $result->y = $vector->y / $length;
           $result->z = $vector->z / $length;
           $result->w = $vector->w / $length;

        } else { 
           $result->x = 0;
           $result->y = 0;
           $result->z = 0;
           $result->w = 0;

        }

        return $result;
    }

    /**
     * Normalize the current vector
     */
    public function normalize()
    {
        Vec4::_normalize($this, $this); return $this;
    }
    
    /**
     * Add two vectors together
     */
    public static function _add(Vec4 $left, Vec4 $right, ?Vec4 &$result = null)
    {
        if (is_null($result)) $result = new Vec4(0, 0, 0, 0);
        
        $result->x = $left->x + $right->x;
        $result->y = $left->y + $right->y;
        $result->z = $left->z + $right->z;
        $result->w = $left->w + $right->w;

        return $result;
    }
    
    /**
     * Add a vector to the current one
     */
    public function add(Vec4 $right)
    {
        Vec4::_add($this, $right, $this); return $this;
    }
    
    /**
     * Substract a vector of another one
     */
    public static function _substract(Vec4 $left, Vec4 $right, ?Vec4 &$result = null)
    {
        if (is_null($result)) $result = new Vec4(0, 0, 0, 0);
        
        $result->x = $left->x - $right->x;
        $result->y = $left->y - $right->y;
        $result->z = $left->z - $right->z;
        $result->w = $left->w - $right->w;

        return $result;
    }

    /**
     * Substract a vector to the current one
     */
    public function substract(Vec4 $right)
    {
        Vec4::_substract($this, $right, $this); return $this;
    }
    
    /**
     * Multiply a vector by a scalar value
     */
    public static function _multiply(Vec4 $left, float $value, ?Vec4 &$result = null)
    {
        if (is_null($result)) $result = new Vec4(0, 0, 0, 0);
        
        $result->x = $left->x * $value;
        $result->y = $left->y * $value;
        $result->z = $left->z * $value;
        $result->w = $left->w * $value;

        return $result;
    }

    /**
     * Multiply the current vector by a scalar value
     */
    public function multiply(float $value)
    {
        Vec4::_multiply($this, $value, $this); return $this;
    }
    
    /**
     * Divide a vector by a scalar value
     */
    public static function _divide(Vec4 $left, float $value, ?Vec4 &$result = null)
    {
        if ($value == 0) throw new \Exception("Division by zero. Please don't...");

        if (is_null($result)) $result = new Vec4(0, 0, 0, 0);
        
        $result->x = $left->x / $value;
        $result->y = $left->y / $value;
        $result->z = $left->z / $value;
        $result->w = $left->w / $value;

        return $result;
    }

    /**
     * Divide the current vector by a scalar value
     */
    public function divide(float $value)
    {
        Vec4::_divide($this, $value, $this); return $this;
    }

    /**
     * Converts the vector into an integer representing a color or anything you want it to be 
     */
    public function toColorInt() : int
    {
        return (($this->x * 255 & 0xff) << 24) + (($this->y * 255 & 0xff) << 16) + (($this->z * 255 & 0xff) << 8) + ($this->w * 255  & 0xff);
    }

    /**
     * Just return the data as array
     */
    public function raw() : array
    {
        return [$this->x, $this->y, $this->z, $this->w];
    }
}
