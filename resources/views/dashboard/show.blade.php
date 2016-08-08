@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <h2>Pending</h2>

                            @if (count($pending) > 0)
                                <ul>
                                    @foreach ($pending as $image)
                                        <li>{{ $image->title }}</li>
                                    @endforeach
                                </ul>

                            @else
                                <p>No images pending.</p>
                            @endif

                            <a href="{{ url('/colourisations/new') }}" class="btn btn-primary">New Colourisation</a>
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <h2>Complete</h2>

                            @if (count($complete) > 0)

                            @else
                                <p>No images completed.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
