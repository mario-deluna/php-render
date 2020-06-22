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
     * @param array                 $data
     */
    public function __construct(?array $data = null)
    {
        if (is_null($data)) {
            $this->reset();
        } else {
            if (count($data) !== 16) throw new \Exception("Invalid data size given to matrix constructor.");
            $this->data = $data;
        }
    }

    /**
     * Reset the matrix to default identity
     *
     * @return void
     */
    public function reset()
    {
        $this->data = [
            1.0, 0.0, 0.0, 0.0,
            0.0, 1.0, 0.0, 0.0,
            0.0, 0.0, 1.0, 0.0,
            0.0, 0.0, 0.0, 1.0,
        ];
    }

    /**
     * Get the matrix data
     *
     * @return array
     */
    public function raw() : array
    {
        return $this->data;
    }
}
