@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Threads</div>
                <div class="card-body">
                        <div class="alert alert-info">
                            <strong>{{ $thread->title }}</strong>
                            <hr>
                            {{ $thread->body}}
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Replies</div>
                <div class="card-body">
                    @foreach($thread->replies as $reply)
                        <div class="alert alert-default">
                            {{ $reply->created_at->diffForHumans() }} |
                            <a href="#">{{$reply->owner->name}}</a>
                            <hr>
                            {{ $reply->body}}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
@endsection