@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>
            {{ $profileUser->name}}
        </h1>
        <small>Since {{ $profileUser->created_at->diffForHumans()}}</small>
    </div>
    @foreach($threads as $thread)
    <div class="card">
        <div class="card-header">Thread</div>
        <div class="card-body">
                <div class="alert alert-info">
                    <a href="{{ route('profile', $thread->owner)}}">{{$thread->owner->name}}</a> posted:
                    <strong><a href="{{$thread->path()}}">{{ $thread->title }}</a></strong>
                    <hr>
                    {{ $thread->body}}
                </div>
        </div>
    </div>
    @endforeach
    {{ $threads->links() }}
</div>
@endsection