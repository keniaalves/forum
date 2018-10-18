@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forum threads</div>

                <div class="card-body">
                    @forelse ($threads as $thread)
                        <div class="alert alert-info">
                            <strong><a href="{{$thread->path()}}">{{ $thread->title }}</a></strong> |
                            <strong><a href="{{$thread->path()}}">{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</a></strong>
                            <hr>
                            {{ $thread->body}}
                        </div>
                        @empty
                        <p>There are no relevant results at this time.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection