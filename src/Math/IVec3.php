<?php

namespace PHPR\Math;

class IVec3 
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
     * Vector constructor from Vec2
     *
     * @param IVec2                $vec
     * @return IVec3
     */
    public static function fromVec2(IVec2 $vec) : IVec3
    {
        return new IVec3($vec->x, $vec->y, 0);
    }
    
    /**
     * Constructor
     *
     * @param int         $x
     * @param int         $y
     * @param int         $z
     */
    public function __construct(int $x, int $y, int $z) 
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    /**
     * Vector length
     *
     * @return int
     */
    public function length() : int
    {
        return sqrt($this->x * $this->x + $this->y * $this->y + $this->z * $this->z);
    }

    /**
     * Normalize the given vector
     *
     * @param IVec3           $vector The vector to base the normalization on.
     * @param IVec3|null      $result The vector the result is written to.
     *
     * @return IVec3                   The result vector. 
     */
    public static function _normalize(IVec3 $vector, ?IVec3 &$result = null) : IVec3
    {
        if (is_null($result)) $result = new IVec3(0, 0, 0);

        $length = $vector->length();

        if ($length > 0) {
            $length = 1 / $length;
           $result->x = $vector->x * $length;
           $result->y = $vector->y * $length;
           $result->z = $vector->z * $length;

        } else { 
           $result->x = 0;
           $result->y = 0;
           $result->z = 0;

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
        IVec3::_normalize($this, $this); return $this;
    }

    /**
     * Clamp the given vector
     *
     * @param IVec3           $vector The vector to base the clamp on.
     * @param IVec3|null      $result The vector the result is written to.
     *
     * @return IVec3                   The result vector. 
     */
    public static function _clamp(IVec3 $vector, ?IVec3 &$result = null) : IVec3
    {
        if (is_null($result)) $result = new IVec3(0, 0, 0);

        $result->x = max(min($vector->x, 1.0), 0.0);
        $result->y = max(min($vector->y, 1.0), 0.0);
        $result->z = max(min($vector->z, 1.0), 0.0);

        return $result;
    }

    /**
     * Clamp the current vector
     *
     * @return self
     */
    public function clamp()
    {
        IVec3::_clamp($this, $this); return $this;
    }
    
    /**
     * Dot Product
     *
     * @param IVec3           $left
     * @param IVec3           $right
     *
     * @return int
     */
    public static function _dot(IVec3 $left, IVec3 $right) : int
    {   
        return $left->x * $right->x + $left->y * $right->y + $left->z * $right->z;
    }

    /**
     * Dot product with self
     *
     * @param IVec3               $right
     * @return int
     */
    public function dot(IVec3 $right) : int
    {
        return IVec3::_dot($this, $right);
    }
    
    /**
     * Distance
     *
     * @param IVec3           $left
     * @param IVec3           $right
     *
     * @return int
     */
    public static function _distance(IVec3 $left, IVec3 $right) : int
    {   
        return sqrt(
          ($left->x - $right->x) * ($left->x - $right->x) + 
          ($left->y - $right->y) * ($left->y - $right->y) + 
          ($left->z - $right->z) * ($left->z - $right->z));
    }

    /**
     * Distance from self
     *
     * @param IVec3               $right
     * @return int
     */
    public function distance(IVec3 $right) : int
    {
        return IVec3::_distance($this, $right);
    }

    /**
     *  Add two vectors together
     *
     * @param IVec3           $left
     * @param IVec3           $right
     * @param IVec3|null      $result The vector the result is written to.
     *
     * @return IVec3                   The result vector. 
     */
    public static function _add(IVec3 $left, IVec3 $right, ?IVec3 &$result = null) : IVec3
    {
        if (is_null($result)) $result = new IVec3(0, 0, 0);
        
        $result->x = $left->x + $right->x;
        $result->y = $left->y + $right->y;
        $result->z = $left->z + $right->z;

        return $result;
    }
    
    /**
     * Add a vector to the current one
     *
     * @param IVec3               $right 
     * @return self
     */
    public function add(IVec3 $right)
    {
        IVec3::_add($this, $right, $this); return $this;
    }
    
    /**
     *  Substract a vector of another one
     *
     * @param IVec3           $left
     * @param IVec3           $right
     * @param IVec3|null      $result The vector the result is written to.
     *
     * @return IVec3                   The result vector. 
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
     *
     * @param IVec3               $right 
     * @return self
     */
    public function substract(IVec3 $right)
    {
        IVec3::_substract($this, $right, $this); return $this;
    }
    
    /**
     *  Multiply a vector by a scalar value
     *
     * @param IVec3           $left
     * @param int       $value
     * @param IVec3|null      $result The vector the result is written to.
     *
     * @return IVec3                   The result vector. 
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
     *
     * @param int       $value
     * @return self
     */
    public function multiply(int $value)
    {
        IVec3::_multiply($this, $value, $this); return $this;
    }
    
    /**
     *  Multiply a vector by another vector
     *
     * @param IVec3           $left
     * @param int       $value
     * @param IVec3|null      $result The vector the result is written to.
     *
     * @return IVec3                   The result vector. 
     */
    public static function _multiplyIVec3(IVec3 $left, IVec3 $right, ?IVec3 &$result = null)
    {
        if (is_null($result)) $result = new IVec3(0, 0, 0);
        
        $result->x = $left->x * $right->x;
        $result->y = $left->y * $right->y;
        $result->z = $left->z * $right->z;

        return $result;
    }

    /**
     * Multiply the current vector by another vector
     *
     * @param int       $value
     * @return self
     */
    public function multiplyIVec3(IVec3 $right)
    {
        IVec3::_multiplyIVec3($this, $right, $this); return $this;
    }
    
    /**
     *  Divide a vector by a scalar value
     *
     * @param IVec3           $left
     * @param int       $value
     * @param IVec3|null      $result The vector the result is written to.
     *
     * @return IVec3                   The result vector. 
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
     *
     * @param int       $value
     * @return self
     */
    public function divide(int $value)
    {
        IVec3::_divide($this, $value, $this); return $this;
    }
    
    /**
     * Cross Product
     *
     * @param IVec3           $left
     * @param IVec3           $right
     * @param IVec3|null      $result The vector the result is written to.
     *
     * @return IVec3                   The result vector. 
     */
    public static function _cross(IVec3 $left, IVec3 $right, ?IVec3 &$result = null)
    {
        if (is_null($result)) $result = new IVec3(0, 0, 0);

        $cleft = clone $left; 
    
        $result->x = $cleft->y * $right->z - $cleft->z * $right->y;
        $result->y = $cleft->z * $right->x - $cleft->x * $right->z;
        $result->z = $cleft->x * $right->y - $cleft->y * $right->x;
        
        return $result;
    }
    
    /**
     * Cross Product
     *
     * @param IVec3               $right 
     * @return self
     */
    public function cross(IVec3 $right)
    {
        IVec3::_cross($this, $right, $this); return $this;
    }

    /**
     * Converts the vector into an integer representing a color or anything you want it to be 
     *
     * @return int
     */
    public function toColorInt() : int
    {
        return (($this->x * 255 & 0xff) << 16) + (($this->y * 255 & 0xff) << 8) + ($this->z * 255  & 0xff);
    }

    /**
     * Just return the data as array
     *
     * @return array
     */
    public function raw() : array
    {
        return [$this->x, $this->y, $this->z];
    }
}
