@extends('layouts.admin')

@section('page')
    <div class="row">
        <div class="col-sm-12 col-lg-8">

            <h1 class="h3 mb-4 text-gray-800">Update Area</h1>

            {!! \Form::open()->route('admin.areas.update', [$area->id])->fill($area)->put() !!}

            <div class="card shadow mb-4">
                <div class="card-body">
                    @include('titan::admin.areas.form')
                    {!! \Form::submit('Update Area') !!}
                </div>
            </div>
            {!! \Form::close() !!}
        </div>
    </div>
@endsection
