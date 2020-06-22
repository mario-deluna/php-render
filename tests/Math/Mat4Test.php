<?php 

namespace PHPR\Tests\Math;

use PHPR\Math\Mat4;

class Mat4Test extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(Mat4::class, new Mat4);
    }

    public function testPrint()
    {
        $m = new Mat4;
        $this->assertEquals(
"Mat4:
(
    [1.00, 0.00, 0.00, 0.00]
    [0.00, 1.00, 0.00, 0.00]
    [0.00, 0.00, 1.00, 0.00]
    [0.00, 0.00, 0.00, 1.00]
)", (string) $m);
    }

    public function testDefault()
    {
        $m = new Mat4;
        $this->assertEquals(
        [
            1.0, 0.0, 0.0, 0.0,
            0.0, 1.0, 0.0, 0.0,
            0.0, 0.0, 1.0, 0.0,
            0.0, 0.0, 0.0, 1.0,
        ], $m->raw());
    }

    public function testMultiply()
    {
        $m = new Mat4;
        $this->assertEquals(
        [
            2.0, 0.0, 0.0, 0.0,
            0.0, 2.0, 0.0, 0.0,
            0.0, 0.0, 2.0, 0.0,
            0.0, 0.0, 0.0, 2.0,
        ], $m->multiplyScalar(2)->raw());
    }
}
