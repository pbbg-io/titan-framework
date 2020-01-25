@extends('titan::admin.ban.index')
@section('partial')
    <div class="card shadow mb-4">
        {!! Form::open()->route('admin.banchar.store')->post() !!}
        <div class="card-body">
            <div class="form-group">
                {!! Form::select('bannable_id', 'Select Character')
                    ->options($chars, 'display_name', 'id')
                    ->help('Select the character to ban')
                     ->attrs(['class' => 'char_select']) !!}
                {!! Form::text('reason', 'Reason for ban')
                    ->help('Enter a reason for banning the user')!!}
                {!! Form::date('ban_until', 'How Long')
                    ->help('When should they be banned until?') !!}
                {!! Form::checkbox('forever', 'Forever') !!}
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            {!! Form::submit("Ban")->danger() !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@push('scripts')
    <script type="application/javascript">
        $('.char_select').select2({
            'minimumInputLength' : 2
        });
    </script>
@endpush
