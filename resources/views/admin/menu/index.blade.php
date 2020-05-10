@extends('layouts.admin')

@section('page')
    <h1 class="h3 mb-4 text-gray-800">Current Menus
        <span class="float-right"><a href="{{ route('admin.menu.create') }}" class="btn btn-primary">Create new</a> </span></h1>


    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($menus as $menu)
                        <tr>
                            <td class="align-middle">{{ $menu->name }}</td>
                            <td class="align-middle">
                                <a href="{{ route('admin.menu.edit', $menu) }}" class="btn btn-primary">Edit</a>
                                <a href="{{ route('admin.menu.destroy', $menu) }}" class="btn btn-danger delete">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9999">
                                <div class="alert alert-info text-center">There is no data to see</div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (() => {
            $(".delete").on('click', function(e) {
                if(confirm('Are you sure you want to delete this?') === true){
                    window.axios.delete($(this).attr('href'));
                    location.reload();
                }

                e.preventDefault();
            })
        })()
    </script>
@endpush
