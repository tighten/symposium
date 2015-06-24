<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class BioApiTest extends ApiTestCase
{
    use WithoutMiddleware;

    public function testFetchesAllBiosForUser()
    {
        $response = $this->call('GET', 'api/user/1/bios');
        $data = $this->parseJson($response);

        $this->assertIsJson($data);
        $this->assertInternalType('array', $data->data);
    }

    public function testFetchesOneBio()
    {
        $bioId = Bio::first()->id;
        $response = $this->call('GET', 'api/bios/' . $bioId);
        $data = $this->parseJson($response);

        $this->assertIsJson($data);
        $this->assertInternalType('object', $data->data);
    }

    public function testCannotFetchAllBiosForOtherUser()
    {
        $response = $this->call('GET', 'api/user/2/bios');
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testCannotFetchOneBioForOtherUser()
    {
        $bioId = Bio::where('user_id', 2)->first()->id;

        $response = $this->call('GET', 'api/bios/' . $bioId);

        $this->assertEquals(404, $response->getStatusCode());
    }

    // public function testMustBeAuthenticated()
    // {
    //     // @todo: Why is this not bailing out on the auth beforeFilter?
    //     Auth::logout();
    //     $response = $this->call('GET', 'api/user/1/bios');

    //     $this->assertEquals('Invalid credentials.', $response->getContent());
    // }
}
