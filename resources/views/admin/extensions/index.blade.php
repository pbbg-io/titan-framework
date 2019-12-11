@extends('titan::layouts.admin')

@section('page')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Available Extensions</h1>

    <div class="row mb-5">
        @foreach($availableExtensions as $ext)
            <div class="col-sm-12 col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3>{{ $ext['name'] }} <span class="float-right"><a href="{{ route('admin.extensions.show', [$ext['slug']]) }}"><i class="fas fa-cogs"></i> </a></span></h3>
                        <p>{{ \Illuminate\Support\Str::limit($ext['description'], 120) }}...</p>
                    </div>
                </div>
            </div>

        @endforeach

        {!! $availableExtensions->links() !!}
    </div>

    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">Local Extensions</h1>
        </div>

        @foreach($localExtensions as $ext)
            <div class="col-sm-12 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3>{{ $ext['name'] }} <span class="float-right"><a href="{{ route('admin.extensions.show', $ext['slug']) }}"><i class="fas fa-cogs"></i> </a></span></h3>
                        <p>{{ \Illuminate\Support\Str::limit($ext['description'], 120) }}...</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
