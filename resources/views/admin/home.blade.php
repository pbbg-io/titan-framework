@extends('titan::layouts.admin')

@section('page')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Admin Home Page</h1>

    <div class="row">
        <div class="col-sm-12 col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Players Online</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['players_online'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Players</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['players'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Registrations Today</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['players_registered_today'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                <div class="col-sm-12 col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Version Check</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        @if($stats['version_update'])
                                            {{ $stats['current_version'] }} - Latest: {{ $stats['latest_version'] }}
                                        @else
                                            {{ $stats['current_version'] }}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-auto">
                                    @if($stats['version_update'])
                                        <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                                    @else
                                        <i class="fas fa-check fa-2x text-success"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>


@endsection
