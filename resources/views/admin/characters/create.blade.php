@extends('titan::layouts.admin')

@section('page')
    {!! \Form::open()->route('admin.characters.store') !!}
    <div class="row">
        <div class="col-sm-12 col-lg-8 mb-4">

            <h1 class="h3 mb-4 text-gray-800">Create Character</h1>


            <div class="card shadow mb-4">
                <div class="card-body">
                    @include('titan::admin.characters.form')
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    @include('titan::admin.characters.form_stats')
                </div>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    {!! \Form::submit('Create Character') !!}
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h1 class="h3 mb-4 text-gray-800">Attach to user</h1>
                    <select class="user-list" data-placeholder="Search for user" name="user_id"></select>
                </div>
            </div>
        </div>
    </div>
    {!! \Form::close() !!}
@endsection

@section('scripts')
    <script type="text/javascript">
        $('.user-list').select2({
            ajax: {
                url: '{{ route('admin.users.list') }}',
                dataType: 'json'
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            processResults: function(data) {
                return data.items;
            },
            width: 'style',
            placeholder: $(this).attr('placeholder'),
            theme: 'bootstrap4',
        });
    </script>
@endsection
