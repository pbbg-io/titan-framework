@extends('titan::admin.ban.index')
@section('partial')
    <div class="card shadow mb-4">
        {!! Form::open()->route('admin.banuser.update', [$banned->bannable->id])->fill($banned)->put() !!}
        <div class="card-body">
            <h3>Editing Ban for {{ $banned->bannable->name }}</h3>
            <div class="form-group">
                {!! Form::hidden('bannable_id', $banned->bannable->id) !!}
                {!! Form::text('reason', 'Reason for ban')
                    ->help('Enter a reason for banning the user')!!}
                {!! Form::date('ban_until', 'How Long')
                    ->help('When should they be banned until?') !!}
                {!! Form::checkbox('forever', 'Forever')
                    ->checked($banned->forever == 1) !!}
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            {!! Form::submit("Edit Ban")->danger() !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
