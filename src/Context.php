<?php 

namespace PHPR;

use PHPR\Shader\Shader;

use PHPR\Mesh\Vertex;
use PHPR\Mesh\VertexArray;
use PHPR\Buffer\Buffer2D;

use PHPR\Math\{Vec4, Vec3, Vec2};

class Context
{
    /**
     * Rasterizer instance 
     */
    private Rasterizer $rasterizer;

    /**
     * Current shader program
     */
    private Shader $shader;

    /**
     * Depth Buffer
     */
    private Buffer2D $depthBuffer;

    /**
     * Depth testing?
     *
     * @var bool
     */
    private bool $depthTest = false;

    /**
     * Backface culling?
     *
     * @var bool
     */
    private bool $backfaceCulling = true;

    /** 
     * Current context draw mode 
     */
    const DRAW_MODE_NORMAL = 0;
    const DRAW_MODE_LINES = 1;
    private int $drawMode = 0;

    /**
     * An array of attached buffers
     */
    private array $buffers = [];

    /**
     * Output buffer key
     */
    private ?string $outputBufferKey = null;

    /**
     * Callback to be executed after each triangle
     */
    public $triangleDrawnCallback = null;

    /**
     * Context Resolution
     */
    private int $width;
    private int $height;

    /**
     * Constructor
     */
    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;

        // create rasterizer
        $this->rasterizer = new Rasterizer($width, $height);

        // create depth buffer
        $this->depthBuffer = new Buffer2D(Buffer2D::TYPE_DOUBLE, $width, $height);
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
     * Set the context draw mode
     *
     * @param int           $drawMode
     */
    public function setDrawMode(int $drawMode)
    {
        $this->drawMode = $drawMode;
    }

    /**
     * Enabled depth testing in the context
     *
     * @return void
     */
    public function enableDepthTesting()
    {
        $this->depthTest = true;
    }

    /**
     * Disable depth testing in the context
     *
     * @return void
     */
    public function disableDepthTesting()
    {
        $this->depthTest = false;
    }

    /**
     * Enabled backface culling in the context
     *
     * @return void
     */
    public function enableBackfaceCulling()
    {
        $this->backfaceCulling = true;
    }

    /**
     * Disable backface culling in the context
     *
     * @return void
     */
    public function disableBackfaceCulling()
    {
        $this->backfaceCulling = false;
    }

    /**
     * Bind a shader to the context
     *
     * @param Shader            $shader
     */
    public function bindShader(Shader $shader)
    {
        $this->shader = $shader;
    }

    /**
     * Set the output buffer key
     *
     * @param string                $key
     */
    public function setOutputBuffer(string $key)
    {
        $this->outputBufferKey = $key;
    }

    /**
     * Get the current output buffer
     *
     * @param string                $key
     */
    public function getOutputBuffer() : Buffer2D
    {
        if (!$this->outputBufferKey) throw new \Exception("No output buffer has been set.");
        return $this->getBuffer($this->outputBufferKey);
    }

    /**
     * Get a attached buffer
     *
     * @param string                $key
     */
    public function getBuffer(string $key) : Buffer2D
    {
        if (!isset($this->buffers[$key])) throw new \Exception("There is no buffer named '$key' attached.");
        return $this->buffers[$key];
    }

    /**
     * Attach a buffer to the context
     *
     * @param int               $type
     * @param string            $key
     */
    public function attachBuffer(int $type, string $key)
    {
        if (isset($this->buffers[$key])) {
            throw new \Exception("Buffer with the key '{$key}' is already attached.");
        }

        $this->buffers[$key] = new Buffer2D($type, $this->width, $this->height);
    }

    /**
     * Returns the contexts depth buffer
     *
     * @return Buffer2D
     */
    public function getDepthBuffer() : Buffer2D
    {
        return $this->depthBuffer;
    }

    /**
     * Set the current active shader
     *
     * @param Shader            $program 
     */
    public function setShader(Shader $program)
    {
        $this->shader = $program;
    }

    /**
     * Returns the sum of weighted values
     *
     * @return int / float
     */
    private function intrpWeights($vx, $vy, $vz, $wx, $wy, $wz)
    {
        $vx *= $wx;
        $vy *= $wy;
        $vz *= $wz;

        return $vx + $vy + $vz;
    }

