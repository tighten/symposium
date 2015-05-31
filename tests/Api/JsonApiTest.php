<?php

class JsonApiTest extends ApiTestCase
{
    public function testUsesCorrectJsonApiHeader()
    {
        $response = $this->call('GET', '/api/user/1/talks');

        $this->assertEquals('application/vnd.api+json', $response->headers->get('content-type'));
    }
}
