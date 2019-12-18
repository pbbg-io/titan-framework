@extends('titan::layouts.admin')
@section('page')
    <h1 class="h3 mb-4 text-gray-800">Current Users
        <span class="float-right"><a href="{{ route('admin.characters.create') }}" class="btn btn-primary">Create new</a> </span></h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Display Name</th>
                        <th>Last Move</th>
                        <th>Area</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Display Name</th>
                        <th>Last Move</th>
                        <th>Area</th>
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
            $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": '{{ route('admin.characters.datatable') }}',
                columns: [
                    {data: 'display_name', name: 'display_name'},
                    {data: 'last_move', name: 'last_move'},
                    {data: 'current_area', name: 'current_area'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action'}
                ]
            });
        })();
    </script>
@endsection
