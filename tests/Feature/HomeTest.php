<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function including_featured_speakers()
    {
        User::factory()->featured()->create(['name' => 'Luke Skywalker']);
        User::factory()->notFeatured()->create(['name' => 'Han Solo']);

        $response = $this->get(route('home'));

        $response->assertSuccessful();
        $response->assertSee('Luke Skywalker');
        $response->assertDontSee('Han Solo');
    }

    /** @test */
    public function including_featured_conferences()
    {
        Conference::factory()->featured()->create(['title' => 'Awesome Conference']);
        Conference::factory()->notFeatured()->create(['title' => 'Boring Conference']);

        $response = $this->get(route('home'));

        $response->assertSuccessful();
        $response->assertSee('Awesome Conference');
        $response->assertDontSee('Boring Conference');
    }
}
