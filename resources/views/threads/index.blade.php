@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forum threads</div>

                <div class="card-body">
                    @foreach ($threads as $thread)
                        <div class="alert alert-info">
                            <strong><a href="{{$thread->path()}}">{{ $thread->title }}</a></strong> |
                            <strong><a href="{{$thread->path()}}">{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</a></strong>
                            <hr>
                            {{ $thread->body}}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection