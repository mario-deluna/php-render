<?php

namespace PHPR\Math;

class Mat4 
{
    /**
     * Matrix values
     *
     *      [ 0], [ 1], [ 2], [ 3],
     *      [ 4], [ 5], [ 6], [ 7],
     *      [ 8], [ 9], [10], [11],
     *      [12], [13], [14], [15],
     * 
     * @var array
     */
    private array $values = [];

    /**
     * Construct a new matrix
     *
     * @param array                 $values
     */
    public function __construct(?array $values = null)
    {
        if (is_null($values)) {
            $this->reset();
        } else {
            if (count($values) !== 16) throw new \Exception("Invalid data size given to matrix constructor.");
            $this->values = $values;
        }
    }

    /**
     * Reset the matrix to default identity
     *
     * @return void
     */
    public function reset()
    {
        $this->values = [
            1.0, 0.0, 0.0, 0.0,
            0.0, 1.0, 0.0, 0.0,
            0.0, 0.0, 1.0, 0.0,
            0.0, 0.0, 0.0, 1.0,
        ];
    }

    /**
     * Multiplication with scalar 
     *
     * @param Mat4              $left 
     * @param float             $value
     * @param Mat4|null         $result
     *
     * @return Mat4
     */
    public static function _multiplyScalar(Mat4 $left, float $value, ?Mat4 &$result = null) : Mat4
    {
        if (is_null($result)) $result = new Mat4;
        $resultValues = &$result->valueRef();

        for ($i = 0; $i < 16; ++$i) {
            $resultValues[$i] *= $value;
        }

        return $result;
    }

    /**
     * Multiply by scalar
     *
     * @param float             $value
     */
    public function multiplyScalar(float $value)
    {
        Mat4::_multiplyScalar($this, $value, $this); return $this; 
    }

    /**
     * Multiplication with vector 
     *
     * @param Mat4              $left 
     * @param Vec4              $vec
     * @param Vec4|null         $result
     *
     * @return Vec4
     */
    public static function _multiplyVec4(Mat4 $left, Vec4 $vec, ?Vec4 &$result = null) : Vec4
    {
        if (is_null($result)) $result = new Vec4(0, 0, 0, 0);
        $leftValues = &$left->valueRef();

        $result->x = $leftValues[0] * $vec->x + $leftValues[4] * $vec->y + $leftValues[8] * $vec->z + $leftValues[12] * $vec->w;
        $result->y = $leftValues[1] * $vec->x + $leftValues[5] * $vec->y + $leftValues[9] * $vec->z + $leftValues[13] * $vec->w;
        $result->z = $leftValues[2] * $vec->x + $leftValues[6] * $vec->y + $leftValues[10] * $vec->z + $leftValues[14] * $vec->w;
        $result->w = $leftValues[3] * $vec->x + $leftValues[7] * $vec->y + $leftValues[11] * $vec->z + $leftValues[15] * $vec->w;

        return $result;
    }

    /**
     * Multiply the current matrix with the given vector
     *
     * @param Vec4                  $vec 
     * @return Vec4
     */ 
    public function multiplyVec4(Vec4 $vec) : Vec4
    {
        return Mat4::_multiplyVec4($this, $vec);
    }

    /**
     * Multiplication with vector 
     *
     * @param Mat4              $left 
     * @param Mat4              $right
     * @param Mat4|null         $result
     *
     * @return Mat4
     */
    public static function _multiply(Mat4 $left, Mat4 $right, ?Mat4 &$result = null) : Mat4
    {
        if (is_null($result)) $result = new Mat4;

        // dont multiply already multiplied values
        if ($left === $result) {
            $leftValues = $left->raw();
        } else {
            $leftValues = &$left->valueRef();
        }

        $rightValues = &$right->valueRef();
        $resultValues = &$result->valueRef();

        $resultValues[0] = (($leftValues[0] * $rightValues[0]) +
             ($leftValues[1] * $rightValues[4]) +
             ($leftValues[2] * $rightValues[8]) +
             ($leftValues[3] * $rightValues[12]));
        $resultValues[1] = (($leftValues[0] * $rightValues[1]) +
             ($leftValues[1] * $rightValues[5]) +
             ($leftValues[2] * $rightValues[9]) +
             ($leftValues[3] * $rightValues[13]));
        $resultValues[2] = (($leftValues[0] * $rightValues[2]) +
             ($leftValues[1] * $rightValues[6]) +
             ($leftValues[2] * $rightValues[10]) +
             ($leftValues[3] * $rightValues[14]));
        $resultValues[3] = (($leftValues[0] * $rightValues[3]) +
             ($leftValues[1] * $rightValues[7]) +
             ($leftValues[2] * $rightValues[11]) +
             ($leftValues[3] * $rightValues[15]));

        $resultValues[4] = (($leftValues[4] * $rightValues[0]) +
             ($leftValues[5] * $rightValues[4]) +
             ($leftValues[6] * $rightValues[8]) +
             ($leftValues[7] * $rightValues[12]));
        $resultValues[5] = (($leftValues[4] * $rightValues[1]) +
             ($leftValues[5] * $rightValues[5]) +
             ($leftValues[6] * $rightValues[9]) +
             ($leftValues[7] * $rightValues[13]));
        $resultValues[6] = (($leftValues[4] * $rightValues[2]) +
             ($leftValues[5] * $rightValues[6]) +
             ($leftValues[6] * $rightValues[10]) +
             ($leftValues[7] * $rightValues[14]));
        $resultValues[7] = (($leftValues[4] * $rightValues[3]) +
             ($leftValues[5] * $rightValues[7]) +
             ($leftValues[6] * $rightValues[11]) +
             ($leftValues[7] * $rightValues[15]));

        $resultValues[8] = (($leftValues[8] * $rightValues[0]) +
             ($leftValues[9] * $rightValues[4]) +
             ($leftValues[10] * $rightValues[8]) +
             ($leftValues[11] * $rightValues[12]));
        $resultValues[9] = (($leftValues[8] * $rightValues[1]) +
             ($leftValues[9] * $rightValues[5]) +
             ($leftValues[10] * $rightValues[9]) +
             ($leftValues[11] * $rightValues[13]));
        $resultValues[10] = (($leftValues[8] * $rightValues[2]) +
             ($leftValues[9] * $rightValues[6]) +
             ($leftValues[10] * $rightValues[10]) +
             ($leftValues[11] * $rightValues[14]));
        $resultValues[11] = (($leftValues[8] * $rightValues[3]) +
             ($leftValues[9] * $rightValues[7]) +
             ($leftValues[10] * $rightValues[11]) +
             ($leftValues[11] * $rightValues[15]));

        $resultValues[12] = (($leftValues[12] * $rightValues[0]) +
             ($leftValues[13] * $rightValues[4]) +
             ($leftValues[14] * $rightValues[8]) +
             ($leftValues[15] * $rightValues[12]));
        $resultValues[13] = (($leftValues[12] * $rightValues[1]) +
             ($leftValues[13] * $rightValues[5]) +
             ($leftValues[14] * $rightValues[9]) +
             ($leftValues[15] * $rightValues[13]));
        $resultValues[14] = (($leftValues[12] * $rightValues[2]) +
             ($leftValues[13] * $rightValues[6]) +
             ($leftValues[14] * $rightValues[10]) +
             ($leftValues[15] * $rightValues[14]));
        $resultValues[15] = (($leftValues[12] * $rightValues[3]) +
             ($leftValues[13] * $rightValues[7]) +
             ($leftValues[14] * $rightValues[11]) +
             ($leftValues[15] * $rightValues[15]));  

        return $result;
    }

