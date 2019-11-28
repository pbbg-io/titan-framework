@extends('titan::layouts.admin')

@section('page')
    <h1 class="h3 mb-4 text-gray-800">Create Cronjob</h1>


    <div class="card shadow mb-4">
        <div class="card-body">
            {!! \Form::open()->route('admin.cronjobs.store') !!}
            {!! \Form::text('command', 'Artisan Command') !!}
            {!! \Form::text('expression', 'Cron Expression') !!}
            {!! \Form::checkbox('enabled', 'Enabled', 1) !!}
            {!! \Form::submit('Create Cronjob') !!}
            {!! \Form::close() !!}
        </div>
    </div>
@endsection
