<?php 

namespace PHPR;

use Shader\Shader;

interface Buffer
{
    /**
     * Constructor
     */
    public function __construct(int $size);

    /**
     * Raw buffer reference
     */
    public function &raw() : array;

    /**
     * Raw buffer copy
     */
    public function rawCopy() : array;

    /**
     * Returns the buffer size
     *
     * @return int
     */
    public function getSize() : int;
}
