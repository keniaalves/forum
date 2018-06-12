@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Reply</div>
                <div class="card-body">
                        <div class="alert alert-info">
                            <strong>{{ $thread->title }}</strong>
                            <hr>
                            {{ $reply->created_at->diffForHumans() }}
                            {{ $reply->body}}
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection