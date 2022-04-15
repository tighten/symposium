<?php

namespace Tests\Feature;

use App\Models\Bio;
use App\Models\User;
use Tests\TestCase;

class BiosTest extends TestCase
{
    /** @test */
    public function user_can_create_a_private_bio()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('bios', [
                'nickname' => 'Some Nickname',
                'body' => 'A big chunk of bio-friendly text',
                'public' => '0',
            ]);

        $response->assertRedirectContains('bios/');

        $this->assertDatabaseHas(Bio::class, [
            'nickname' => 'Some Nickname',
            'body' => 'A big chunk of bio-friendly text',
            'public' => '0',
        ]);
    }

    /** @test */
    public function user_can_create_a_public_bio()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('bios', [
                'nickname' => 'Some Nickname',
                'body' => 'A big chunk of bio-friendly text',
                'public' => '1',
            ]);

        $response->assertRedirectContains('bios/');

        $this->assertDatabaseHas(Bio::class, [
            'nickname' => 'Some Nickname',
            'body' => 'A big chunk of bio-friendly text',
            'public' => '1',
        ]);
    }

    /** @test */
    public function user_can_edit_their_bio()
    {
        $user = User::factory()->create();
        $bio = Bio::factory()->for($user)->create();
        $user->bios()->save($bio);

        $this->actingAs($user)
            ->put("bios/{$bio->id}", [
                'nickname' => 'Fresh Prince',
                'body' => 'Born and raised in West Philidelphia, I spend a large majority of my time on the playground.',
                'public' => '1',
            ]);

        $this->assertDatabaseHas('bios', [
            'nickname' => 'Fresh Prince',
            'body' => 'Born and raised in West Philidelphia, I spend a large majority of my time on the playground.',
        ]);
    }

    /** @test */
    public function user_cannot_edit_a_bio_that_they_do_not_own()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $bio = Bio::factory()->for($userA)->create();

        $response = $this->actingAs($userB)->get("/bios/{$bio->id}/edit");
        $response->assertNotFound();
    }

    /** @test */
    public function user_can_delete_their_bio()
    {
        $user = User::factory()->create();
        $bio = Bio::factory()->for($user)->create([
            'nickname' => 'Jimmy Buffet',
            'body' => '5 oclock somewhere',
            'public' => 0,
        ]);

        $this->actingAs($user)->get("bios/{$bio->id}/delete");

        $this->assertModelMissing($bio);
    }

    /** @test */
    public function user_cannot_delete_a_bio_they_dont_own()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $bio = Bio::create([
            'user_id' => $userA->id,
            'nickname' => 'Jimmy Buffet',
            'body' => '5 oclock somewhere',
            'public' => 0,
        ]);

        $response = $this->actingAs($userB)
            ->delete("bios/{$bio->id}");

        $response->assertNotFound();

        $this->assertModelExists($bio);
    }
}
