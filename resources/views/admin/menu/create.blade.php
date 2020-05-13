@extends('layouts.admin')

@section('page')
    <h1 class="h3 mb-4 text-gray-800">Create Menu</h1>


    <div class="card shadow mb-4">
        <div class="card-body">
            {!! \Form::open()->route('admin.menu.store') !!}
            @include('titan::admin.menu.form')
            {!! \Form::submit('Create Menu') !!}
            {!! \Form::close() !!}
        </div>
    </div>
@endsection
