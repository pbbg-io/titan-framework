@extends('titan::layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h2>You must choose your character first</h2>
                <hr>
            </div>
        </div>

        @if($characters->count() > 0)
            <div class="row">
                @foreach($characters as $character)


                    <div class="col-sm-12 col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                {{ $character->display_name }}
                            </div>
                            <div class="card-body">
                                {!! \Form::open()->route('character.choose.submit') !!}
                                {!! \Form::hidden('id', $character->id) !!}
                                {!! \Form::submit('Play') !!}
                                {!! \Form::close() !!}
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        @else
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            It looks like you don't have any characters, create one now to get in game
                        </div>
                        <div class="card-body">

                            {!! \Form::open()->route('character.create') !!}

                            @include('titan::character.choice.form')
                            {!! \Form::submit('Create Character') !!}
                            {!! \Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
