<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{


    function threads()
    {

        return $this->hasMany(Thread::class);

    }

}
