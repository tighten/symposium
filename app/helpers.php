<?php

if (! function_exists('markdown')) {
    function markdown($text)
    {
        return '<div class="markdown">' . (new Parsedown())->text($text) . '</div>';
    }
}

if (! function_exists('append_url')) {
    function append_url($url, $params = null)
    {
        $char = Str::contains($url, '?') ? '&' : '?';

        if (! is_array($params)) {
            return false;
        }

        return $url . $char . http_build_query($params);
    }
}
