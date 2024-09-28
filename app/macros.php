<?php

use Illuminate\Routing\UrlGenerator;

UrlGenerator::macro('menuRoute', function ($name, $parameters, $absolute = true) {
    $linkParams = $parameters['link'];
    $queryParams = $parameters['query'];
    $defaults = $parameters['defaults'];

    $outputParameters = collect($defaults)->map(fn ($default, $key) => array_merge(
        $defaults,
        $queryParams,
        $linkParams,
    )[$key])->toArray();

    return $this->route($name, $outputParameters, $absolute);
});

Response::macro('jsonApi', function ($value) {
    $response = Response::json($value);
    $response->headers->set('Content-Type', 'application/vnd.api+json');

    return $response;
});
