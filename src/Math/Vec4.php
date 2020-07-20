<?php

namespace PHPR\Math;

class Vec4 
{
    /**
     * x value
     * 
     * @var float
     */
    public float $x;

    /**
     * y value
     * 
     * @var float
     */
    public float $y;

    /**
     * z value
     * 
     * @var float
     */
    public float $z;

    /**
     * w value
     * 
     * @var float
     */
    public float $w;
    
    /**
     * Vector constructor from Vec2
     *
     * @param Vec2                $vec
     * @return Vec4
     */
    public static function fromVec2(Vec2 $vec) : Vec4
    {
        return new Vec4($vec->x, $vec->y, 0);
    }
    
    /**
     * Vector constructor from Vec3
     *
     * @param Vec3                $vec
     * @return Vec4
     */
    public static function fromVec3(Vec3 $vec) : Vec4
    {
        return new Vec4($vec->x, $vec->y, $vec->z, 0, 1);
    }
    
    /**
     * Constructor
     *
     * @param float         $x
     * @param float         $y
     * @param float         $z
     * @param float         $w
     */
    public function __construct(float $x, float $y, float $z, float $w) 
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
        $this->w = $w;
    }

    /**
     * Vector length
     *
     * @return float
     */
    public function length() : float
    {
        return sqrt($this->x * $this->x + $this->y * $this->y + $this->z * $this->z + $this->w * $this->w);
    }

    /**
     * Normalize the given vector
     *
     * @param Vec4           $vector The vector to base the normalization on.
     * @param Vec4|null      $result The vector the result is written to.
     *
     * @return Vec4                   The result vector. 
     */
    public static function _normalize(Vec4 $vector, ?Vec4 &$result = null) : Vec4
    {
        if (is_null($result)) $result = new Vec4(0, 0, 0, 0);

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
        Vec4::_normalize($this, $this); return $this;
    }

    /**
     * Clamp the given vector
     *
     * @param Vec4           $vector The vector to base the clamp on.
     * @param Vec4|null      $result The vector the result is written to.
     *
     * @return Vec4                   The result vector. 
     */
    public static function _clamp(Vec4 $vector, ?Vec4 &$result = null) : Vec4
    {
        if (is_null($result)) $result = new Vec4(0, 0, 0, 0);

        $result->x = max(min($vector->x, 1.0), 0.0);
        $result->y = max(min($vector->y, 1.0), 0.0);
        $result->z = max(min($vector->z, 1.0), 0.0);
        $result->w = max(min($vector->w, 1.0), 0.0);

        return $result;
    }

    /**
     * Clamp the current vector
     *
     * @return self
     */
    public function clamp()
    {
        Vec4::_clamp($this, $this); return $this;
    }
    
    /**
     * Dot Product
     *
     * @param Vec4           $left
     * @param Vec4           $right
     *
     * @return float
     */
    public static function _dot(Vec4 $left, Vec4 $right) : float
    {   
        return $left->x * $right->x + $left->y * $right->y + $left->z * $right->z + $left->w * $right->w;
    }

    /**
     * Dot product with self
     *
     * @param Vec4               $right
     * @return float
     */
    public function dot(Vec4 $right) : float
    {
        return Vec4::_dot($this, $right);
    }
    
    /**
     * Distance
     *
     * @param Vec4           $left
     * @param Vec4           $right
     *
     * @return float
     */
    public static function _distance(Vec4 $left, Vec4 $right) : float
    {   
        return sqrt(
          ($left->x - $right->x) * ($left->x - $right->x) + 
          ($left->y - $right->y) * ($left->y - $right->y) + 
          ($left->z - $right->z) * ($left->z - $right->z) + 
          ($left->w - $right->w) * ($left->w - $right->w));
    }

    /**
     * Distance from self
     *
     * @param Vec4               $right
     * @return float
     */
    public function distance(Vec4 $right) : float
    {
        return Vec4::_distance($this, $right);
    }

    /**
     *  Add two vectors together
     *
     * @param Vec4           $left
     * @param Vec4           $right
     * @param Vec4|null      $result The vector the result is written to.
     *
     * @return Vec4                   The result vector. 
     */
    public static function _add(Vec4 $left, Vec4 $right, ?Vec4 &$result = null) : Vec4
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
     *
     * @param Vec4               $right 
     * @return self
     */
    public function add(Vec4 $right)
    {
        Vec4::_add($this, $right, $this); return $this;
    }
    
    /**
     *  Substract a vector of another one
     *
     * @param Vec4           $left
     * @param Vec4           $right
     * @param Vec4|null      $result The vector the result is written to.
     *
     * @return Vec4                   The result vector. 
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
     *
     * @param Vec4               $right 
     * @return self
     */
    public function substract(Vec4 $right)
    {
        Vec4::_substract($this, $right, $this); return $this;
    }
    
    /**
     *  Multiply a vector by a scalar value
     *
     * @param Vec4           $left
     * @param float       $value
     * @param Vec4|null      $result The vector the result is written to.
     *
     * @return Vec4                   The result vector. 
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
     *
     * @param float       $value
     * @return self
     */
    public function multiply(float $value)
    {
        Vec4::_multiply($this, $value, $this); return $this;
    }
    
    /**
     *  Multiply a vector by another vector
     *
     * @param Vec4           $left
     * @param float       $value
     * @param Vec4|null      $result The vector the result is written to.
     *
     * @return Vec4                   The result vector. 
     */
    public static function _multiplyVec4(Vec4 $left, Vec4 $right, ?Vec4 &$result = null)
    {
        if (is_null($result)) $result = new Vec4(0, 0, 0, 0);
        
        $result->x = $left->x * $right->x;
        $result->y = $left->y * $right->y;
        $result->z = $left->z * $right->z;
        $result->w = $left->w * $right->w;

        return $result;
    }

    /**
     * Multiply the current vector by another vector
     *
     * @param float       $value
     * @return self
     */
    public function multiplyVec4(Vec4 $right)
    {
        Vec4::_multiplyVec4($this, $right, $this); return $this;
    }
    
    /**
     *  Divide a vector by a scalar value
     *
     * @param Vec4           $left
     * @param float       $value
     * @param Vec4|null      $result The vector the result is written to.
     *
     * @return Vec4                   The result vector. 
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
     *
     * @param float       $value
     * @return self
     */
    public function divide(float $value)
    {
        Vec4::_divide($this, $value, $this); return $this;
    }

    /**
     * Converts the vector into an integer representing a color or anything you want it to be 
     *
     * @return int
     */
    public function toColorInt() : int
    {
        return (($this->x * 255 & 0xff) << 24) + (($this->y * 255 & 0xff) << 16) + (($this->z * 255 & 0xff) << 8) + ($this->w * 255  & 0xff);
    }

    /**
     * Just return the data as array
     *
     * @return array
     */
    public function raw() : array
    {
        return [$this->x, $this->y, $this->z, $this->w];
    }
}
