@extends('layouts.admin')

@section('page')
    <h1 class="h3 mb-4 text-gray-800">Create Area</h1>


    <div class="card shadow mb-4">
        <div class="card-body">
            {!! \Form::open()->route('admin.areas.store') !!}
            @include('titan::admin.areas.form')
            {!! \Form::submit('Create Area') !!}
            {!! \Form::close() !!}
        </div>
    </div>
@endsection
