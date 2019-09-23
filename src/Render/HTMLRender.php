<?php 

namespace PHPR\Render;

use PHPR\Canvas;

/**
 * Because fun!!
 * The single stupidest way to render something 
 */
class HTMLRender
{
    public $pixelSize = 10;

    public function render(Canvas $canvas) : string
    {
        $chunks = array_chunk($canvas->buffer, $canvas->height);

        $buffer = 
        '<style>'.
            '#idiot-render { width: '.($canvas->width * $this->pixelSize).'px; border: 1px solid #dbdbdb; }'.
            '#idiot-render .row { height: '.$this->pixelSize.'px; }'.
            '#idiot-render .row div { height: '.$this->pixelSize.'px; width: '.$this->pixelSize.'px; float: left; }'.
        '</style>';

        $buffer .= "<div id='idiot-render'>";
        foreach($chunks as &$chunk) 
        {
            $buffer .= '<div class="row">';
            foreach($chunk as &$color) 
            {
                $buffer .= '<div style="background-color: #'.substr('000000' . dechex($color), -6).'"></div>';
            }
            $buffer .= '</div>';
        }
        $buffer .= "</div>";

        return $buffer;
    }
}
