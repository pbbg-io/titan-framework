@extends('layouts.admin')

@section('page')
    <div class="row">
        <div class="col-sm-12 col-lg-8 mb-4">

            <h1 class="h3 mb-4 text-gray-800">Update Character</h1>

            {!! \Form::open()->route('admin.characters.update', [$character->id])->fill($character)->put() !!}

            <div class="card shadow mb-4">
                <div class="card-body">
                    @include('titan::admin.characters.form')
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    @include('titan::admin.characters.form_stats')
                </div>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    {!! \Form::submit('Update Character') !!}
                </div>
            </div>
            {!! \Form::close() !!}
        </div>
    </div>
@endsection
