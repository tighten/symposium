<?php

Response::macro('jsonApi', function ($value) {
    $response = Response::json($value);
    $response->headers->set('Content-Type', 'application/vnd.api+json');

    return $response;
});
