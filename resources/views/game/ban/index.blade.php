@extends('layouts.game')
@section('content')
    <div class="container-fluid">

        @switch($ban->bannable_type)
            @case(get_class(auth()->user()->character))
                <h3>Your Character is banned</h3>
                @break
            @case(get_class(auth()->user()))
                <h3>Your Account is banned</h3>
                @break
        @endswitch

        @if($ban->forever)
            <p>You are permanently banned</p>
        @else
            <p>Your are banned for {{ $ban->ban_until->diffForHumans(['parts' => 3]) }}</p>
        @endif
        <p class="text-muted"><b>Reason: </b>{{ $ban->reason ?? 'No Reason Specified' }}</p>
    </div>
@endsection
