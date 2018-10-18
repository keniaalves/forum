<div class="card mb-4">
    <div class="card-header">{{ $profileUser->name }} published a 
    <a href="{{ $activity->subject->path() }}"> "{{ $activity->subject->title }}"</a>
    </div>
    <div class="card-body">
        {{ $activity->subject->body }}
    </div>
</div>