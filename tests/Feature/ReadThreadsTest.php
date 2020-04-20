<?php

namespace Tests\Feature;

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
}
