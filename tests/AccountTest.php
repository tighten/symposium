<?php

use Laracasts\TestDummy\Factory;

class AccountTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_deletes_the_user_account()
    {
        $user = Factory::create('user');
        $this->actingAs($user)
             ->visit('account/delete')
             ->press('Yes')
             ->seePageIs('/')
             ->see('Successfully deleted account.');

        $this->dontSeeInDatabase('users', [
            'email' => $user->email,
        ]);
    }
}
