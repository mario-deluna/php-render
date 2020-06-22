<?php

namespace PHPR\Math;

class IVec3 
{
    public int $x;
    public int $y;
    public int $z;

    public function __construct(int $x, int $y, int $z) 
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    /**
     * Vector length
     */
    public function length() : int
    {
        return sqrt($this->x * $this->x + $this->y * $this->y + $this->z * $this->z);
    }

    /**
     * Normalize the given vector
     */
    public static function _normalize(IVec3 $vector, ?IVec3 &$result = null)
    {
        if (is_null($result)) $result = new IVec3(0, 0, 0);

        $length = $vector->length();

        if ($length > 0) { 
           $result->x = $vector->x / $length;
           $result->y = $vector->y / $length;
           $result->z = $vector->z / $length;

        } else { 
           $result->x = 0;
           $result->y = 0;
           $result->z = 0;

        }

        return $result;
    }

    /**
     * Normalize the current vector
     */
    public function normalize()
    {
        IVec3::_normalize($this, $this); return $this;
    }
    
    /**
     * Add two vectors together
     */
    public static function _add(IVec3 $left, IVec3 $right, ?IVec3 &$result = null)
    {
        if (is_null($result)) $result = new IVec3(0, 0, 0);
        
        $result->x = $left->x + $right->x;
        $result->y = $left->y + $right->y;
        $result->z = $left->z + $right->z;

        return $result;
    }
    
    /**
     * Add a vector to the current one
     */
    public function add(IVec3 $right)
    {
        IVec3::_add($this, $right, $this); return $this;
    }
    
    /**
     * Substract a vector of another one
     */
    public static function _substract(IVec3 $left, IVec3 $right, ?IVec3 &$result = null)
    {
        if (is_null($result)) $result = new IVec3(0, 0, 0);
        
        $result->x = $left->x - $right->x;
        $result->y = $left->y - $right->y;
        $result->z = $left->z - $right->z;

        return $result;
    }

    /**
     * Substract a vector to the current one
     */
    public function substract(IVec3 $right)
    {
        IVec3::_substract($this, $right, $this); return $this;
    }
    
    /**
     * Multiply a vector by a scalar value
     */
    public static function _multiply(IVec3 $left, int $value, ?IVec3 &$result = null)
    {
        if (is_null($result)) $result = new IVec3(0, 0, 0);
        
        $result->x = $left->x * $value;
        $result->y = $left->y * $value;
        $result->z = $left->z * $value;

        return $result;
    }

    /**
     * Multiply the current vector by a scalar value
     */
    public function multiply(int $value)
    {
        IVec3::_multiply($this, $value, $this); return $this;
    }
    
    /**
     * Divide a vector by a scalar value
     */
    public static function _divide(IVec3 $left, int $value, ?IVec3 &$result = null)
    {
        if ($value == 0) throw new \Exception("Division by zero. Please don't...");

        if (is_null($result)) $result = new IVec3(0, 0, 0);
        
        $result->x = $left->x / $value;
        $result->y = $left->y / $value;
        $result->z = $left->z / $value;

        return $result;
    }

    /**
     * Divide the current vector by a scalar value
     */
    public function divide(int $value)
    {
        IVec3::_divide($this, $value, $this); return $this;
    }

    /**
     * Converts the vector into an integer representing a color or anything you want it to be 
     */
    public function toColorInt() : int
    {
        return (($this->x * 255 & 0xff) << 16) + (($this->y * 255 & 0xff) << 8) + ($this->z * 255  & 0xff);
    }

    /**
     * Just return the data as array
     */
    public function raw() : array
    {
        return [$this->x, $this->y, $this->z];
    }
}
