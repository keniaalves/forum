@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Threads</div>
                <div class="card-body">
                        <div class="alert alert-info">
                            <a href="#">{{$thread->owner->name}}</a> posted:
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
                        @include ('threads.reply')
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@if(auth()->check())
    <div style="padding-top: 50px;padding-bottom: 50px;" class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{$thread->path() . '/replies'}}" method="POST">
            {{ csrf_field() }} 
                
                <textarea name="body" id="" cols="30" rows="4" class="form-control" placeholder="Have something to say?"></textarea>

                <button type="submit" class="btn btn-default">Post</button>
            </form>
        </div>
    </div>
@else
    <p class="text-center" >Please  <a href="{{route('login')}}">sign in</a> to participate in this discussion.</p>
@endif

</div>
@endsection