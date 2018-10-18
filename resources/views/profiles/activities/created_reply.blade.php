<div class="card mb-4">
    <div class="card-header">{{ $profileUser->name }} replied to 
        <a href="{{ $activity->subject->thread->path() }}"> "{{ $activity->subject->thread->title }}"</a></div>
    <div class="card-body">
        {{ $activity->subject->body }}
    </div>
</div>
