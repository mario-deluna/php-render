<?php 

namespace PHPR\Tests\Math;

use PHPR\Math\{Mat4, Vec4, Vec3};

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

    private function createTestMatrix() : Mat4
    {
        return new Mat4([
            1,  2,  3,  4, 
            5,  6,  7,  8, 
            9,  10, 11, 12, 
            13, 14, 15, 16
        ]);
    }

    public function testMultiplyScalar()
    {
        $m = $this->createTestMatrix();
        $this->assertEquals(
        [
            2,  4,  6,  8, 
            10, 12, 14, 16, 
            18, 20, 22, 24, 
            26, 28, 30, 32
        ], $m->multiplyScalar(2)->raw());
    }

    public function testMultiplyVec4()
    {
        $m = $this->createTestMatrix();
        $this->assertEquals([190, 220, 250, 280], $m->multiplyVec4(new Vec4(9, 8, 7, 6))->raw());
    }

    public function testMultiply()
    {
        $m1 = $this->createTestMatrix();
        $m2 = $this->createTestMatrix();
        $this->assertEquals(
        [
            90, 100, 110, 120,
            202, 228, 254, 280,
            314, 356, 398, 440,
            426, 484, 542, 600
        ], $m1->multiply($m2)->raw());
    }

    public function testTranslate()
    {
        $m = $this->createTestMatrix();
        $this->assertEquals(
        [
            1, 2, 3, 4,
            5, 6, 7, 8,
            9, 10, 11, 12,
            125, 150, 175, 200
        ], $m->translate(new Vec3(9, 8, 7))->raw());
    }

    public function testOrtho()
    {
        $m = Mat4::ortho(0, 800, 400, 0, 0.1, 100);

        $this->assertEquals(
        [
            0.0025, 0.0, 0.0, 0.0,
            0.0, -0.005, .00, 0.0,
            0.0, 0.0, -0.02, 0.0,
            -1.0, 1.0, -1.002, 1.0
        ], array_map(function($v) {return round($v, 4);}, $m->raw()));
    }

    public function testPerspective()
    {
        $m = Mat4::perspective(0.8, 800 / 600, 0.1, 100);

        $this->assertEquals(
        [
            1.7739, 0, 0, 0,
            0, 2.3652, 0, 0,
            0, 0, -1.002, -1,
            0, 0, -0.2002, 0
        ], array_map(function($v) {return round($v, 4);}, $m->raw()));
    }
}
