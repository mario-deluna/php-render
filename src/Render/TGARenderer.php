<?php 

namespace PHPR\Render;

use PHPR\Context;

/**
 * I dont know a simple image format then TGA so is use tga.
 * Also i've to admit I don't really know how to handle byte arrays with PHP so 
 * I do the stupid thing and convert a hex string to it.
 */
class TGARenderer
{
    public function renderToFile(Context $context, string $path) 
    {
        file_put_contents($path, $this->render($context));
    }

    public function render(Context $context) : string 
    {
        $buffer = $context->getOutputBuffer();

        $data = $buffer->raw();

        $width = $context->getWidth();
        $height = $context->getHeight();

        // TGA Header
        $body = hex2bin('000002000000000000000000');

        // width
        $body .= chr($width >>  0 & 0xFF);
        $body .= chr($width >>  8 & 0xFF);

        // height
        $body .= chr($height >>  0 & 0xFF);
        $body .= chr($height >>  8 & 0xFF);

        $body .= hex2bin('1820');

        foreach($data as $i) 
        {
            $body .= chr($i & 0xFF);
            $body .= chr(($i >> 8) & 0xFF);
            $body .= chr(($i >> 16) & 0xFF);
        }

        return $body;
    }
}
