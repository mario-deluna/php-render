<?php 

namespace PHPR\Render;

use PHPR\Context;

class FFMPEGStream
{
    /**
     * TGA renderer instance
     *
     * @var TGARenderer
     */
    private $tgaRenderer;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tgaRenderer = new TGARenderer;
    }

    public function stream(callable $callback)
    {
        $descriptors = array(
            0 => array("pipe", "r")
        );

        $command = "ffmpeg -f image2pipe -pix_fmt rgb24 -r 30 -c:v targa -video_size 800x600 -frame_size 1440018 -i - -r 30 -vcodec libx264 -pix_fmt yuv420p -y test.mp4";

        $ffmpeg = proc_open($command, $descriptors, $pipes);

        if (is_resource($ffmpeg))
        {
            while($context = $callback()) {
                fwrite($pipes[0], $this->tgaRenderer->render($context));
            }

            fclose($pipes[0]);
        }
    }
    
}
