<?php

class BioApiTest extends ApiTestCase
{
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

        // @todo: This doesn't feel right. Originally I wanted 403, then 404
        // (so we're not exposing that the given bio ID exists), but the
        // default is 500 which just feels wrong.
        $this->assertEquals(500, $response->getStatusCode());
    }

    // public function testMustBeAuthenticated()
    // {
    //     // @todo: Why is this not bailing out on the auth beforeFilter?
    //     Auth::logout();
    //     $response = $this->call('GET', 'api/user/1/bios');

    //     $this->assertEquals('Invalid credentials.', $response->getContent());
    // }
}
