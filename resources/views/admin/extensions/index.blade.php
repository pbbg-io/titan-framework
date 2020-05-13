@extends('layouts.admin')

@section('page')
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">Extensions</h1>
        </div>
    </div>

    @php

        function currentFilter($filter, $option)
        {
            $filters = [];

            foreach(request()->query() as $param => $value)
                {
                    $filters[$param] = $value;
                }

            $filters[$filter['param']] = $option;

            return $filters;
        }

        function isActive($filter, $option)
        {
            foreach(request()->query() as $param => $value)
            {
                if($param === $filter['param'] && $value === $option)
                    echo 'active';
            }
        }

    @endphp

    <div class="row">
        <div class="col-sm-12 col-md-3">
            <h4 class="mb-4">Filters</h4>

            @foreach($filters as $filter)

                <div class="card mb-4">
                    <div class="card-body">
                        <h5>{{ $filter['filter_name'] }}</h5>
                        <ul class="list-unstyled nav nav-pills flex-column">
                            @foreach($filter['options'] as $option => $value)
                                <li class="nav-item">
                                    <a href="{{ route('admin.extensions.index', currentFilter($filter, $option)) }}"
                                       class="nav-link {{ isActive($filter, $option) }}">{{ $value }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            @endforeach
        </div>
        <div class="col-sm-12 col-md-9">
            <div class="row">
                @forelse($extensions as $ext)
                    <div class="col-sm-12 col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h3>{{ $ext['name'] }} <span class="float-right"><a
                                            href="{{ route('admin.extensions.show', $ext['slug']) }}"><i
                                                class="fas fa-cogs"></i> </a></span></h3>
                                <p>{{ \Illuminate\Support\Str::limit($ext['description'], 120) }}...</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <p>
                                        <i class="fas fa-filter"></i> No results found
                                    </p>

                                    @if(count(request()->query()) > 0)
                                        Please check your filters
                                    @else
                                        It doesn't look like you have any extensions yet
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="row">
                <div class="col-sm-12">
                    {!! $extensions->appends(request()->query())->links() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
