@extends('layouts.admin')

@section('page')
    <h1 class="h3 mb-4 text-gray-800">Create Group</h1>


    {!! \Form::open()->route('admin.groups.store') !!}
    <div class="card shadow mb-4">
        <div class="card-body">
            @include('titan::admin.groups.form')
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            @include('titan::admin.groups.form-permission')
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            {!! \Form::submit('Create Group') !!}
        </div>
    </div>
    {!! \Form::close() !!}
@endsection