    /**
     * Multiply the current matrix with the given vector
     *
     * @param Mat4                  $vec 
     * @return Mat4
     */ 
    public function multiply(Mat4 $right) : Mat4
    {
        return Mat4::_multiply($this, $right, $this);
    }

    /**
     * Translate the matrix
     *
     * @param Mat4              $left 
     * @param Vec3              $vec
     * @param Mat4|null         $result
     *
     * @return Mat4
     */
    public static function _translate(Mat4 $left, Vec3 $vec, ?Mat4 &$result = null) : Mat4
    {
        if (is_null($result)) $result = new Mat4;

        // dont multiply already multiplied values
        if ($left === $result) {
            $leftValues = $left->raw();
        } else {
            $leftValues = &$left->valueRef();
        }

        $resultValues = &$result->valueRef();

        $resultValues[12] = $leftValues[0] * $vec->x + $leftValues[4] * $vec->y + $leftValues[8] * $vec->z + $leftValues[12];
        $resultValues[13] = $leftValues[1] * $vec->x + $leftValues[5] * $vec->y + $leftValues[9] * $vec->z + $leftValues[13];
        $resultValues[14] = $leftValues[2] * $vec->x + $leftValues[6] * $vec->y + $leftValues[10] * $vec->z + $leftValues[14];
        $resultValues[15] = $leftValues[3] * $vec->x + $leftValues[7] * $vec->y + $leftValues[11] * $vec->z + $leftValues[15];  

        return $result;
    }

    /**
     * Translate the current matrix with the given vector
     *
     * @param Vec3                  $vec 
     * @return Mat4
     */ 
    public function translate(Vec3 $vec) : Mat4
    {
        return Mat4::_translate($this, $vec, $this);
    }

    /**
     * Create an orthographic projection matrix
     *
     * @param flaot              $left 
     * @param flaot              $right 
     * @param flaot              $bottom 
     * @param flaot              $top 
     * @param flaot              $near 
     * @param flaot              $far 
     * @param Mat4|null          $result
     *
     * @return Mat4
     */
    public static function ortho(float $left, float $right, float $bottom, float $top, float $near, float $far, ?Mat4 &$result = null) : Mat4
    {
        if (is_null($result)) $result = new Mat4;
        $resultValues = &$result->valueRef();

        $resultValues[0] = -2 / ($left - $right);
        $resultValues[1] = 0.0;
        $resultValues[2] = 0.0;
        $resultValues[3] = 0.0;
        $resultValues[4] = 0.0;
        $resultValues[5] = -2 / ($bottom - $top);
        $resultValues[6] = 0.0;
        $resultValues[7] = 0.0;
        $resultValues[8] = 0.0;
        $resultValues[9] = 0.0;
        $resultValues[10] = 2 / ($near - $far);
        $resultValues[11] = 0.0;
        $resultValues[12] = -($right + $left) / ($right - $left);
        //$resultValues[12] = ($left + $right) * ($left - $right);
        $resultValues[13] = -($top + $bottom) / ($top - $bottom);
        // $resultValues[13] = ($top + $bottom) * ($bottom - $top);
        $resultValues[14] = -($far + $near) / ($far - $near);
        // $resultValues[14] = ($far + $near) * ($near - $far);
        $resultValues[15] = 1.0;

        return $result;
    }

    /**
     * Get the matrix data
     *
     * @return array
     */
    public function raw() : array
    {
        return $this->values;
    }

    public function &valueRef() : array
    {
        return $this->values;
    }

    /**
     * Dump the values  
     */
    public function __toString()
    {
        return sprintf(
'Mat4:
(
    [%.2f, %.2f, %.2f, %.2f]
    [%.2f, %.2f, %.2f, %.2f]
    [%.2f, %.2f, %.2f, %.2f]
    [%.2f, %.2f, %.2f, %.2f]
)', ...$this->values
        );
    }
}
