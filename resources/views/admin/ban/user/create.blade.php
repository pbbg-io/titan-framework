@extends('titan::admin.ban.index')
@section('partial')
    <div class="card shadow mb-4">
        {!! Form::open()->route('admin.banuser.store')->post() !!}
        <div class="card-body">
            <div class="form-group">

                @include('titan::admin.ban.ban_create_form')

            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            {!! Form::submit("Ban")->danger() !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@push('scripts')
    <script type="application/javascript">
        $('.user_select').select2({
            'minimumInputLength' : 2
        });
    </script>
@endpush
