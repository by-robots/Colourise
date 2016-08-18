@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h2 style="margin:0;padding:0;display:inline-block">Dashboard</h2>
                    <a href="{{ url('/colourisations/new') }}" class="btn btn-primary pull-right">New Colourisation</a>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <h3>Pending Groups</h3>

                            @if (count($pendingGroups) > 0)
                                <ul>
                                    @foreach ($pendingGroups as $group)
                                        <li>{{ $group->title }}</li>
                                    @endforeach
                                </ul>

                            @else
                                <p>No groups pending.</p>
                            @endif
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <h3>Complete Groups</h3>

                            @if (count($completeGroups) > 0)
                                <ul>
                                    @foreach ($completeGroups as $group)
                                        <li>
                                            {{ $group->title }}
                                            [<a href="/groups/{{ $group->id }}">Download</a>]
                                        </li>
                                    @endforeach
                                </ul>

                            @else
                                <p>No groups completed.</p>
                            @endif
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <h3>Pending Singles</h3>

                            @if (count($pendingSingles) > 0)
                                <ul>
                                    @foreach ($pendingSingles as $image)
                                        <li>{{ $image->title }}</li>
                                    @endforeach
                                </ul>

                            @else
                                <p>No images pending.</p>
                            @endif
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <h3>Complete Singles</h3>

                            @if (count($completeSingles) > 0)
                                <ul>
                                    @foreach ($completeSingles as $image)
                                        <li>
                                            {{ $image->title }}
                                            [<a href="/colourisations/{{ $image->id }}/original">Original</a>]
                                            [<a href="/colourisations/{{ $image->id }}/colourised">Colourised</a>]
                                        </li>
                                    @endforeach
                                </ul>

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
