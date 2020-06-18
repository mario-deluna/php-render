<?php 

namespace PHPR;

use PHPR\Shader\Shader;

use PHPR\Mesh\Vertex;
use PHPR\Buffer\Buffer2D;

use PHPR\Math\Vec3;

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
     * An array of attached buffers
     */
    private array $buffers = [];

    /**
     * Output buffer key
     */
    private ?string $outputBufferKey = null;

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
     * Draw a single triangle on the current buffer
     *
     * @param Vertex                $v1
     * @param Vertex                $v2
     * @param Vertex                $v3
     */
    public function drawTriangle(Vertex $v1, Vertex $v2, Vertex $v3)
    {
        // convert screen space to pixel coords
        $x1 = (int) ((($v1->position->x + 1) / 2) * $this->width);
        $x2 = (int) ((($v2->position->x + 1) / 2) * $this->width);
        $x3 = (int) ((($v3->position->x + 1) / 2) * $this->width);
        $y1 = (int) ((($v1->position->y + 1) / 2) * $this->height);
        $y2 = (int) ((($v2->position->y + 1) / 2) * $this->height);
        $y3 = (int) ((($v3->position->y + 1) / 2) * $this->height);

        $pixels = [];

        // prepare vertex out
        $vOut1 = [];
        $vOut2 = [];
        $vOut3 = [];

        // generate vertex shader output 
        $this->shader->vertex($v1, $vOut1);
        $this->shader->vertex($v2, $vOut2);
        $this->shader->vertex($v3, $vOut3);

        // rasterize the triangle
        $this->rasterizer->rasterTriangle(
            $x1, $y1, 
            $x2, $y2, 
            $x3, $y3, 
            $pixels
        );

        // calculate vertex weights
        $vw = $this->rasterizer->getVertexContributionForPixels(
            $x1, $y1, 
            $x2, $y2, 
            $x3, $y3, 
            $pixels
        );

        $fragOut = [];
        $fragIn = [];

        for($i = 0; $i < count($pixels); $i+=2) 
        {
            $x = $pixels[$i+0];
            $y = $pixels[$i+1];

            $vp = floor($i / 2) * 3;
            $w1 = $vw[$vp+0];
            $w2 = $vw[$vp+1];
            $w3 = $vw[$vp+2];

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
                $this->buffers[$k]->setAtPos($x, $y, $value);
            }
        }
    }

    /**
     * Draw single triangle
     */
    public function drawVertexArray()
    {

    }
}
