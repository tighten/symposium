<?php

namespace Tests;

use App\Bio;
use App\User;

class BiosTest extends IntegrationTestCase
{
    /** @test */
    function user_can_create_a_private_bio()
    {
        $user = factory(User::class)->create();

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
            'public' => 0,
        ]);
    }

    /** @test */
    function user_can_create_a_public_bio()
    {
        $user = factory(User::class)->create();

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
            'public' => 1,
        ]);
    }

    /** @test */
    function user_can_edit_their_bio()
    {
        $user = factory(User::class)->create();
        $bio = factory(Bio::class)->create(['user_id' => $user->id]);
        $user->bios()->save($bio);

        $this->actingAs($user)
            ->visit('/bios/' . $bio->id . '/edit')
            ->type('Fresh Prince', '#nickname')
            ->type('Born and raised in West Philidelphia, I spend a large majority of my time on the playground.', '#body')
            ->select('yes', '#public')
            ->press('Update');

        $this->seeInDatabase('bios', [
            'nickname' => 'Fresh Prince',
            'body' => 'Born and raised in West Philidelphia, I spend a large majority of my time on the playground.',
        ]);
    }

    /** @test */
    function user_cannot_edit_a_bio_that_they_do_not_own()
    {
        $userA = factory(User::class)->create();
        $userB = factory(User::class)->create();

        $bio = factory(Bio::class)->create(['user_id' => $userA->id]);

        $responseGet = $this->actingAs($userB)->get('/bios/' . $bio->id . '/edit');
        $responseGet->assertResponseStatus(404); //gives 404, should this be a 403?
    }

    /** @test */
    function user_can_delete_their_bio()
    {
        $user = factory(User::class)->create();
        $bio = factory(Bio::class)->create([
            'user_id' => $user->id,
            'nickname' => 'Jimmy Buffet',
            'body' => '5 oclock somewhere',
            'public' => 0,
        ]);

        $this->actingAs($user)->visit('/bios/' . $bio->id . '/delete');
        $this->missingFromDatabase('bios', [
            'nickname' => 'Jimmy Buffet',
            'body' => '5 oclock somewhere',
        ]);
    }

    /** @test */
    function user_cannot_delete_a_bio_they_dont_own()
    {
        $userA = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $bio = Bio::create([
            'user_id' => $userA->id,
            'nickname' => 'Jimmy Buffet',
            'body' => '5 oclock somewhere',
            'public' => 0,
        ]);

        $this->actingAs($userB)->call('delete', '/bios/' . $bio->id);
        $this->seeInDatabase('bios', [
            'nickname' => 'Jimmy Buffet',
            'body' => '5 oclock somewhere',
        ]);
    }
}
