<?php

namespace Tests\Api;

use PHPUnit\Framework\Attributes\Test;

final class JsonApiTest extends ApiTestCase
{
    #[Test]
    public function uses_correct_json_api_header(): void
    {
        $response = $this->call('GET', '/api/user/1/talks');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/vnd.api+json', $response->headers->get('Content-Type'));
    }
}
