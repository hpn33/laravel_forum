<?php

namespace Tests\Unit;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{

    use DatabaseMigrations;


    protected $thread;


    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }


    /** @test */
    function a_thread_can_make_a_string_path()
    {

        $thread = create(Thread::class);

        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());

    }


    /** @test */
    public function a_thread_has_a_creator()
    {

        $this->assertInstanceOf('App\User', $this->thread->creator);

    }


    /** @test */
    public function a_thread_has_replies()
    {

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);

    }


    /** @test */
    public function a_thread_can_add_a_reply()
    {

        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);

    }

    /** @test */
    function a_threads_belongs_to_a_channel()
    {

        $thread = create(Thread::class);

        $this->assertInstanceOf('App\Channel', $thread->channel);

    }

}
