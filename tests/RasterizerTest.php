<?php 

namespace PHPR\Tests;

use PHPR\Rasterizer;

class RasterizerTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(Rasterizer::class, new Rasterizer(10, 10));
    }

    public function testLine1()
    {
        /**
         * 1 0 0 
         * 0 2 0
         * 0 0 3
         */
        $r = new Rasterizer(3, 3);
        $r->rasterLine(0, 0, 2, 2, $pixels);

        $this->assertEquals([
            0, 0,
            1, 1,
            2, 2,
        ], $pixels);
    }

    public function testLine1Oversize()
    {
        /**
         * 1 0 0 
         * 0 2 0
         * 0 0 3
         */
        $r = new Rasterizer(3, 3);
        $r->rasterLine(0, 0, 5, 5, $pixels);

        $this->assertEquals([
            0, 0,
            1, 1,
            2, 2,
        ], $pixels);
    }

    public function testLine2()
    {
        /**
         * 0 0 1 
         * 0 0 2
         * 0 0 3
         */
        $r = new Rasterizer(3, 3);
        $r->rasterLine(2, 0, 2, 2, $pixels);

        $this->assertEquals([
            2, 0,
            2, 1,
            2, 2,
        ], $pixels);
    }

    public function testLine3()
    {
        /**
         * 0 0 3 
         * 0 0 2
         * 0 0 1
         */
        $r = new Rasterizer(3, 3);
        $r->rasterLine(2, 2, 2, 0, $pixels);

        $this->assertEquals([
            2, 2,
            2, 1,
            2, 0,
        ], $pixels);
    }

    public function testLine4()
    {
        /**
         * 0 1 0 
         * 0 0 2
         * 0 0 3
         */
        $r = new Rasterizer(3, 3);
        $r->rasterLine(1, 0, 2, 2, $pixels);

        $this->assertEquals([
            1, 0,
            2, 1,
            2, 2,
        ], $pixels);
    }

    public function testLine1ScreenSpace()
    {
        /**
         * 1 0 0 
         * 0 2 0
         * 0 0 3
         */
        $r = new Rasterizer(3, 3);
        $r->rasterLineScreenSpace(-1, -1, 1, 1, $pixels);

        $this->assertEquals([
            0, 0,
            1, 1,
            2, 2,
        ], $pixels);
    }

    public function testTriangle1()
    {
        $expected = [];
        $expectedGrid = [
            1, 1, 1, 1, 1,
            1, 1, 1, 1, 0,
            0, 1, 1, 1, 0,
            0, 1, 1, 0, 0,
            0, 0, 1, 0, 0,
        ];
        foreach($expectedGrid as $k => $v) {
            if ($v === 1) {
                $y = (int) floor($k / 5);
                $x = (int) ($k - ($y * 5));

                $expected[] = $x . ':' . $y;
            }
        }

        $r = new Rasterizer(5, 5);
        $pixels = [];
        $r->rasterTriangle(0, 0, 4, 0, 2, 4, $pixels);

        $result = [];
        for ($i=0; $i<count($pixels); $i+=2) {
            $x = $pixels[$i+0];
            $y = $pixels[$i+1];
            $result[] = $x . ':' . $y;
        }

        foreach($result as $cord) {
            $this->assertContains($cord, $expected);
        }
    }

    public function testTriangle1ScreenSpace()
    {
        $expected = [];
        $expectedGrid = [
            1, 1, 1, 1, 1,
            1, 1, 1, 1, 0,
            0, 1, 1, 1, 0,
            0, 1, 1, 0, 0,
            0, 0, 1, 0, 0,
        ];
        foreach($expectedGrid as $k => $v) {
            if ($v === 1) {
                $y = (int) floor($k / 5);
                $x = (int) ($k - ($y * 5));

                $expected[] = $x . ':' . $y;
            }
        }

        $r = new Rasterizer(5, 5);
        $pixels = [];
        $r->rasterTriangleScreenSpace(-1, -1, 1, -1, 0, 1, $pixels);

        $result = [];
        for ($i=0; $i<count($pixels); $i+=2) {
            $x = $pixels[$i+0];
            $y = $pixels[$i+1];
            $result[] = $x . ':' . $y;
        }

        foreach($result as $cord) {
            $this->assertContains($cord, $expected);
        }
    }

    public function testVertexContributionV1()
    {
        // 0, 2, 1, 1, 2,
        // 0, 1, 1, 1, 0,
        // 0, 1, 1, 1, 0,
        // 0, 2, 0, 0, 0,
        // 0, 0, 0, 0, 0,
        $r = new Rasterizer(5, 5);
        $pixels = [1, 0];
        $contrib = $r->getVertexContributionForPixels(
            1, 0, 
            4, 0, 
            1, 3,
            $pixels
        );

        $this->assertEquals([1, 0, 0], $contrib);
    }

    public function testVertexContributionV2()
    {
        // 0, 2, 1, 1, 2,
        // 0, 1, 1, 1, 0,
        // 0, 1, 1, 1, 0,
        // 0, 2, 0, 0, 0,
        // 0, 0, 0, 0, 0,
        $r = new Rasterizer(5, 5);
        $pixels = [4, 0];
        $contrib = $r->getVertexContributionForPixels(
            1, 0, 
            4, 0, 
            1, 3,
            $pixels
        );

        $this->assertEquals([0, 1, 0], $contrib);
    }

    public function testVertexContributionV3()
    {
        // 0, 2, 1, 1, 2,
        // 0, 1, 1, 1, 0,
        // 0, 1, 1, 1, 0,
        // 0, 2, 0, 0, 0,
        // 0, 0, 0, 0, 0,
        $r = new Rasterizer(5, 5);
        $pixels = [1, 3];
        $contrib = $r->getVertexContributionForPixels(
            1, 0, 
            4, 0, 
            1, 3,
            $pixels
        );

        $this->assertEquals([0, 0, 1], $contrib);
    }

    public function testVertexContributionV4()
    {
        // 0, 2, 1, 1, 2,
        // 0, 1, 1, 1, 0,
        // 0, 1, 1, 1, 0,
        // 0, 2, 0, 0, 0,
        // 0, 0, 0, 0, 0,
        $r = new Rasterizer(5, 5);
        $pixels = [2, 0];
        $contrib = $r->getVertexContributionForPixels(
            1, 0, 
            4, 0, 
            1, 3,
            $pixels
        );

        $this->assertEquals([1 - (1 / 3), (1 / 3), 0], $contrib);
    }

    public function testVertexContributionV5()
    {
        // 0, 2, 1, 1, 2,
        // 0, 1, 1, 1, 0,
        // 0, 1, 1, 1, 0,
        // 0, 2, 0, 0, 0,
        // 0, 0, 0, 0, 0,
        $r = new Rasterizer(5, 5);
        $pixels = [1, 1];
        $contrib = $r->getVertexContributionForPixels(
            1, 0, 
            4, 0, 
            1, 3,
            $pixels
        );

        $this->assertEquals([1 - (1 / 3), 0, (1 / 3)], $contrib);
    }
}
