{!! Form::hidden('bannable_id', $banned->bannable->id) !!}
{!! Form::text('reason', 'Reason for ban')
    ->help('Enter a reason for banning the user')!!}
{!! Form::date('ban_until', 'How Long')
    ->help('When should they be banned until?') !!}
{!! Form::checkbox('forever', 'Forever')
    ->checked($banned->forever == 1) !!}

