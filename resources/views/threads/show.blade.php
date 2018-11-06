@extends('layouts.app')

@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Thread</div>
                <div class="card-body">
                        <div class="alert alert-info">
                            <div class="d-flex justify-content-center">
                                <div>
                                    <a href="{{ route('profile', $thread->owner) }}">{{$thread->owner->name}}</a> posted:
                                    <strong>{{ $thread->title }}</strong>
                                </div>
                                @can('update', $thread)
                                    <form action="{{$thread->path()}}" method="POST">
                                        @csrf
                                        {{ method_field('DELETE')}}
                                        <button type="submit" class="btn btn-link">Delete</button>
                                    </form>
                                @endcan
                                </div>
                            <hr>
                            {{ $thread->body}}
                        </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Replies</div>
                <div class="card-body">
                <replies :data="{{ $thread->replies }}" @remove="repliesCount--"></replies>

                    <!-- {{ $replies->links() }}  -->
                </div>
            </div>

            @if(auth()->check())

            <form action="{{$thread->path() . '/replies'}}" method="POST">
                {{ csrf_field() }}
                <textarea name="body" id="" cols="30" rows="4" class="form-control" placeholder="Have something to say?"></textarea>
                <button type="submit" class="btn btn-default">Post</button>
            </form>

            @else
    <p>Please  <a href="{{route('login')}}">sign in</a> to participate in this discussion.</p>
@endif
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Threads</div>
                <div class="card-body">
                      This threads was published {{ $thread->created_at->diffForHumans() }} by <a href="{{ route('profile', $thread->owner) }}">{{ $thread->owner->name }}</a>
                      and currently has <span v-text="repliesCount"></span> {{ str_plural('reply', $thread->replies_count )}}.
                </div>
            </div>
        </div>
    </div>
</div>
</thread-view>
@endsection
