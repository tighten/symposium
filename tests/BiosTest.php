<?php

use Laracasts\TestDummy\Factory;

class BiosTest extends IntegrationTestCase
{
    /** @test */
    function user_can_create_a_private_bio()
    {
        $user = Factory::create('user');

        $this->actingAs($user)
            ->visit('/bios/create')
            ->type('Some Nickname', '#nickname')
            ->type('A big chunk of bio-friendly text', '#body')
            ->select('no', '#public')
            ->press('Create');
            //->seePageIs('bios'); //not sure how to test the string /bios/x

        $this->seeInDatabase('bios', [
            'nickname' => 'Some Nickname',
            'body' => 'A big chunk of bio-friendly text',
            'public' => 'no'
        ]);
    }

    /** @test */
    function user_can_create_a_public_bio()
    {
        $user = Factory::create('user');

        $this->actingAs($user)
            ->visit('/bios/create')
            ->type('Some Nickname', '#nickname')
            ->type('A big chunk of bio-friendly text', '#body')
            ->select('yes', '#public')
            ->press('Create');
            //->seePageIs('bios'); //not sure how to test the string /bios/x

        $this->seeInDatabase('bios', [
            'nickname' => 'Some Nickname',
            'body' => 'A big chunk of bio-friendly text',
            'public' => 'yes'
        ]);
    }

    /** @test */
    function user_can_edit_their_bio()
    {
        $user = Factory::create('user');
        $bio = Factory::build('bio');
        $user->bios()->save($bio);

        $this->actingAs($user)->put('/bios/' . $bio->id,[
            'nickname' => 'Fresh Prince',
            'body' => 'Born and raised in West Philidelphia, I spend a large majority of my time on the playground.'
        ]);

        $this->seeInDatabase('bios', [
            'nickname' => 'Fresh Prince',
            'body' => 'Born and raised in West Philidelphia, I spend a large majority of my time on the playground.'
        ]);
    }

    /** @test */
    function user_cannot_edit_a_bio_that_they_do_not_own()
    {
        $userA = Factory::create('user');
        $userB = Factory::create('user');

        $bio = Factory::build('bio');
        $userA->bios()->save($bio);

        //It is poor form to put two calls in one test? It is essentially testing
        //the same thing, but it is two different methods? SRP on testing?
        $responseGet = $this->actingAs($userB)->get('/bios/' . $bio->id . '/edit');
        $responseGet->assertResponseStatus(404); //gives 404, should this be a 403?     

        $responsePut = $this->actingAs($userB)->put('/bios/' . $bio->id,[
            'nickname' => 'Fresh Prince',
            'body' => 'Born and raised in West Philidelphia, I spend a large majority of my time on the playground.'
        ]);
        $responsePut->assertResponseStatus(404); //gives 404, should this be a 403?  
    }

    /** @test */
    function user_can_delete_their_bio()
    {
        $user = Factory::create('user');
        $bio = App\Bio::create([
            'user_id' => $user->id,
            'nickname' => 'Jimmy Buffet',
            'body' => '5 oclock somewhere',
            'public' => 0
        ]);

        $this->actingAs($user)->call('delete', '/bios/' . $bio->id);
        $this->missingFromDatabase('bios', [
            'nickname' => 'Jimmy Buffet',
            'body' => '5 oclock somewhere'
        ]);
    }

    /** @test */
    function user_cannot_delete_a_bio_they_dont_own()
    {
        $userA = Factory::create('user');
        $userB = Factory::create('user');
        $bio = App\Bio::create([
            'user_id' => $userA->id,
            'nickname' => 'Jimmy Buffet',
            'body' => '5 oclock somewhere',
            'public' => 0
        ]);

        $this->actingAs($userB)->call('delete', '/bios/' . $bio->id);
        $this->seeInDatabase('bios', [
            'nickname' => 'Jimmy Buffet',
            'body' => '5 oclock somewhere'
        ]);
    }
}
