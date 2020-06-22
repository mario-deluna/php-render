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
}
