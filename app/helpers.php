<?php

if (! function_exists('markdown')) {
    function markdown($text)
    {
        return '<div class="prose">' . (new Parsedown)->text($text) . '</div>';
    }
}
