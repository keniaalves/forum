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
                <replies :data="{{ $thread->replies }}" @added="repliesCount++" @removed="repliesCount--"></replies>

                    <!-- {{ $replies->links() }}  -->
                </div>
            </div>
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
