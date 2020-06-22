<?php

namespace PHPR\Math;

class IVec2 
{
    /**
     * x value
     * 
     * @var int
     */
    public int $x;

    /**
     * y value
     * 
     * @var int
     */
    public int $y;
    
    /**
     * Constructor
     *
     * @param int         $x
     * @param int         $y
     */
    public function __construct(int $x, int $y) 
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * Vector length
     *
     * @return int
     */
    public function length() : int
    {
        return sqrt($this->x * $this->x + $this->y * $this->y);
    }

    /**
     * Normalize the given vector
     *
     * @param IVec2           $vector The vector to base the normalization on.
     * @param IVec2|null      $result The vector the result is written to.
     *
     * @return IVec2                   The result vector. 
     */
    public static function _normalize(IVec2 $vector, ?IVec2 &$result = null) : IVec2
    {
        if (is_null($result)) $result = new IVec2(0, 0);

        $length = $vector->length();

        if ($length > 0) {
            $length = 1 / $length;
           $result->x = $vector->x * $length;
           $result->y = $vector->y * $length;

        } else { 
           $result->x = 0;
           $result->y = 0;

        }

        return $result;
    }

    /**
     * Normalize the current vector
     *
     * @return self
     */
    public function normalize()
    {
        IVec2::_normalize($this, $this); return $this;
    }
    
    /**
     * Vector dot product
     */
    public static function _dot(IVec2 $left, IVec2 $right) : int
    {   
        return $left->x * $right->x + $left->y * $right->y;
    }

    /**
     * Vector dot product
     */
    public function dot(IVec2 $right) : int
    {
        return IVec2::_dot($this, $right);
    }
    
    /**
     * Vector dot product
     */
    public static function _distance(IVec2 $left, IVec2 $right) : int
    {   
        return sqrt(
          ($left->x - $right->x) * ($left->x - $right->x) + 
          ($left->y - $right->y) * ($left->y - $right->y));
    }

    /**
     * Vector dot product
     */
    public function distance(IVec2 $right) : int
    {
        return IVec2::_distance($this, $right);
    }
    
    /**
     * Add two vectors together
     */
    public static function _add(IVec2 $left, IVec2 $right, ?IVec2 &$result = null)
    {
        if (is_null($result)) $result = new IVec2(0, 0);
        
        $result->x = $left->x + $right->x;
        $result->y = $left->y + $right->y;

        return $result;
    }
    
    /**
     * Add a vector to the current one
     */
    public function add(IVec2 $right)
    {
        IVec2::_add($this, $right, $this); return $this;
    }
    
    /**
     * Substract a vector of another one
     */
    public static function _substract(IVec2 $left, IVec2 $right, ?IVec2 &$result = null)
    {
        if (is_null($result)) $result = new IVec2(0, 0);
        
        $result->x = $left->x - $right->x;
        $result->y = $left->y - $right->y;

        return $result;
    }

    /**
     * Substract a vector to the current one
     */
    public function substract(IVec2 $right)
    {
        IVec2::_substract($this, $right, $this); return $this;
    }
    
    /**
     * Multiply a vector by a scalar value
     */
    public static function _multiply(IVec2 $left, int $value, ?IVec2 &$result = null)
    {
        if (is_null($result)) $result = new IVec2(0, 0);
        
        $result->x = $left->x * $value;
        $result->y = $left->y * $value;

        return $result;
    }

    /**
     * Multiply the current vector by a scalar value
     */
    public function multiply(int $value)
    {
        IVec2::_multiply($this, $value, $this); return $this;
    }
    
    /**
     * Divide a vector by a scalar value
     */
    public static function _divide(IVec2 $left, int $value, ?IVec2 &$result = null)
    {
        if ($value == 0) throw new \Exception("Division by zero. Please don't...");

        if (is_null($result)) $result = new IVec2(0, 0);
        
        $result->x = $left->x / $value;
        $result->y = $left->y / $value;

        return $result;
    }

    /**
     * Divide the current vector by a scalar value
     */
    public function divide(int $value)
    {
        IVec2::_divide($this, $value, $this); return $this;
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
