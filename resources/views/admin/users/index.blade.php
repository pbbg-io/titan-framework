@extends('titan::layouts.admin')
@section('page')
    <h1 class="h3 mb-4 text-gray-800">Current Users
        <span class="float-right"><a href="{{ route('admin.users.create') }}"
                                     class="btn btn-primary">Create new</a> </span></h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Last Move</th>
                        <th>Email Verified At</th>
                        <th>Registered At</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Last Move</th>
                        <th>Email Verified At</th>
                        <th>Registered At</th>
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
        (function () {
            $(document).on("click", ".delete", function (e) {
                if (confirm('Are you sure you want to delete this user?') === true) {
                    window.axios.delete($(this).attr('href'))
                        .then(res => {

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
                "ajax": '{{ route('admin.users.datatable') }}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'last_move', name: 'last_move'},
                    {data: 'email_verified_at', name: 'email_verified_at'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action'}
                ]
            });
        })();
    </script>
@endsection
