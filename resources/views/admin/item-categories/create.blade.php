@extends('titan::layouts.admin')

@section('page')
    <div class="row">
        <div class="col-sm-12 col-lg-8">

            <h1 class="h3 mb-4 text-gray-800">Create Item Category</h1>

            {!! \Form::open()->route('admin.item-categories.store') !!}

            <div class="card shadow mb-4">
                <div class="card-body">
                    @include('titan::admin.item-categories.form')
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    {!! \Form::submit('Create Item') !!}
                </div>
            </div>
            {!! \Form::close() !!}
        </div>
    </div>
@endsection
