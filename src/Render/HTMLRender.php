<?php 

namespace PHPR\Render;

use PHPR\Canvas;

/**
 * Because fun!!
 * The single stupidest way to render something 
 */
class HTMLRender
{
    public function render(Canvas $canvas) : string
    {
        $chunks = array_chunk($canvas->bitmap, $canvas->height);

        $buffer = 
        '<style>'.
            '#idiot-render { width: '.($canvas->width * 5).'px; border: 1px solid #dbdbdb; }'.
            '#idiot-render .row { height: 5px; }'.
            '#idiot-render .row div { height: 5px; width: 5px; float: left; }'.
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
