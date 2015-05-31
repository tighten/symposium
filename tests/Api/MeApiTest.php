<?php

class MeApiTest extends ApiTestCase
{
    public function testFetchesMyInfo()
    {
        $response = $this->call('GET', 'api/me');
        $data = $this->parseJson($response);

        $this->assertIsJson($data);
        $this->assertInternalType('object', $data->data);
    }
}
