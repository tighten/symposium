<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class MeApiTest extends ApiTestCase
{
    use WithoutMiddleware;

    public function testFetchesMyInfo()
    {
        $response = $this->call('GET', 'api/me');
        $data = $this->parseJson($response);

        $this->assertIsJson($data);
        $this->assertInternalType('object', $data->data);
    }
}
