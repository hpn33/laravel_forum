<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function guests_may_not_create_threads()
    {

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');

    }


    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {

        $this->signIn();

        $thread = make('App\Thread');
        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }


    /** @test */
    function a_thread_requires_a_title()
    {

        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');

    }


    /** @test */
    function a_thread_requires_a_body()
    {

        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');

    }


    /** @test */
    function a_thread_requires_a_valid_channel()
    {

        create(Channel::class);

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');

    }


    /** @test */
    function a_thread_can_be_deleted()
    {

        $this->signIn();

        $thread = create('App\Thread');

        $this->json('DELETE', $thread->path());

        $this->assertDatabaseMissing('threads', $thread->toArray());

    }

    public function publishThread($overrides = [])
    {

        $this->signIn();

        $thread = make(Thread::class, $overrides);

        return $this->post('/threads', $thread->toArray());

    }


}
