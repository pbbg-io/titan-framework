@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h2>You must choose your character first</h2>
                <hr>
            </div>
        </div>

        <div class="row mb-5">
            @foreach($characters as $character)

                <div class="col-sm-12 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            {{ $character->display_name }}
                        </div>
                        <div class="card-body">
                            {!! \Form::open()->route('character.choose.submit') !!}
                            {!! \Form::hidden('id', $character->id) !!}
                            @if($character->getStat('alive') === true)
                                {!! \Form::submit('Play') !!}
                            @else
                                This character died
                            @endif
                            {!! \Form::close() !!}
                        </div>
                    </div>
                </div>

            @endforeach
        </div>

        @if(\Auth::user()->getAliveCharacters()->count() < config('game.max_alive_characters'))
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            It looks like you don't have any characters alive, create one now to get in game
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
