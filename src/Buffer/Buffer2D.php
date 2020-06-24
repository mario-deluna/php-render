<?php 

namespace PHPR\Buffer;

use PHPR\Buffer;
use PHPR\Rasterizer;

class Buffer2D
{
    const TYPE_INT = 0;
    const TYPE_DOUBLE = 1;

    private int $type;
    private int $width;
    private int $height;

    /**
     * Buffer instnace
     */
    private Buffer $buffer;

    /**
     * Raw buffer reference
     */
    private $bufferRef;
    
    /**
     * Constructor
     */
    public function __construct(int $type, int $width, int $height)
    {
        $this->type = $type;
        $this->width = $width;
        $this->height = $height;

        $this->rebuild();
    }

    public function getWidth() : int
    {
        return $this->width;
    }

    public function getHeight() : int
    {
        return $this->height;
    }

    /**
     * Return the buffer object
     *
     * @return Buffer
     */
    public function getBufferObject() : Buffer
    {
        return $this->buffer;
    }

    /**
     * Replace the current buffer object
     *
     * @param Buffer            $buffer
     */
    public function replaceBufferObject(Buffer $buffer)
    {
        $this->buffer = $buffer;
        $this->bufferRef = &$this->buffer->raw();
    }

    /**
     * Raw buffer reference
     */
    public function &raw() : array
    {
        return $this->bufferRef;
    }

    /**
     * Rebuild the current buffer
     */
    public function rebuild()
    {
        $bufferSize = $this->width * $this->height;

        switch ($this->type) {
            case Buffer2D::TYPE_INT:
                $this->buffer = new BufferInt($bufferSize);
            break;

            case Buffer2D::TYPE_DOUBLE:
                $this->buffer = new BufferDouble($bufferSize);
            break;
            
            default:
                throw new \Exception("Invalid buffer type!");
            break;
        }

        // assign buffer reference
        $this->bufferRef = &$this->buffer->raw();
    }

    /**
     * Get buffer value at index
     *
     * @param int           $index
     */
    public function getAtIndex(int $index)
    {
        return $this->bufferRef[$index];
    }

    /**
     * Get buffer value at 2d position
     *
     * @param int           $x
     * @param int           $y
     */
    public function getAtPos(int $x, int $y)
    {
        return $this->bufferRef[($y * $this->width) + $x];
    }

    /**
     * Sets a value on the buffer
     *
     * @param int               $index
     * @param int|dobule        $value
     */
    public function setAtIndex(int $index, $value)
    {
        return $this->bufferRef[$index] = $value;
    }

    /**
     * Sets a value on the buffer
     *
     * @param int               $x
     * @param int               $y
     * @param int|dobule        $value
     */
    public function setAtPos(int $x, int $y, $value)
    {
        return $this->bufferRef[($y * $this->width) + $x] = $value;
    }
}
