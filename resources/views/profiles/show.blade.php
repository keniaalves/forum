@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>
            {{ $profileUser->name}}
        </h1>
        <small>Since {{ $profileUser->created_at->diffForHumans()}}</small>
    </div>
    @foreach($activities as $date => $activity)
        @foreach($activity as $record)
            @include( "profiles.activities.{$record->type}", ['activity' => $record] )
        @endforeach
    @endforeach
</div>
@endsection