<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{


    protected $guarded = [];


    public function path(String $extention = '')
    {
        
        $path = '/threads/' . $this->id; 
        
        if ($extention != '')
        {
            $path .= '/' . $extention;
        }

        return $path;
    
    }


    public function replies()
    {
    
        return $this->hasMany(Reply::class);
    
    }


    public function creator()
    {
    
        return $this->belongsTo(User::class, 'user_id');
    
    }


    public function addReply($reply)
    {

        $this->replies()->create($reply);

    }


}
