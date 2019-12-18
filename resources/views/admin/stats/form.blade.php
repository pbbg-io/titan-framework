<h2>Stat Information</h2>
{!! \Form::text('stat', 'Name of the stat') !!}
{!! \Form::textarea('description', 'Description') !!}
{!! \Form::text('default', 'Default value the stat has') !!}

<div class="form-group"><label for="inp-roles" class="">Select Type</label>
    <select name="type" id="type" class="form-control">
        @foreach($types as $type)
            <option value="{{ $type }}"
                @if(isset($stat) && $stat->type === $type) selected @endif>{{ $type }}</option>
        @endforeach
    </select>
</div>


