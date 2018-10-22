<reply :attributes="{{ $reply }}" inline-template v-cloak>
<div id="reply-{{ $reply->id }}" class="alert alert-default">
    <div class="level">
        <div class="flex">
            {{ $reply->created_at->diffForHumans() }} |
            <a href="{{ route('profile', $reply->owner) }}">{{$reply->owner->name}}</a>
        </div>
        <div class="level">
            @if(auth::check())
                <favorite :reply="{{ $reply }}"></favorite>
            @endif
            @can('update', $reply)
                <button class="btn btn-success btn-xs" @click="editing = true">Editar</button>
                <button class="btn btn-danger btn-xs" @click="destroy">Delete</button>
            @endcan
        </div>
        </div> 
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                    <button class="btn btn-link btn-xs" @click="editing = false">Cancel</button>
                    <button class="btn btn-success btn-xs" @click="update">Update</button>
                </div>
            </div>
            <div v-else v-text="body"></div>
        <hr>
</div>
</reply>