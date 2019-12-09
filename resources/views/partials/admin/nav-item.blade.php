
@if($item->child->count() > 0)
    <li id="menuItem-{{$item->id}}" data-menu-id="{{$item->id}}" data-item-id="{{$item->id}}" data-id="{{$item->id}}"><a href="">{{ $item->name }}</a> <a href="#" class="remove-item text-danger"><i class="fas fa-times-circle"></i></a>
        <ol>
            @foreach($item->child as $child)
                @include('titan::partials.admin.nav-item', ['item'=>$child])
            @endforeach
        </ol>
    </li>
@else
    <li id="menuItem-{{$item->id}}" data-menu-id="{{$item->id}}"><a href="">{{ $item->name }}</a> <a href="#" class="remove-item text-danger"><i class="fas fa-times-circle"></i></a> </li>
@endif
