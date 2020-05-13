@extends('layouts.admin')

@section('page')
    <h1 class="h3 mb-4 text-gray-800">Settings
        @if(isset($category))
            <small class="text-muted">Viewing category {{ $category }}</small>
        @endif</h1>
    <div class="row">
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h5>Categories</h5>
                    <ul class="nav flex-column nav-pills">
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.index') }}"
                               class="nav-link @if($category === 'All') active @endif">All</a>
                        </li>
                        @foreach($categories as $key)
                            <li class="nav-item">
                                <a href="{{ route('admin.settings.category', $key) }}"
                                   class="nav-link @if($category === $key) active @endif">{{ \Str::title($key) }}</a>
                            </li>

                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="card mb-2">
                <div class="card-body">
                    {!! \Form::open()->route('admin.settings.update')->method('PUT') !!}
                    @foreach($settings as $setting)
                        @php
                            $name = str_replace(['_', '-', '.'], ' ', $setting->key);
                            $name = \Str::title($name);
                        @endphp

                        @switch($setting->field_type)
                            @case('boolean')
                            {!! \Form::checkbox('setting['.$setting->id.']', $name, 1, $setting->value) !!}
                            @break
                            @case('string')
                            {!! \Form::text('setting['.$setting->id.']', $name, $setting->value) !!}
                            @break
                            @case('text')
                            {!! \Form::checkbox('setting['.$setting->id.']', $name, $setting->value) !!}

                            @break
                            @case('integer')
                            {!! \Form::text('setting['.$setting->id.']', $name, $setting->value) !!}
                            @break
                            @case('float')
                            {!! \Form::checkbox('setting['.$setting->id.']', $name, $setting->value) !!}
                            @break
                            @default
                            {!! \Form::text('setting['.$setting->id.']', $name, $setting->value) !!}
                        @endswitch
                        {{ $setting->description }}
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    {!! \Form::submit('Update settings') !!}
                </div>
            </div>
        </div>
    </div>
@endsection
