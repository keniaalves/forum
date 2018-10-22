@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>
            {{ $profileUser->name}}
        </h1>
        <small>Since {{ $profileUser->created_at->diffForHumans()}}</small>
        <hr>
    </div>
    @forelse($activities as $date => $activity)
    <h4 class="page-header">{{ $date }}</h4>
        @foreach($activity as $record)
            @if(view()->exists("profiles.activities.{$record->type}"))
                @include( "profiles.activities.{$record->type}", ['activity' => $record] )
            @endif
        @endforeach
        @empty
            <p>There is no activity for this user yet.</p>
    @endforelse

</div>
@endsection 