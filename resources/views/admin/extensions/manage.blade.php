@extends('layouts.admin')

@section('page')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $extension['name'] }}
        <span class="float-right">
            @if(resolve('extensions')->enabled($extension['slug']))
                <a href="{{ route('admin.extensions.uninstall', $extension['slug']) }}"
                   class="btn btn-danger">Uninstall</a>
            @else
                <a href="{{ route('admin.extensions.install', $extension['slug']) }}"
                   class="btn btn-success">Install</a>
            @endif
        </span>
    </h1>

    <div class="row">
        <div class="col-9">

            @if(isset($extension['local']))
                <p class="alert alert-warning">This extension is locally required</p>
            @endif
            <div class="card">
                <div class="card-body">
                    <p>
                        {{ $extension['description'] }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Statistics</h4>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li>Rating:
                            @if($extension['rating'] === 0) 0 @else

                                @for($i=0;$i<$extension['rating'];$i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                            @endif
                            <span>({{ number_format($extension['ratings']) }})</span>
                        </li>
                        <li>Installs: {{ number_format($extension['installs']) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
