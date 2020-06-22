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

    public static function _multiplyScalar(Mat4 $left, float $value, ?Mat4 &$result = null)
    {
        if (is_null($result)) $result = new Mat4;
        $resultValues = &$result->valueRef();

        for ($i = 0; $i < 16; ++$i) {
            $resultValues[$i] *= $value;
        }
    }

    public function multiplyScalar(float $value)
    {
        Mat4::_multiplyScalar($this, $value, $this); return $this; 
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
