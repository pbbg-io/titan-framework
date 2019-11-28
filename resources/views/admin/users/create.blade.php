@extends('titan::layouts.admin')

@section('page')
    <h1 class="h3 mb-4 text-gray-800">Create User</h1>


    <div class="card shadow mb-4">
        <div class="card-body">
            {!! \Form::open()->route('admin.users.store') !!}
            @include('titan::admin.users.form')
            {!! \Form::submit('Create User') !!}
            {!! \Form::close() !!}
        </div>
    </div>
@endsection
