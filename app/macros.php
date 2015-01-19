<?php

HTML::macro('activeLinkRoute', function ($route, $title = null, $parameters = [], $attributes = [], $activeClass = 'is-active') {
    $fullUrl = URL::route($route, $parameters);

    if (Request::fullUrl() === $fullUrl) {
        $cssClass = isset($attributes['class']) ? $attributes['class'] : '';
        $cssClass .= " {$activeClass}";
        $attributes['class'] = $cssClass;
    }

    return HTML::linkRoute($route, $title, $parameters, $attributes);
});
