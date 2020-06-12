<?php

HTML::macro('activeLinkRoute', function ($keysWithDefaults, $route, $title = null, $parameters = [], $attributes = [], $activeClass = 'is-active') {

    // This only works if we pass a single param.
    $key = key($parameters);
    if (request($key) === $parameters[$key] ||
        ! request()->has($key) && $parameters[$key] === $keysWithDefaults[$key]) {
        $cssClass = isset($attributes['class']) ? $attributes['class'] : '';
        $cssClass .= " {$activeClass}";
        $attributes['class'] = $cssClass;
    }

    // There has to be a better way...
    $outputParameters = [];
    foreach ($keysWithDefaults as $key => $default) {
        if (array_key_exists($key, $parameters)) {
            $outputParameters[$key] = $parameters[$key];
        } elseif (request()->has($key)) {
            $outputParameters[$key] = request($key);
        } else {
            $outputParameters[$key] = $keysWithDefaults[$key];
        }
    }

    return HTML::linkRoute($route, $title, $outputParameters, $attributes);
});

Response::macro('jsonApi', function ($value) {
    $response = Response::json($value);
    $response->headers->set('Content-Type', 'application/vnd.api+json');

    return $response;
});

Validator::extend('onOrAfter', 'App\Validators\OnOrAfterValidator@validate');
Validator::replacer('onOrAfter', 'App\Validators\OnOrAfterValidator@message');
