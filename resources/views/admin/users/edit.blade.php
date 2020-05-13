@extends('layouts.admin')

@section('page')
    <div class="row">
        <div class="col-sm-12 col-lg-8">

            <h1 class="h3 mb-4 text-gray-800">Update User</h1>

            <div class="card shadow mb-4">
                <div class="card-body">
                    {!! \Form::open()->route('admin.users.update', [$user->id])->fill($user)->put() !!}
                    @include('titan::admin.users.form')
                    {!! \Form::submit('Update User') !!}
                    {!! \Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-4">
            @if(isset($user->characters))
                <h1 class="h3 mb-4 text-gray-800">Characters</h1>

            <ul class="nav flex-column nav-pills">
                @foreach($user->characters as $character)
                    <li class="nav-item">
                        <a href="{{ route('admin.characters.edit', $character) }}" class="nav-link">{{ $character->display_name }}</a>
                    </li>
                @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
