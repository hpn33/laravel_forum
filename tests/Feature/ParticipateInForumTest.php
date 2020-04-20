<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForum extends TestCase
{


    use DatabaseMigrations;


    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {

        $thread = create(Thread::class);
        $this->post($thread->path('replies'))
            ->assertRedirect('/login');

    }


    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {

        $this->withoutExceptionHandling();
        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply');
        $this->post($thread->path('replies'), $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);

    }


    /** @test */
    function a_reply_requires_a_body()
    {

        $this->signIn();

        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body' => null]);

        $this->post($thread->path('replies'), $reply->toArray())
            ->assertSessionHasErrors('body');

    }

}
