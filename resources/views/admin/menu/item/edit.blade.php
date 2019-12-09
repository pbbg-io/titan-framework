@extends('titan::layouts.admin')

@section('page')
    <h1 class="h3 mb-4 text-gray-800">Page Header</h1>


    <div class="card shadow mb-4">
        <div class="card-body">
            {!! \Form::open()->route('admin.groups.update', [$group])->fill($group)->put() !!}
            @include('titan::admin.groups.form')
            {!! \Form::submit('Update Group') !!}
            {!! \Form::close() !!}
        </div>
    </div>
@endsection
