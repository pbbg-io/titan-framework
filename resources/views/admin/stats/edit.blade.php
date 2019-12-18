@extends('titan::layouts.admin')

@section('page')
    <div class="row">
        <div class="col-sm-12 col-lg-8">

            <h1 class="h3 mb-4 text-gray-800">Update Stat</h1>

            {!! \Form::open()->route('admin.stats.update', [$stat->id])->fill($stat)->put() !!}

            <div class="card shadow mb-4">
                <div class="card-body">
                    @include('titan::admin.stats.form')
                    {!! \Form::submit('Update Stat') !!}
                </div>
            </div>
            {!! \Form::close() !!}
        </div>
    </div>
@endsection
