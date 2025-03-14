<?php

namespace Tests\Unit;

use App\Models\User;
use Filament\Panel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function only_admins_can_acess_filament(): void
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->nonAdmin()->create();

        $this->assertTrue($admin->canAccessPanel(new Panel));
        $this->assertFalse($user->canAccessPanel(new Panel));
    }
}
