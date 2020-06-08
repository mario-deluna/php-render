<?php 

namespace PHPR\Buffer;

use PHPR\Buffer;

class BufferInt implements Buffer
{
    /**
     * The array buffer 
     */
    private array $buffer;

    /**
     * Buffer size
     */
    private int $size;

    /**
     * Constructor
     */
    public function __construct(int $size)
    {
        $this->size = $size;
        $this->clear();
    }

    /**
     * Clear the buffer with the given value
     */
    public function clear(int $value = 0x000000)
    {
        $this->buffer = array_fill(0, $this->size, $value);
    }

    /**
     * Raw buffer reference
     */
    public function &raw() : array
    {
        return $this->buffer;
    }

    /**
     * Raw buffer copy
     */
    public function rawCopy() : array
    {
        return $this->buffer;
    }

    /**
     * Returns the buffer size
     *
     * @return int
     */
    public function getSize() : int
    {
        return $this->size;
    }
}
