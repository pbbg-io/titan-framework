<h2>Character Information</h2>
{!! \Form::text('display_name', 'Display Name') !!}
@if(isset($character))
<p>Last Move: {{ $character->last_move }} ({{ $character->last_move->diffForHumans() }})</p>
@endif
<div class="form-group"><label for="inp-roles" class="">Select Area</label>
    <select name="area_id" id="inp-roles" class="form-control">
        @foreach($areas as $index => $area)
            <option value="{{ $area->id }}"
                @if(isset($character) && $character->area_id === $area->id) selected @endif>{{ $area->name }}</option>
        @endforeach
    </select>
</div>
