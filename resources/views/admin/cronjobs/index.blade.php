@extends('titan::layouts.admin')

@section('page')
    <h1 class="h3 mb-4 text-gray-800">Current Cronjobs</h1>


    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Command</th>
                        <th>Expression</th>
                        <th>Enabled</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($jobs as $job)
                        <tr>
                            <td class="align-middle">{{ $job->command }}</td>
                            <td class="align-middle">{{ $job->cron }}</td>
                            <td class="align-middle">{{ $job->enabled ? 'True' : 'False' }}</td>
                            <td class="align-middle"><a href="{{ route('admin.cronjobs.edit', $job) }}" class="btn btn-primary">Edit</a> </td>
                        </tr>
                    @empty
                        <tr>
                            <td rowspan="999">
                                <div class="alert alert-info">There are no scheduled jobs</div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
