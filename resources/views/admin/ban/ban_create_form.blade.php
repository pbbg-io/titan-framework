{!! Form::select('bannable_id', 'Select User')
                    ->options($playable, 'name', 'id')
                    ->help('Select the user to ban')
                     ->attrs(['class' => 'user_select']) !!}
{!! Form::text('reason', 'Reason for ban')
    ->help('Enter a reason for banning the user')!!}
{!! Form::date('ban_until', 'How Long')
    ->help('When should they be banned until?') !!}
{!! Form::checkbox('forever', 'Forever') !!}
