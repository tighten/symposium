<?php

namespace Tests\Api;

class JsonApiTest extends ApiTestCase
{
    /** @test */
    public function uses_correct_json_api_header(): void
    {
        $response = $this->call('GET', '/api/user/1/talks');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/vnd.api+json', $response->headers->get('Content-Type'));
    }
}
