<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForum extends TestCase
{


    use DatabaseMigrations;


    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {

        $this->post('/threads/1/replies', [])
            ->assertRedirect('/login');

    }


    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {

        $user = create('App\User');
        $this->be($user);

        $thread = create('App\Thread');

        $reply = make('App\Reply');
        $this->post($thread->path('replies'), $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);

    }


}
