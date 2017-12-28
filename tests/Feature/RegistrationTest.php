<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Mail\ConfirmEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

class RegistrationTest extends TestCase
{
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_confirmation_email_is_sent_to_the_users_email()
    {
        Mail::fake();

        event(new Registered(create('App\User')));

        Mail::assertSent(ConfirmEmail::class);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_user_can_fully_confirm_their_email_address()
    {
        $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@someemail.com',
            'password' => 'foobar',
            'password_confirmation' => 'foobar'
        ]);

        $user = User::whereName('John Doe')->first();

        $this->assertFalse($user->fresh()->confirmed);
        $this->assertNotNull($user->fresh()->confirmation_token);

        // Let the user confirm their account.
        $response = $this->get('/confirmation?token=' . $user->confirmation_token);
        $this->assertTrue($user->fresh()->confirmed);
        $response->assertRedirect('/threads');
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function confirming_an_invalid_token()
    {
        $response = $this->get('/confirmation?token=invalid token')
        ->assertRedirect('/threads')
        ->assertSessionhas('flash');
    }
}
