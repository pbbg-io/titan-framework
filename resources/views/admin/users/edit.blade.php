@extends('titan::layouts.admin')

@section('page')
    <h1 class="h3 mb-4 text-gray-800">Update User</h1>



    <div class="card shadow mb-4">
        <div class="card-body">
            {!! \Form::open()->route('admin.users.update', [$user->id])->fill($user)->put() !!}
            @include('titan::admin.users.form')
            {!! \Form::submit('Update User') !!}
            {!! \Form::close() !!}
        </div>
    </div>
@endsection
