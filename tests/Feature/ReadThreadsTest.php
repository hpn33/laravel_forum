<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{

    use DatabaseMigrations;


    public function setUp(): void
    {

        parent::setUp();

    }


    /** @test */
    public function a_user_can_view_all_threads()
    {

        $thread = create('App\Thread');

        $this->get('/threads')
            ->assertSee($thread->title);

    }


    /** @test */
    public function a_user_can_read_a_single_thread()
    {

        $thread = create('App\Thread');

        $this->get($thread->path())
            ->assertSee($thread->title);

    }


    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {

        $thread = create('App\Thread');

        $reply = factory('App\Reply')
            ->create(['thread_id' => $thread->id]);

        $this->get($thread->path())
            ->assertSee($reply->body);

    }

    /** @test */
    function a_user_can_filter_threads_according_to_a_channel()
    {

        $channel = create(Channel::class);
        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);
        $threadNotInChannel = create(Thread::class);

        $this->get("/threads/{$channel->slug}")
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);

    }


    /** @test */
    function a_user_can_filter_threads_by_any_username()
    {

        $this->signIn(create('App\User', ['name' => 'JohnDoe']));

        $threadByJohn = create(Thread::class, ['user_id' => auth()->id()]);

        $threadNotByJohn = create(Thread::class);

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);

    }


}
