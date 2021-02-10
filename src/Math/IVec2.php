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
     * @param IVec2           $vector The vector to base the absoultes on.
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
     * Absolute of the given vector
     *
     * @param IVec2           $vector The vector to base the normalization on.
     * @param IVec2|null      $result The vector the result is written to.
     *
     * @return IVec2                   The result vector. 
     */
    public static function _abs(IVec2 $vector, ?IVec2 &$result = null) : IVec2
    {
        if (is_null($result)) $result = new IVec2(0, 0);

        $result->x = abs($vector->x);
        $result->y = abs($vector->y);


        return $result;
    }

    /**
     * Absolute of the current vector
     *
     * @return self
     */
    public function abs()
    {
        IVec2::_abs($this, $this); return $this;
    }

    /**
     * Clamp the given vector
     *
     * @param IVec2           $vector The vector to base the clamp on.
     * @param IVec2|null      $result The vector the result is written to.
     *
     * @return IVec2                   The result vector. 
     */
    public static function _clamp(IVec2 $vector, ?IVec2 &$result = null) : IVec2
    {
        if (is_null($result)) $result = new IVec2(0, 0);

        $result->x = max(min($vector->x, 1.0), 0.0);
        $result->y = max(min($vector->y, 1.0), 0.0);

        return $result;
    }

    /**
     * Clamp the current vector
     *
     * @return self
     */
    public function clamp()
    {
        IVec2::_clamp($this, $this); return $this;
    }
    
    /**
     * Dot Product
     *
     * @param IVec2           $left
     * @param IVec2           $right
     *
     * @return int
     */
    public static function _dot(IVec2 $left, IVec2 $right) : int
    {   
        return $left->x * $right->x + $left->y * $right->y;
    }

    /**
     * Dot product with self
     *
     * @param IVec2               $right
     * @return int
     */
    public function dot(IVec2 $right) : int
    {
        return IVec2::_dot($this, $right);
    }
    
    /**
     * Distance
     *
     * @param IVec2           $left
     * @param IVec2           $right
     *
     * @return int
     */
    public static function _distance(IVec2 $left, IVec2 $right) : int
    {   
        return sqrt(
          ($left->x - $right->x) * ($left->x - $right->x) + 
          ($left->y - $right->y) * ($left->y - $right->y));
    }

    /**
     * Distance from self
     *
     * @param IVec2               $right
     * @return int
     */
    public function distance(IVec2 $right) : int
    {
        return IVec2::_distance($this, $right);
    }

    /**
     *  Add two vectors together
     *
     * @param IVec2           $left
     * @param IVec2           $right
     * @param IVec2|null      $result The vector the result is written to.
     *
     * @return IVec2                   The result vector. 
     */
    public static function _add(IVec2 $left, IVec2 $right, ?IVec2 &$result = null) : IVec2
    {
        if (is_null($result)) $result = new IVec2(0, 0);
        
        $result->x = $left->x + $right->x;
        $result->y = $left->y + $right->y;

        return $result;
    }
    
    /**
     * Add a vector to the current one
     *
     * @param IVec2               $right 
     * @return self
     */
    public function add(IVec2 $right)
    {
        IVec2::_add($this, $right, $this); return $this;
    }
    
    /**
     *  Substract a vector of another one
     *
     * @param IVec2           $left
     * @param IVec2           $right
     * @param IVec2|null      $result The vector the result is written to.
     *
     * @return IVec2                   The result vector. 
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
     *
     * @param IVec2               $right 
     * @return self
     */
    public function substract(IVec2 $right)
    {
        IVec2::_substract($this, $right, $this); return $this;
    }
    
    /**
     *  Multiply a vector by a scalar value
     *
     * @param IVec2           $left
     * @param int       $value
     * @param IVec2|null      $result The vector the result is written to.
     *
     * @return IVec2                   The result vector. 
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
     *
     * @param int       $value
     * @return self
     */
    public function multiply(int $value)
    {
        IVec2::_multiply($this, $value, $this); return $this;
    }
    
    /**
     *  Multiply a vector by another vector
     *
     * @param IVec2           $left
     * @param int       $value
     * @param IVec2|null      $result The vector the result is written to.
     *
     * @return IVec2                   The result vector. 
     */
    public static function _multiplyIVec2(IVec2 $left, IVec2 $right, ?IVec2 &$result = null)
    {
        if (is_null($result)) $result = new IVec2(0, 0);
        
        $result->x = $left->x * $right->x;
        $result->y = $left->y * $right->y;

        return $result;
    }

    /**
     * Multiply the current vector by another vector
     *
     * @param int       $value
     * @return self
     */
    public function multiplyIVec2(IVec2 $right)
    {
        IVec2::_multiplyIVec2($this, $right, $this); return $this;
    }
    
    /**
     *  Divide a vector by a scalar value
     *
     * @param IVec2           $left
     * @param int       $value
     * @param IVec2|null      $result The vector the result is written to.
     *
     * @return IVec2                   The result vector. 
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
     *
     * @param int       $value
     * @return self
     */
    public function divide(int $value)
    {
        IVec2::_divide($this, $value, $this); return $this;
    }

    /**
     * Converts the vector into an integer representing a color or anything you want it to be 
     *
     * @return int
     */
    public function toColorInt() : int
    {
        return (($this->x * 255 & 0xff) << 8) + ($this->y * 255  & 0xff);
    }

    /**
     * Just return the data as array
     *
     * @return array
     */
    public function raw() : array
    {
        return [$this->x, $this->y];
    }

    /**
     * Just copy the vector values to a new object
     *
     * @return IVec2
     */
    public function copy() : IVec2
    {
        return new IVec2($this->x, $this->y);
    }

    /**
     * Prtint the vector in human friendly way
     *
     * @return string
     */
    public function __toString() : string
    {
        return "IVec2({$this->x}, {$this->y})";
    }
}
