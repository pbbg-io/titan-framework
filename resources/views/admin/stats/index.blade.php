@extends('titan::layouts.admin')
@section('page')
    <h1 class="h3 mb-4 text-gray-800">Current Stats
        <span class="float-right"><a href="{{ route('admin.stats.create') }}" class="btn btn-primary">Create new</a> </span></h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Stat</th>
                        <th>Type</th>
                        <th>Default</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Stat</th>
                        <th>Type</th>
                        <th>Default</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script type="text/javascript">
        (function() {
            $(document).on("click", ".delete", function(e) {
                if(confirm('Are you sure you want to delete this stat?') === true){
                    window.axios.delete($(this).attr('href'))
                        .then(() => {
                            location.reload();
                        })
                        .catch(err => {
                            alert(err.response.data.message);
                        });
                }

                e.preventDefault();
            });
            $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": '{{ route('admin.stats.datatable') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'stat', name: 'stat'},
                    {data: 'type', name: 'type'},
                    {data: 'default', name: 'default'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action'}
                ]
            });
        })();
    </script>
@endsection