    /**
     * Draw a single line
     *
     * @param Vertex                $v1
     * @param Vertex                $v2
     */
    public function drawLine(Vertex $v1, Vertex $v2)
    {
        // prepare vertex out
        $vOut1 = [];
        $vOut2 = [];

        // generate vertex shader output 
        $p1 = $this->shader->vertex($v1, $vOut1);
        $p2 = $this->shader->vertex($v2, $vOut2);

        $p1->x /= $p1->w;
        $p1->y /= $p1->w;
        $p1->z /= $p1->w;
        $p2->x /= $p2->w;
        $p2->y /= $p2->w;
        $p2->z /= $p2->w;

        // convert screen space to pixel coords
        $x1 = (int) round((($p1->x + 1) / 2) * $this->width);
        $x2 = (int) round((($p2->x + 1) / 2) * $this->width);
        $y1 = (int) round((($p1->y + 1) / 2) * $this->height);
        $y2 = (int) round((($p2->y + 1) / 2) * $this->height);

        $pixels = [];

        // rasterize
        $this->rasterizer->rasterLine(
            $x1, $y1, 
            $x2, $y2, 
            $pixels
        );
    }

    /**
     * Draw a single triangle on the current buffer
     *
     * @param Vertex                $v1
     * @param Vertex                $v2
     * @param Vertex                $v3
     * @param int                   $index
     */
    public function drawTriangle(Vertex $v1, Vertex $v2, Vertex $v3, int $index = 0)
    {
        // prepare vertex out
        $vOut1 = [];
        $vOut2 = [];
        $vOut3 = [];

        // generate vertex shader output 
        $p1 = $this->shader->vertex($v1, $vOut1);
        $p2 = $this->shader->vertex($v2, $vOut2);
        $p3 = $this->shader->vertex($v3, $vOut3);

        // $p1->normalize();
        // $p2->normalize();
        // $p3->normalize();

        // $p1->x /= $p1->w;
        // $p1->y /= $p1->w;
        // $p1->z /= $p1->w;
        // $p2->x /= $p2->w;
        // $p2->y /= $p2->w;
        // $p2->z /= $p2->w;
        // $p3->x /= $p3->w;
        // $p3->y /= $p3->w;
        // $p3->z /= $p3->w;


        // _d($p1->z, $p2->z, $p3->z);

        if ($p1->w != 0) 
        {
            $p1->x /= $p1->w;
            $p1->y /= $p1->w;
            $p1->z /= $p1->w;
        }
        if ($p2->w != 0) 
        {
            $p2->x /= $p2->w;
            $p2->y /= $p2->w;
            $p2->z /= $p2->w;
        }
        if ($p3->w != 0) 
        {
            $p3->x /= $p3->w;
            $p3->y /= $p3->w;
            $p3->z /= $p3->w;
        }

        // backface culling with shoelace algo
        if ($this->backfaceCulling)
        {
            $area = ($p1->x * $p2->y) + ($p2->x * $p3->y) + ($p3->x * $p1->y) - ($p2->x * $p1->y) - ($p3->x * $p2->y) - ($p1->x * $p3->y);
            if ($area < 0) return;
        }
        

        // $area = 1 / $area;
        
        
        // convert screen space to pixel coords
        $x1 = (int) round((($p1->x + 1) / 2) * $this->width);
        $x2 = (int) round((($p2->x + 1) / 2) * $this->width);
        $x3 = (int) round((($p3->x + 1) / 2) * $this->width);
        $y1 = (int) round((($p1->y + 1) / 2) * $this->height);
        $y2 = (int) round((($p2->y + 1) / 2) * $this->height);
        $y3 = (int) round((($p3->y + 1) / 2) * $this->height);

        $pixels = [];

        // rasterize the triangle
        if ($this->drawMode === static::DRAW_MODE_NORMAL)
        {
            $this->rasterizer->rasterTriangle(
                $x1, $y1, 
                $x2, $y2, 
                $x3, $y3, 
                $pixels
            );
        }
        elseif ($this->drawMode === static::DRAW_MODE_LINES)
        {
            $this->rasterizer->rasterTriangleLine(
                $x1, $y1, 
                $x2, $y2, 
                $x3, $y3, 
                $pixels
            );
        }
        else 
        {
            throw new \Exception("Invalid drawing mode: " . $this->drawMode);
        }

        // calculate vertex weights
        $vw = $this->rasterizer->getVertexContributionForPixels(
            $x1, $y1, 
            $x2, $y2, 
            $x3, $y3, 
            $pixels
        );

        $fragOut = [];
        $fragIn = [];

        // _d('T---------------');

        for($i = 0; $i < count($pixels); $i+=2) 
        {
            $x = $pixels[$i+0];
            $y = $pixels[$i+1];

            $vp = floor($i / 2) * 3;
            $w1 = $vw[$vp+0];
            $w2 = $vw[$vp+1];
            $w3 = $vw[$vp+2];

            $ws = $w1 + $w2 + $w3;

            // _d($w1 . ':' . $w2 . ':' . $w3);

            // if (($w1 | $w2 | $w3) <= 0) continue;
            if ($ws > (1.0 + PHP_FLOAT_EPSILON)) continue;
            if (($w1 + PHP_FLOAT_EPSILON) < 0 || ($w2 + PHP_FLOAT_EPSILON) < 0 || ($w3 + PHP_FLOAT_EPSILON) < 0) continue;

            if ($this->depthTest)
            {
                // get the pixels z value
                $z = ($p1->z * $w1) + ($p2->z * $w2) + ($p3->z * $w3);


                // $z = $this->intrpWeights($p1->z, $p2->z, $p3->z, $w1, $w2, $w3);
                // $z = $this->intrpWeights($p1->z, $p2->z, $p3->z, $w1, $w2, $w3);
                // $z = round($z, 4, PHP_ROUND_HALF_DOWN);
                //$z += ($p1->z + $p2->z + $p3->z) / 3;
                $cz = $this->depthBuffer->getAtPos($x, $y);

                // if ($w1 <= 0.0 || $w2 <= 0.0 || $w3 <= 0.0) continue;
                // echo 0;
                // _d($z, $p1->z, $p2->z, $p3->z, $w1, $w2, $w3);

                if ($z < 0) continue;

                // discard fragments behind already drawn ones
                if (abs($cz) < PHP_FLOAT_EPSILON || ($z < ($cz - PHP_FLOAT_EPSILON * 3))) {
                    $this->depthBuffer->setAtPos($x, $y, $z);
                } else {
                //var_dump($p1->z, $p2->z, $p3->z, $w1, $w2, $w3, $z, $cz);// die;
                    continue;
                }
            } 

            foreach($vOut1 as $k => $vValue1)
            {
                $vValue2 = $vOut2[$k];
                $vValue3 = $vOut3[$k];

                if ($vValue1 instanceof Vec3) {
                    $fragIn[$k] = new Vec3(
                        $this->intrpWeights($vValue1->x, $vValue2->x, $vValue3->x, $w1, $w2, $w3),
                        $this->intrpWeights($vValue1->y, $vValue2->y, $vValue3->y, $w1, $w2, $w3),
                        $this->intrpWeights($vValue1->z, $vValue2->z, $vValue3->z, $w1, $w2, $w3),
                    );
                }
                elseif ($vValue1 instanceof Vec2) {
                    $fragIn[$k] = new Vec2(
                        $this->intrpWeights($vValue1->x, $vValue2->x, $vValue3->x, $w1, $w2, $w3),
                        $this->intrpWeights($vValue1->y, $vValue2->y, $vValue3->y, $w1, $w2, $w3),
                    );
                }
                else 
                {
                    throw new \Exception("Invalid vertex output for key '$k' cannot be interpolarted.");
                }
            }

            // let the fragment shader do its thing
            $this->shader->fragment($fragIn, $fragOut);

            // assign outputs to buffers
            foreach($fragOut as $k => $value)
            {
                // _d($value. ' --- '.$z);
                $this->buffers[$k]->setAtPos($x, $y, $value);
            }
        }

        // exec callback
        if ($this->triangleDrawnCallback) {
            $call = $this->triangleDrawnCallback; $call();
        }
    }

    /**
     * Draw a vertex array
     *
     * @param VertexArray           $va 
     */
    public function drawVertexArray(VertexArray $va)
    {
        $triangles = array_chunk($va->getVertices(), 3);

        foreach($triangles as $i => &$triangle) {
            $this->drawTriangle($triangle[0], $triangle[1], $triangle[2], $i);
        }
    }

    /**
     * Clear the buffers of the current context
     */
    public function clear()
    {
        $this->depthBuffer->getBufferObject()->clear();

        foreach($this->buffers as $buffer) {
            $buffer->getBufferObject()->clear();
        }
    }
}
