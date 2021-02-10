<?php 

namespace PHPR\Sampler;

use PHPR\Math\Vec3;

class ImageSamplerGD
{
    private $resource;
    private $width;
    private $height;

    /**
     * Construct a new GD image smaple
     */
    public function __construct(string $path)
    {
        if (!file_exists($path)) throw new \Exception("The file '{$path}' does not exist.");

        $this->resource = imagecreatefrompng($path);
        $this->width = imagesx($this->resource);
        $this->height = imagesy($this->resource);
    }

    public function sample(float $x, float $y) : int
    {
        return imagecolorat(
            $this->resource, 
            min(max($this->width * $x, 0), $this->width - 1), 
            min(max($this->height * $y, 0), $this->height - 1)
        );
    }

    public function sampleVec3(float $x, float $y) : Vec3
    {  
        $sample = $this->sample($x, $y);

        return new Vec3(
            (($sample >> 16) & 0xFF) / 0xFF, 
            (($sample >> 8) & 0xFF) / 0xFF, 
            ($sample & 0xFF) / 0xFF
        );
    }
}
