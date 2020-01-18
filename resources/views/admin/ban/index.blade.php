@extends('titan::layouts.admin')

@section('page')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link @if(\Illuminate\Support\Str::contains(request()->path(), 'admin/banlist')) active @endif" href="{{route('admin.banuser.index')}}">Banned List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(\Illuminate\Support\Str::contains(request()->path(), 'admin/banuser/create')) active @endif" href="{{route('admin.banuser.create')}}">Ban User</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(\Illuminate\Support\Str::contains(request()->path(), 'admin/banchar/create')) active @endif" href="{{route('admin.banchar.create')}}">Ban Character</a>
        </li>
    </ul>
    @yield('partial')
@endsection
