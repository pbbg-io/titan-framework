@extends('titan::layouts.admin')

@section('page')
    <h1 class="h3 mb-4 text-gray-800">Create Stat</h1>


    <div class="card shadow mb-4">
        <div class="card-body">
            {!! \Form::open()->route('admin.stats.store') !!}
            @include('titan::admin.stats.form')
            {!! \Form::submit('Create Stat') !!}
            {!! \Form::close() !!}
        </div>
    </div>
@endsection
