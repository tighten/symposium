<?php

if (! function_exists('markdown')) {
    function markdown($text)
    {
        return '<div class="markdown">'.(new Parsedown)->text($text).'</div>';
    }
}
