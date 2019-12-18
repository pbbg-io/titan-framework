<h2>Character Stats</h2>
@foreach($stats as $stat)

    @php
        $name = \Str::title($stat->stat);
        $id = $stat->id ?? '';

        if(isset($character))
        $value = $character->stats->where('stat_id', $stat->id)->first()->value ?? $stat->default;
        else
        $value = $stat->default;

    @endphp

    @switch($stat->type)
        @case('boolean')
        {!! \Form::checkbox('stats['.$id.']', $name, 1, $value) !!}
        @break
        @case('string')
        {!! \Form::text('stats['.$id.']', $name, $value) !!}
        @break
        @case('text')
        {!! \Form::checkbox('stats['.$id.']', $name, $value) !!}

        @break
        @case('integer')
        {!! \Form::text('stats['.$id.']', $name, $value) !!}
        @break
        @case('float')
        {!! \Form::checkbox('stats['.$id.']', $name, $value) !!}
        @break
    @endswitch

@endforeach
