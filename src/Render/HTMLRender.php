<?php 

namespace PHPR\Render;

use PHPR\Context;

/**
 * Because fun!!
 * The single stupidest way to render something 
 */
class HTMLRender
{
    public $pixelSize = 10;

    public function render(Context $canvas) : string
    {
        $buffer = $canvas->getOutputBuffer();

        $chunks = array_chunk($buffer->raw(), $canvas->getWidth());

        $buffer = 
        '<style>'.
            '#idiot-render { width: '.($canvas->getWidth() * $this->pixelSize).'px; border: 1px solid #dbdbdb; }'.
            '#idiot-render .row { height: '.$this->pixelSize.'px; }'.
            '#idiot-render .row div { height: '.$this->pixelSize.'px; width: '.$this->pixelSize.'px; float: left; }'.
        '</style>';

        $i = 0;

        $buffer .= "<div id='idiot-render'>";
        foreach($chunks as $y => &$chunk) 
        {
            $buffer .= '<div class="row">';
            foreach($chunk as $x => &$color) 
            {
                $buffer .= '<div style="background-color: #'.substr('000000' . dechex($color), -6).'"></div>';
                $i++;
            }
            $buffer .= '</div>';
        }
        $buffer .= "</div>";

        return $buffer;
    }
}
