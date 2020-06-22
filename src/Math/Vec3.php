<?php

namespace PHPR\Math;

class Vec3 
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
     * Constructor
     *
     * @param float         $x
     * @param float         $y
     * @param float         $z
     */
    public function __construct(float $x, float $y, float $z) 
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    /**
     * Vector length
     *
     * @return float
     */
    public function length() : float
    {
        return sqrt($this->x * $this->x + $this->y * $this->y + $this->z * $this->z);
    }

    /**
     * Normalize the given vector
     *
     * @param Vec3           $vector The vector to base the normalization on.
     * @param Vec3|null      $result The vector the result is written to.
     *
     * @return Vec3                   The result vector. 
     */
    public static function _normalize(Vec3 $vector, ?Vec3 &$result = null) : Vec3
    {
        if (is_null($result)) $result = new Vec3(0, 0, 0);

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
        Vec3::_normalize($this, $this); return $this;
    }
    
    /**
     * Dot Product
     *
     * @param Vec3           $left
     * @param Vec3           $right
     *
     * @return float
     */
    public static function _dot(Vec3 $left, Vec3 $right) : float
    {   
        return $left->x * $right->x + $left->y * $right->y + $left->z * $right->z;
    }

    /**
     * Dot product with self
     *
     * @param Vec3               $right
     * @return float
     */
    public function dot(Vec3 $right) : float
    {
        return Vec3::_dot($this, $right);
    }
    
    /**
     * Distance
     *
     * @param Vec3           $left
     * @param Vec3           $right
     *
     * @return float
     */
    public static function _distance(Vec3 $left, Vec3 $right) : float
    {   
        return sqrt(
          ($left->x - $right->x) * ($left->x - $right->x) + 
          ($left->y - $right->y) * ($left->y - $right->y) + 
          ($left->z - $right->z) * ($left->z - $right->z));
    }

    /**
     * Distance from self
     *
     * @param Vec3               $right
     * @return float
     */
    public function distance(Vec3 $right) : float
    {
        return Vec3::_distance($this, $right);
    }

    /**
     *  Add two vectors together
     *
     * @param Vec3           $left
     * @param Vec3           $right
     * @param Vec3|null      $result The vector the result is written to.
     *
     * @return Vec3                   The result vector. 
     */
    public static function _add(Vec3 $left, Vec3 $right, ?Vec3 &$result = null) : Vec3
    {
        if (is_null($result)) $result = new Vec3(0, 0, 0);
        
        $result->x = $left->x + $right->x;
        $result->y = $left->y + $right->y;
        $result->z = $left->z + $right->z;

        return $result;
    }
    
    /**
     * Add a vector to the current one
     *
     * @param Vec3               $right 
     * @return self
     */
    public function add(Vec3 $right)
    {
        Vec3::_add($this, $right, $this); return $this;
    }
    
    /**
     *  Substract a vector of another one
     *
     * @param Vec3           $left
     * @param Vec3           $right
     * @param Vec3|null      $result The vector the result is written to.
     *
     * @return Vec3                   The result vector. 
     */
    public static function _substract(Vec3 $left, Vec3 $right, ?Vec3 &$result = null)
    {
        if (is_null($result)) $result = new Vec3(0, 0, 0);
        
        $result->x = $left->x - $right->x;
        $result->y = $left->y - $right->y;
        $result->z = $left->z - $right->z;

        return $result;
    }

    /**
     * Substract a vector to the current one
     *
     * @param Vec3               $right 
     * @return self
     */
    public function substract(Vec3 $right)
    {
        Vec3::_substract($this, $right, $this); return $this;
    }
    
    /**
     * Multiply a vector by a scalar value
     */
    public static function _multiply(Vec3 $left, float $value, ?Vec3 &$result = null)
    {
        if (is_null($result)) $result = new Vec3(0, 0, 0);
        
        $result->x = $left->x * $value;
        $result->y = $left->y * $value;
        $result->z = $left->z * $value;

        return $result;
    }

    /**
     * Multiply the current vector by a scalar value
     */
    public function multiply(float $value)
    {
        Vec3::_multiply($this, $value, $this); return $this;
    }
    
    /**
     * Divide a vector by a scalar value
     */
    public static function _divide(Vec3 $left, float $value, ?Vec3 &$result = null)
    {
        if ($value == 0) throw new \Exception("Division by zero. Please don't...");

        if (is_null($result)) $result = new Vec3(0, 0, 0);
        
        $result->x = $left->x / $value;
        $result->y = $left->y / $value;
        $result->z = $left->z / $value;

        return $result;
    }

    /**
     * Divide the current vector by a scalar value
     */
    public function divide(float $value)
    {
        Vec3::_divide($this, $value, $this); return $this;
    }
    
    /**
     * Add two vectors together
     */
    public static function _cross(Vec3 $left, Vec3 $right, ?Vec3 &$result = null)
    {
        if (is_null($result)) $result = new Vec3(0, 0, 0);
    
        $result->x = $left->y * $right->z - $left->z * $right->y;
        $result->y = $left->z * $right->x - $left->x * $right->z;
        $result->z = $left->x * $right->y - $left->y * $right->x;
        
        return $result;
    }
    
    /**
     * Add a vector to the current one
     */
    public function cross(Vec3 $right)
    {
        Vec3::_cross($this, $right, $this); return $this;
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
