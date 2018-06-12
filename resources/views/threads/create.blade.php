@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a new threads</div>

                <div class="card-body">
                    <form action="{{route('threads.store')}}" method="POST">
                        <div class="form-group">
                            <label for="">Title:</label>
                            <input type="text" class="form-control" id="title" placeholder="title">
                        </div>
                        <div class="form-group">
                            <label for="">Body:</label>
                            <textarea name="body" id="body" class="form-control" placeholder="body"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Publish</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection