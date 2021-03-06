<?php

namespace Tests\Feature;

use App\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoritesTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    function guests_can_not_favorite_anything()
    {

        $this->post('replies/1/favorites')
            ->assertRedirect('/login');

    }


    /** @test */
    public function an_authenticated_user_can_favorite_any_replay()
    {

        $this->signIn();

        $reply = create('App\Reply');

        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);

    }


    function an_authenticated_user_may_only_favorite_a_reply_once()
    {

        $this->signIn();

        $reply = create('App\Reply');

        try {
            $this->post('replies/' . $reply->id . '/favorites');
            $this->post('replies/' . $reply->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail('just once favorite');
        }

        $this->assertCount(1, $reply->favorites);

    }


}
