@extends('layouts.admin')
@section('page')
    <h1 class="h3 mb-4 text-gray-800">Current Items
        <span class="float-right"><a href="{{ route('admin.items.create') }}" class="btn btn-primary">Create new</a> </span></h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Equippable</th>
                        <th>Consumable</th>
                        <th>Buyable</th>
                        <th>Cost</th>
                        <th>Item Category</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Equippable</th>
                        <th>Consumable</th>
                        <th>Buyable</th>
                        <th>Cost</th>
                        <th>Item Category</th>
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

    <script type="text/javascript">
        (function() {
            $(document).on("click", ".delete", function(e) {
                if(confirm('Are you sure you want to delete this item?') === true){
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
                "ajax": '{{ route('admin.items.datatable') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'equippable', name: 'equippable'},
                    {data: 'consumable', name: 'consumable'},
                    {data: 'buyable', name: 'buyable'},
                    {data: 'cost', name: 'cost'},
                    {data: 'item_category', name: 'item_category'},
                    {data: 'action', name: 'action'}
                ]
            });
        })();
    </script>
@endpush
