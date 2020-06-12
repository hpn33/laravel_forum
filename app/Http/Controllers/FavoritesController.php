<?php

namespace App\Http\Controllers;

use App\Favorite;
use Illuminate\Http\Request;
use App\Reply;
use Illuminate\Support\Facades\DB;


class FavoritesController extends Controller
{

    function __construct()
    {

        $this->middleware('auth');

    }


    function store(Reply $reply)
    {

        $reply->favorite();

        return back();

    }
}
