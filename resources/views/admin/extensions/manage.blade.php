@extends('titan::layouts.admin')

@section('page')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $ext->json['name'] }}
        <span class="float-right">
            @if(isset($ext->id))
                <a href="{{ route('admin.extensions.uninstall', $ext->json['slug']) }}"
                   class="btn btn-danger">Uninstall</a>
            @else
                <a href="{{ route('admin.extensions.install', $ext->json['slug']) }}"
                   class="btn btn-success">Install</a>
            @endif
        </span>
    </h1>

    <div class="row">
        <div class="col-9">

            @if(isset($ext->json['local']))
                <p class="alert alert-warning">This extension is locally required</p>
            @endif
            <div class="card">
                <div class="card-body">
                    <p>
                        {{ $ext->json['description'] }}
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
                            @if($ext->json['rating'] === 0) 0 @else

                                @for($i=0;$i<$ext->json['rating']??0;$i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                            @endif
                            <span>({{ number_format($ext->json['ratings']) }})</span>
                        </li>
                        <li>Installs: {{ number_format($ext->json['installs']) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
