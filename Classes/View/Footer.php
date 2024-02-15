<?php

declare(strict_types=1);

namespace View;
use View\RenderInterface;

Class Footer implements RenderInterface{

    public function render(){
        $res = "<footer>";
        $res .= "<div><p id='music-name'>a</p></div>";
        $res .= "<div id='lector-div'>";
        $res .= "<input type='range' id='lector' min ='0' value='0' step='1' width='10'>";
        $res .= "<span id='progress-time'>0:00</span> / <span id='total-time'>1:00</span>";
        $res .= "<input type='range' id='sound-bar' min='0' max='100' step='1'>";
        $res .= "<span id='sound-volume'>50%</span>";
        $res .= "</div>";
        $res .= "<div id='play-div'>";
        $res .= "<audio src='../musique/65cdeb15e58d6To Be Young (Is to Be Sad, Is to Be High)(1).mp3'></audio>";
        $res .= "<svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='currentColor' id='play-button' viewBox='0 0 16 16'>";
        $res .= "<path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16'/>";
        $res .= "<path d='M6.271 5.055a.5.5 0 0 1 .52.038l3.5 2.5a.5.5 0 0 1 0 .814l-3.5 2.5A.5.5 0 0 1 6 10.5v-5a.5.5 0 0 1 .271-.445'/>";
        $res .= "</svg>";
        $res .= "<svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='currentColor' id='pause-button' viewBox='0 0 16 16'>";
        $res .= "<path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16'/>";
        $res .= "<path d='M5 6.25a1.25 1.25 0 1 1 2.5 0v3.5a1.25 1.25 0 1 1-2.5 0zm3.5 0a1.25 1.25 0 1 1 2.5 0v3.5a1.25 1.25 0 1 1-2.5 0z'/>";
        $res .= "</svg>";
        $res .= "</div>";
        $res .= "</footer>";
        return $res;
    }

}