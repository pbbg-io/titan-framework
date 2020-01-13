<h2>Item Category Information</h2>
{!! \Form::text('name', 'Name of the item category, eg, robes, swords, wands, guns') !!}
<div class="form-group">
    <label for="inp-roles" class="">Parent Category</label>
    <select name="parent_id" id="type" class="form-control">
        <option value="">Select an optional parent category</option>
        @foreach($item_categories as $cat)
            <option value="{{ $cat->id }}"
                    @if(isset($item_category) && $item_category->id === $cat->parent_id) selected @endif>{{ $cat->name }}</option>
        @endforeach
    </select>
</div>

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


