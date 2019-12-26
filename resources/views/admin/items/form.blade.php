<h2>Item Information</h2>
{!! \Form::text('name', 'Name of the item') !!}
{!! \Form::textarea('description', 'Description') !!}
{!! \Form::checkbox('stackable', 'Stackable?', 1) !!}
{!! \Form::checkbox('equippable', 'Equippable?', 1) !!}

{!! \Form::checkbox('consumable', 'Consumable?', 1) !!}
@if(isset($item) && $item->consumable === "1")
    {!! \Form::text('consumable_uses', 'Consumable Uses')->type('number') !!}
@else
    {!! \Form::text('consumable_uses', 'Consumable Uses')->wrapperAttrs(['class'=>'d-none'])->type('number') !!}
@endif

{!! \Form::checkbox('buyable', 'Buyable?', 1) !!}
@if(isset($item) && $item->buyable === "1")
    {!! \Form::text('cost', 'Cost')->type('number') !!}
@else
    {!! \Form::text('cost', 'Cost')->type('number')->wrapperAttrs(['class'=>'d-none']) !!}
@endif

<div class="form-group"><label for="inp-roles" class="">Select Category</label>
    <select name="item_category_id" id="item_category_id"
            class="form-control @if($errors->has('item_category_id')) is-invalid @elseif(count($errors->messages()) > 0 && !$errors->has('item_category_id')) is-valid @endif">
        <option value="">-------</option>
        @foreach($item_categories as $category)
            <option value="{{ $category->id }}"
                    @if(old('category_id', isset($item) && $item->item_category_id === $category->id)) selected @endif>{{ $category->name }}</option>
        @endforeach
    </select>
    @if($errors->has('item_category_id'))
        <div class="invalid-feedback">
            Please select a valid category.
        </div>
    @endif
</div>

{{--@dump($item)--}}

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


