{!! \Form::text('name', 'Name') !!}
{!! \Form::text('password', 'Password')->type('password') !!}
{!! \Form::text('email', 'Email Address')->type('email') !!}
{!! \Form::checkbox('email_verified', 'Email Verified', 1, $user->email_verified_at ?? 'null' < (new \Carbon\Carbon())) !!}

<div class="form-group"><label for="inp-roles" class="">Select Roles</label>
    <select name="roles[]" id="inp-roles" multiple class="form-control">
        @foreach(\Spatie\Permission\Models\Role::all() as $role)
            <option value="{{ $role->id }}" @if(isset($user) && $user->hasRole($role)) selected @endif>{{ $role->name }}</option>
        @endforeach
    </select>
</div>
