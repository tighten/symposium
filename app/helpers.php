<?php

if (! function_exists('markdown')) {
    function markdown($text)
    {
        return '<div class="markdown">' . (new Parsedown())->text($text) . '</div>';
    }
}

if (! function_exists('linkify')) {
    function linkify($text)
    {
        if (! $text) {
            return '';
        }

        $pattern = '@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s\)\<])?)?)@';

        return preg_replace($pattern, '<a href="$0" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-indigo-500">$0</a>', $text);
    }
}
