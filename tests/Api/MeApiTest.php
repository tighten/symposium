<?php

namespace Tests\Api;

use PHPUnit\Framework\Attributes\Test;

class MeApiTest extends ApiTestCase
{
    #[Test]
    public function can_fetch_my_info(): void
    {
        $response = $this->call('GET', 'api/me');
        $data = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($data->data);
    }
}
