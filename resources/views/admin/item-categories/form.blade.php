<h2>Item Category Information</h2>
{!! \Form::text('name', 'Name of the item category, eg, robes, swords, wands, guns') !!}
{!! \Form::checkbox('stackable', 'Stackable?', 1) !!}
{!! \Form::checkbox('equippable', 'Equippable?', 1) !!}

{!! \Form::checkbox('consumable', 'Consumable?', 1) !!}

@if(isset($item_category) && $item_category->consumable === "1")
    {!! \Form::text('consumable_uses', 'Consumable Uses')->type('number') !!}
@else
    {!! \Form::text('consumable_uses', 'Consumable Uses')->wrapperAttrs(['class'=>'d-none'])->type('number') !!}
@endif

{!! \Form::checkbox('buyable', 'Buyable?', 1) !!}
@push('scripts')
    <script type="text/javascript">
        (function () {
            $("#inp-consumable").on("click", function () {
                $("#inp-consumable_uses").parent().toggleClass('d-none');
            })
            $("#inp-buyable").on("click", function () {
                $("#inp-cost").parent().toggleClass('d-none');
            });
        })();
    </script>
@endpush


