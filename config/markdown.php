<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Escape output
    |--------------------------------------------------------------------------
    |
    | This option controls whether or not JavaScript in anchor tags should be
    | escaped or not, e.g. markdown like "[Link](javascript:alert('xss'))".
    |
    */

    'xss' => true,

    /*
    |--------------------------------------------------------------------------
    | Automatically link URLs
    |--------------------------------------------------------------------------
    |
    | This option controls the automatic anchor inserting on URLs in your
    | markdown. If this option is true, all websites in your markdown
    | will automatically be turned into anchor tags in your output.
    |
    */

    'urls' => true,

    /*
    |--------------------------------------------------------------------------
    | Escape HTML markup
    |--------------------------------------------------------------------------
    |
    | This option controls whether or not HTML entities should be escaped.
    | If this option is false, then users could be able to insert any
    | arbitrary HTML/scripts which may lead to XSS vulnerabilities.
    |
    */

    'escape_markup' => false,

    /*
    |--------------------------------------------------------------------------
    | Automatically add line breaks
    |--------------------------------------------------------------------------
    |
    | This option controls the automatic insertion of single line breaks
    | like GitHub Flavored Markdown (GFM). If this option is false,
    | users must enter two line breaks to start a new paragraph.
    |
    */

    'breaks' => true,

];
