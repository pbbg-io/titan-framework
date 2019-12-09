@php
    $menu = resolve('menu')->where('name', $nav)->first();


@endphp
@if($menu)
@foreach($menu->items as $menuItem)
    @if($menuItem->parent_id === null)
        <ul>
            @include('titan::partials.nav-item', ['item'=>$menuItem])
        </ul>
    @endif
@endforeach
@endif
