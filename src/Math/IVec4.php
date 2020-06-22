<?php

namespace PHPR\Math;

class IVec4 
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
     * z value
     * 
     * @var int
     */
    public int $z;

    /**
     * w value
     * 
     * @var int
     */
    public int $w;
    
    /**
     * Constructor
     *
     * @param int         $x
     * @param int         $y
     * @param int         $z
     * @param int         $w
     */
    public function __construct(int $x, int $y, int $z, int $w) 
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
        $this->w = $w;
    }

    /**
     * Vector length
     *
     * @return int
     */
    public function length() : int
    {
        return sqrt($this->x * $this->x + $this->y * $this->y + $this->z * $this->z + $this->w * $this->w);
    }

    /**
     * Normalize the given vector
     *
     * @param IVec4           $vector The vector to base the normalization on.
     * @param IVec4|null      $result The vector the result is written to.
     *
     * @return IVec4                   The result vector. 
     */
    public static function _normalize(IVec4 $vector, ?IVec4 &$result = null) : IVec4
    {
        if (is_null($result)) $result = new IVec4(0, 0, 0, 0);

        $length = $vector->length();

        if ($length > 0) {
            $length = 1 / $length;
           $result->x = $vector->x * $length;
           $result->y = $vector->y * $length;
           $result->z = $vector->z * $length;
           $result->w = $vector->w * $length;

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
     *
     * @return self
     */
    public function normalize()
    {
        IVec4::_normalize($this, $this); return $this;
    }
    
    /**
     * Vector dot product
     */
    public static function _dot(IVec4 $left, IVec4 $right) : int
    {   
        return $left->x * $right->x + $left->y * $right->y + $left->z * $right->z + $left->w * $right->w;
    }

    /**
     * Vector dot product
     */
    public function dot(IVec4 $right) : int
    {
        return IVec4::_dot($this, $right);
    }
    
    /**
     * Vector dot product
     */
    public static function _distance(IVec4 $left, IVec4 $right) : int
    {   
        return sqrt(
          ($left->x - $right->x) * ($left->x - $right->x) + 
          ($left->y - $right->y) * ($left->y - $right->y) + 
          ($left->z - $right->z) * ($left->z - $right->z) + 
          ($left->w - $right->w) * ($left->w - $right->w));
    }

    /**
     * Vector dot product
     */
    public function distance(IVec4 $right) : int
    {
        return IVec4::_distance($this, $right);
    }
    
    /**
     * Add two vectors together
     */
    public static function _add(IVec4 $left, IVec4 $right, ?IVec4 &$result = null)
    {
        if (is_null($result)) $result = new IVec4(0, 0, 0, 0);
        
        $result->x = $left->x + $right->x;
        $result->y = $left->y + $right->y;
        $result->z = $left->z + $right->z;
        $result->w = $left->w + $right->w;

        return $result;
    }
    
    /**
     * Add a vector to the current one
     */
    public function add(IVec4 $right)
    {
        IVec4::_add($this, $right, $this); return $this;
    }
    
    /**
     * Substract a vector of another one
     */
    public static function _substract(IVec4 $left, IVec4 $right, ?IVec4 &$result = null)
    {
        if (is_null($result)) $result = new IVec4(0, 0, 0, 0);
        
        $result->x = $left->x - $right->x;
        $result->y = $left->y - $right->y;
        $result->z = $left->z - $right->z;
        $result->w = $left->w - $right->w;

        return $result;
    }

    /**
     * Substract a vector to the current one
     */
    public function substract(IVec4 $right)
    {
        IVec4::_substract($this, $right, $this); return $this;
    }
    
    /**
     * Multiply a vector by a scalar value
     */
    public static function _multiply(IVec4 $left, int $value, ?IVec4 &$result = null)
    {
        if (is_null($result)) $result = new IVec4(0, 0, 0, 0);
        
        $result->x = $left->x * $value;
        $result->y = $left->y * $value;
        $result->z = $left->z * $value;
        $result->w = $left->w * $value;

        return $result;
    }

    /**
     * Multiply the current vector by a scalar value
     */
    public function multiply(int $value)
    {
        IVec4::_multiply($this, $value, $this); return $this;
    }
    
    /**
     * Divide a vector by a scalar value
     */
    public static function _divide(IVec4 $left, int $value, ?IVec4 &$result = null)
    {
        if ($value == 0) throw new \Exception("Division by zero. Please don't...");

        if (is_null($result)) $result = new IVec4(0, 0, 0, 0);
        
        $result->x = $left->x / $value;
        $result->y = $left->y / $value;
        $result->z = $left->z / $value;
        $result->w = $left->w / $value;

        return $result;
    }

    /**
     * Divide the current vector by a scalar value
     */
    public function divide(int $value)
    {
        IVec4::_divide($this, $value, $this); return $this;
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
