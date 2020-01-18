@extends('titan::admin.ban.index')

@section('partial')

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Display Name</th>
                    <th>Reason</th>
                    <th>Type</th>
                    <th>Banned Until</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Display Name</th>
                    <th>Reason</th>
                    <th>Type</th>
                    <th>Banned Until</th>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.user_select').select2({
                'minimumInputLength': 2
            });

            $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": '{{ route('admin.banuser.datatable') }}',
                columns: [
                    {data: 'display_name', name: 'display_name'},
                    {data: 'reason', name: 'reason'},
                    {data: 'type', name: 'type'},
                    {data: 'banned_until', name: 'banned_until'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action'}
                ]
            });
        });
    </script>
@endpush
