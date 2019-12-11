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
                                <a href="{{ route('admin.cronjobs.edit', $job) }}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i> Edit</a>
                                <a href="{{ route('admin.cronjobs.destroy', $job) }}" class="btn btn-danger delete"><i class="fas fa-times"></i> Delete</a>
                                <a href="{{ route('admin.cronjobs.run') }}" class="btn btn-info float-right" data-run="{{ $job->command }}"><i class="fas fa-sync"></i> Run Now</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="999">
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
            });

            $("[data-run]").on('click', function(e) {
                $(this).find("i").addClass('fa-spin');
                window.axios.post($(this).attr('href'), {
                    command: $(this).attr('data-run')
                })
                .then(res => {
                    console.log(res.data);
                    alert("Cronjob successfully ran, output given: " + res.data);
                })
                .finally(res => {
                    $(this).find("i").removeClass('fa-spin');
                });

                e.preventDefault();
            })
        })()
    </script>
@endsection
