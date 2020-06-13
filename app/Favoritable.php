<?php



namespace App;

use Illuminate\Database\Eloquent\Model;


trait Favoritable {




    function favorites()
    {

        return $this->morphMany(Favorite::class, 'favorited');

    }


    function favorite()
    {

        $attributes = ['user_id' => auth()->id()];

        if (! $this->favorites()->where($attributes)->exists()) {

            return $this->favorites()->create($attributes);

        }

    }

    function isFavorited()
    {

        return !! $this->favorites->where('user_id', auth()->id())->count();

    }

    function getFavoritesCountAttribute()
    {

        return $this->favorites->count();

    }
}