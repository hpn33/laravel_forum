@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ $thread->title }}
                        <br>
                        by <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">

                @foreach ($replies as $reply)

                    @include('threads.reply')

                @endforeach

                {{ $replies->links() }}

                @if(auth()->check())
                    <form method="POST" action="{{ $thread->path('replies') }}">
                        @csrf

                        <div class='form-group'>
                            <textarea name='body' id='body' class="form-control" placeholder="Have something to say?"
                                      rows="5"></textarea>
                        </div>

                        <button type="submit" class="btn btn-default">Post</button>
                    </form>

                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this
                        discussion.
                    </p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">

                        <p>
                            This Thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="">{{ $thread->creator->name }}</a>, and currently
                            has {{ $thread->replies_count }} {{ \Illuminate\Support\Str::plural('comment', $thread->replies_count) }}
                            .
                        </p>

                    </div>
                </div>
            </div>

        </div>


    </div>
@endsection
