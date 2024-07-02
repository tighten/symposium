<?php

namespace Tests\Api;

class MeApiTest extends ApiTestCase
{
    /** @test */
    public function can_fetch_my_info(): void
    {
        $response = $this->call('GET', 'api/me');
        $data = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($data->data);
    }
}
