
<div class="alert alert-default">
    {{ $reply->created_at->diffForHumans() }} |
    <a href="#">{{$reply->owner->name}}</a>
    <hr>
    {{ $reply->body}}
</div>