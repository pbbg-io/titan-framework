@extends('titan::layouts.admin')
@section('page')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Users</h6>
        </div>
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
        (function() {
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
