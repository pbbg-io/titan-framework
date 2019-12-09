

@if($item->child)
    <li id="menuItem-{{$item->id}}" data-menu-id="{{$item->id}}" data-item-id="{{$item->id}}" data-id="{{$item->id}}"><a href="{{ $item->urlOrRoute }}">{{ $item->name }}</a>

        <ol>
            @foreach($item->child as $child)
                @include('titan::partials.nav-item', ['item'=>$child])
            @endforeach
        </ol>
    </li>
@else
    <li id="menuItem-{{$item->id}}" data-menu-id="{{$item->id}}"><a href="{{ $item->urlOrRoute }}">{{ $item->name }}</a></li>

@endif
