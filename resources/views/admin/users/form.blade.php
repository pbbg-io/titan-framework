{!! \Form::text('name', 'Name') !!}
{!! \Form::text('password', 'Password')->type('password') !!}
{!! \Form::text('email', 'Email Address')->type('email') !!}
{!! \Form::checkbox('email_verified', 'Email Verified', 1, $user->email_verified_at ?? 'null' < (new \Carbon\Carbon())) !!}
