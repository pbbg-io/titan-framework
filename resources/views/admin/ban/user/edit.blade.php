@extends('titan::admin.ban.index')
@section('partial')
    <div class="card shadow mb-4">
        {!! Form::open()->route('admin.banuser.update', [$banned->bannable->id])->fill($banned)->put() !!}
        <div class="card-body">
            <h3>Editing Ban for {{ $banned->bannable->name }}</h3>
            <div class="form-group">

                @include('titan::admin.ban.ban_edit_form')

            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            {!! Form::submit("Edit Ban")->danger() !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection
