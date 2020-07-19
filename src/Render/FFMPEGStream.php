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
     * Context instance
     *
     * @var Context
     */
    private $context;

    /**
     * Pipe and resource
     *
     * @var null
     */
    private $pipe = null;
    private $resource = null;

    /**
     * Framerate of the video 
     *
     * @var int 
     */
    public int $fps = 30;

    /**
     * Constructor
     *
     * @param Context           $context
     */
    public function __construct(Context $context)
    {
        $this->tgaRenderer = new TGARenderer;
        $this->context = $context;
    }

    /**
     * Returns the context frame size
     */
    public function getFrameSize() : int
    {
        // (width * height * channels) + tagraheader
        return ($this->context->getWidth() * $this->context->getHeight() * 3) + 18;
    } 

    /**
     * Start a ffmpeg pipe
     *
     * @param string            $path
     */
    public function start(string $path)
    {
        if (!is_null($this->pipe)) throw new \Exception("FFMPG Pipe is already open.");

        $this->resource = proc_open(
            "ffmpeg -f image2pipe -pix_fmt rgb24 -r ". $this->fps ." -c:v targa -video_size " .
            $this->context->getWidth() . 'x' . $this->context->getHeight() .
            " -frame_size ". $this->getFrameSize() ." -i - -r ". $this->fps ." -vcodec libx264 -pix_fmt yuv420p -y ".
            $path
        , [['pipe', 'r']], $pipes);

        if (!is_resource($this->resource)) throw new \Exception("Could not open ffmpeg pipe.");

        $this->pipe = $pipes[0];
    }

    /**
     * Render a frame of the current context
     *
     * @return void
     */
    public function render() 
    {   
        if (is_null($this->pipe)) throw new \Exception("FFMPG Cannot Stream, No active ffmpeg pipe.");

        fwrite($this->pipe, $this->tgaRenderer->render($this->context));
    }

    /**
     * Stop the rendering and write the file
     *
     * @return void
     */
    public function stop()
    {
        if (is_null($this->pipe)) throw new \Exception("FFMPG Cannot Stop, No active ffmpeg pipe.");

        fclose($this->pipe);
        proc_close($this->resource);
    }
}
