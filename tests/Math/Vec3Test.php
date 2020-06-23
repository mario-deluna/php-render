<?php 

namespace PHPR\Tests\Math;

use PHPR\Math\Vec3;

class Vec3Test extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(Vec3::class, new Vec3(0, 0, 0));
    }

    public function testAdd()
    {
        $a = new Vec3(5, 2, 1);
        $b = new Vec3(2, 1, 1);

        $r = Vec3::_add($a, $b);

        $this->assertEquals([7, 3, 2], $r->raw());

        $r->add($b);

        $this->assertEquals([9, 4, 3], $r->raw());
    }

    public function testNormalize()
    {
        $a = new Vec3(50, 0, 0);
        $a->normalize();

        $this->assertEquals([1, 0, 0], $a->raw());
    }

    public function testSub()
    {
        $a = new Vec3(5, 2, 1);
        $b = new Vec3(2, 1, 1);

        $a->substract($b);

        $this->assertEquals([3, 1, 0], $a->raw());
    }

    public function testMul()
    {
        $a = new Vec3(5, 2, 1);

        $a->multiply(2);

        $this->assertEquals([10, 4, 2], $a->raw());
    }

    public function testDiv()
    {
        $a = new Vec3(5, 2, 1);

        $a->divide(2);

        $this->assertEquals([2.5, 1, 0.5], $a->raw());
    }

    public function testDot()
    {
        $a = new Vec3(1, 2, 3);
        $b = new Vec3(1, 5, 7);

        $this->assertEquals(32, $a->dot($b));
    }

    public function testDistance()
    {
        $a = new Vec3(0, 10, 0);
        $b = new Vec3(0, 20, 0);

        $this->assertEquals(10, $a->distance($b));
    }

    public function testCross()
    {
        $a = new Vec3(1, 2, 3);
        $b = new Vec3(1, 5, 7);

        $this->assertEquals([-1, -4, 3], $a->cross($b)->raw());
    }

    public function testChain()
    {
        $a = new Vec3(1, 2, 3);

        $a->multiply(2)->multiply(2)->divide(8);

        $this->assertEquals([0.5, 1, 1.5], $a->raw());
    }
}
