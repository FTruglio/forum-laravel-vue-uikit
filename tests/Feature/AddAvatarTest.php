<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AddAvatarTest extends TestCase
{
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function only_members_can_add_avatars()
    {
        $this->withExceptionHandling();
        $response = $this->json('POST', '/api/users/'. '1' .'/avatar');
        // 401 unauthorized
        $response->assertStatus(401);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_valid_avatar_must_be_provided()
    {
        $this->signIn();
        $this->withExceptionHandling();
        $response = $this->json('POST', '/api/users/'. auth()->id() .'/avatar', [
            'avatar' => 'not-an-image'
        ]);
        // 422 unprocessable entity;
        $response->assertStatus(422);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_user_may_add_an_avatar_to_their_profile()
    {
        $this->signIn();
        $this->withExceptionHandling();

        Storage::fake('public');


        $this->json('POST', '/api/users/'. auth()->id() .'/avatar', [
            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $this->assertEquals('avatars/'. $file->hashName(), auth()->user()->avatar_path);

        Storage::disk('public')->assertExists('avatars/'. $file->hashName());
    }
}
