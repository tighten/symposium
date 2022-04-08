<?php

namespace Tests\Api;

use App\Models\Bio;

class BioApiTest extends ApiTestCase
{
    /** @test */
    public function can_fetch_all_user_bios()
    {
        $response = $this->call('GET', '/api/user/1/bios');
        $data = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsArray($data->data);
    }

    /** @test */
    public function can_fetch_one_user_bio()
    {
        $bioId = Bio::first()->id;
        $response = $this->call('GET', "api/bios/{$bioId}");
        $data = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($data->data);
    }

    /** @test */
    public function cannot_fetch_all_bios_for_other_user()
    {
        $response = $this->call('GET', 'api/user/2/bios');

        $this->assertEquals(404, $response->getStatusCode());
    }

    /** @test */
    public function cannot_fetch_one_bio_for_other_user()
    {
        $bioId = Bio::where('user_id', 2)->first()->id;
        $response = $this->call('GET', "api/bios/{$bioId}");

        $this->assertEquals(404, $response->getStatusCode());
    }

    // function testMustBeAuthenticated()
    // {
    //     // @todo: Why is this not bailing out on the auth beforeFilter?
    //     Auth::logout();
    //     $response = $this->call('GET', 'api/user/1/bios');

    //     $this->assertEquals('Invalid credentials.', $response->getContent());
    // }
}
