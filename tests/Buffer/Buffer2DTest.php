<?php 

namespace PHPR\Tests\Buffer;

use PHPR\Buffer\Buffer2D;

class Buffer2DTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(Buffer2D::class, new Buffer2D(Buffer2D::TYPE_INT, 10, 10));
    }

    public function testBufferSize()
    {
        $buffer = new Buffer2D(Buffer2D::TYPE_INT, 5, 5);   
        $this->assertEquals(25, $buffer->getBufferObject()->getSize());
    }

    public function testBufferType()
    {
        $buffer = new Buffer2D(Buffer2D::TYPE_INT, 5, 5);   
        $this->assertIsInt($buffer->getBufferObject()->raw()[0]);

        $buffer = new Buffer2D(Buffer2D::TYPE_DOUBLE, 5, 5);   
        $this->assertIsFloat($buffer->getBufferObject()->raw()[0]);
    }

    public function testGetAtIndex()
    {
        $buffer = new Buffer2D(Buffer2D::TYPE_INT, 2, 2);
        $bptr = &$buffer->raw();
        $bptr = [
            1, 2,
            3, 4,
        ];

        $this->assertEquals(1, $buffer->getAtIndex(0));
        $this->assertEquals(2, $buffer->getAtIndex(1));
        $this->assertEquals(3, $buffer->getAtIndex(2));
        $this->assertEquals(4, $buffer->getAtIndex(3));
    }

    public function testGetAtPos()
    {
        $buffer = new Buffer2D(Buffer2D::TYPE_INT, 3, 2);
        $bptr = &$buffer->raw();
        $bptr = [
            1, 2, 3,
            4, 5, 6,
        ];

        $this->assertEquals(1, $buffer->getAtPos(0, 0));
        $this->assertEquals(2, $buffer->getAtPos(1, 0));
        $this->assertEquals(3, $buffer->getAtPos(2, 0));

        $this->assertEquals(4, $buffer->getAtPos(0, 1));
        $this->assertEquals(5, $buffer->getAtPos(1, 1));
        $this->assertEquals(6, $buffer->getAtPos(2, 1));
    }

    public function testSetAtIndex()
    {
        $buffer = new Buffer2D(Buffer2D::TYPE_INT, 2, 2);
        $buffer->setAtIndex(1, 50);
        $this->assertEquals(50, $buffer->getAtIndex(1));
    }

    public function testSetAtPos()
    {
        $buffer = new Buffer2D(Buffer2D::TYPE_INT, 2, 2);
        $buffer->setAtPos(1, 1, 50);
        $this->assertEquals(50, $buffer->getAtPos(1, 1));
    }
}
