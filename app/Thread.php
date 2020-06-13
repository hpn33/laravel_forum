<?php

namespace App;

use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{


    protected $guarded = [];


    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });
    }


    public function path($extension = '')
    {

        $path = "/threads/{$this->channel->slug}/{$this->id}";

        if ($extension != '') {
            $path .= '/' . $extension;
        }

        return $path;

    }


    public function replies()
    {

        return $this->hasMany(Reply::class)
            ->withCount('favorites')
            ->with('owner');

    }


    public function creator()
    {

        return $this->belongsTo(User::class, 'user_id');

    }

    public function channel()
    {

        return $this->belongsTo(Channel::class);

    }


    public function addReply($reply)
    {

        $this->replies()->create($reply);

    }


    /**
     * Apply all relevant thread filters.
     *
     * @param Builder $query
     * @param ThreadFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, ThreadFilters $filters)
    {

        return $filters->apply($query);

    }


}
