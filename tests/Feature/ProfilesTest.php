<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfilesTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function a_user_has_a_profile()
    {

        $user = create('App\User');

        $this->get("/profiles/{$user->name}")
            ->assertSee($user->name);

    }

    function profiles_display_all_threads_created_by_the_accociated_user()
    {

        $user = create('App\User');

        $thread = create('App\Thread', ['user_id' => $user->id]);

        $this->get("/profiles/{$user->name}")
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }
}
