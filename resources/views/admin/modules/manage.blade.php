@extends('titan::layouts.admin')

@section('page')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $module['name'] }}
        <span class="float-right">
            @if($module['enabled'] === true)
                <a href="{{ route('admin.modules.uninstall', $module['slug']) }}"
                   class="btn btn-danger">Uninstall</a>
            @else
                <a href="{{ route('admin.modules.install', $module['slug']) }}"
                   class="btn btn-success">Install</a>
            @endif
        </span>
    </h1>

    <div class="row">
        <div class="col-9">

            @if(isset($module['local']))
                <p class="alert alert-warning">This module is locally required</p>
            @endif
            <div class="card">
                <div class="card-body">
                    <p>
                        {{ $module['description'] }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
