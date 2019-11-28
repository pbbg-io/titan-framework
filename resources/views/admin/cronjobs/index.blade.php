@extends('titan::layouts.admin')

@section('page')
    <h1 class="h3 mb-4 text-gray-800">Current Cronjobs
        <span class="float-right"><a href="{{ route('admin.cronjobs.create') }}" class="btn btn-primary">Create new</a> </span></h1>


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
                            <td class="align-middle">
                                <a href="{{ route('admin.cronjobs.edit', $job) }}" class="btn btn-primary">Edit</a>
                                <a href="{{ route('admin.cronjobs.destroy', $job) }}" class="btn btn-danger delete">Delete</a>
                            </td>
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

@section('scripts')
    <script>
        (() => {
            $(".delete").on('click', function(e) {
                if(confirm('Are you sure you want to delete this cronjob?') === true){
                    window.axios.delete($(this).attr('href'));
                    location.reload();
                }

                e.preventDefault();
            })
        })()
    </script>
@endsection
