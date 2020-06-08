<?php 

namespace PHPR\Tests\Buffer;

use PHPR\Buffer\BufferInt;

class BufferIntTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(BufferInt::class, new BufferInt(10));
    }

    public function testRaw()
    {
        $buffer = new BufferInt(3);
        $this->assertEquals([0, 0, 0], $buffer->raw());
    }

    public function testRawRef()
    {
        $buffer = new BufferInt(3);
        $raw = &$buffer->raw();
        $raw[1] = 1;
        $this->assertEquals([0, 1, 0], $buffer->rawCopy());
    }

    public function testClear()
    {
        $buffer = new BufferInt(3);
        $buffer->clear(0x004200);
        $this->assertEquals([0x004200, 0x004200, 0x004200], $buffer->raw());
    }
}
