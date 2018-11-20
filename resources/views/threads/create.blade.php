@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a new threads</div>

                <div class="card-body">
                    <form action="{{route('threadStore')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="">Choose a channel:</label>
                            <select name="channel_id" id="channel_id" class="form-control" required>
                                <option value="">Choose a option...</option>
                                @foreach ($channels as $channel)
                                    <option value="{{$channel->id}}" {{ old('channel_id') == $channel->id ? 'selected' : ''}}>{{$channel->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Title:</label>
                            <input type="text" class="form-control" id="title" placeholder="title" name="title" value="{{ old('title')}}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Body:</label>
                            <textarea name="body" id="body" class="form-control" placeholder="body" value="{{ old('body')}}" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default">Publish</button>
                        </div>
                        @if(count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
