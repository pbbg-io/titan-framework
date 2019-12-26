@extends('titan::layouts.admin')

@section('page')
    <h1 class="h3 mb-4 text-gray-800">Edit Menu <a href="{{ route('admin.menu.destroy', $menu) }}"
                                                   class="btn btn-danger delete-button">Delete</a></h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            {!! \Form::open()->route('admin.menu.update', [$menu])->fill($menu)->put() !!}
            @include('titan::admin.menu.form')
            {!! \Form::submit('Update Menu') !!}
            {!! \Form::close() !!}
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    {!! \Form::open()->formInline() !!}
                    {!! \Form::text('link_name')->placeholder('Name... eg Home')->id('itemName') !!}
                    {!! \Form::text('link_route')->placeholder('Link... eg https://google.com')->id('itemLink') !!}
                    {!! \Form::submit('Add Link')->attrs(['id'=>'addItem']) !!}
                    {!! \Form::close() !!}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <ol class="list-unstyled sortable">
                        @foreach($menu->items as $menuItem)
                            @if($menuItem->parent_id === null)
                                @include('titan::partials.admin.nav-item', ['item'=>$menuItem])
                            @endif
                        @endforeach
                    </ol>

                    {!! \Form::open()->route('admin.menu.sort', [$menu])->put() !!}
                    {!! \Form::submit('Update Ordering & Deletions')->attrs(['class'=>'save']) !!}
                    {!! \Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">

        let hasChanges = false,
            ns = null;

        function setup() {

            ns = $('.sortable').nestedSortable({
                forcePlaceholderSize: true,
                // handle: 'div',
                // helper:	'clone',
                items: 'li',
                opacity: .6,
                placeholder: 'placeholder',
                revert: 250,
                tabSize: 25,
                tolerance: 'pointer',
                // toleranceElement: '> div',
                maxLevels: 4,
                isTree: true,
                expandOnHover: 700,
                startCollapsed: false,
                excludeRoot: true
            });
        }

        setup();

        $(".save").click(function (e) {
            let menu = ns.nestedSortable('toArray', {startDepthCount: 0});
            window.axios.put('{{route('admin.menu.sort', [$menu])}}', {
                menu
            })
                .then(function (res) {
                    hasChanges = false;
                    alert('Your changes have been saved')
                }).catch(function (err) {
                console.error(err);
            })
            e.preventDefault();
        });

        ns.on('sort', function (e) {
            hasChanges = true;
        });

        window.addEventListener('beforeunload', function (event) {
            if (hasChanges === true) {
                event.preventDefault();
                // Chrome requires returnValue to be set.
                event.returnValue = 'You have unsaved changes';
                return 'You have unsaved changes';
            }
        });

        $(document).on('click', ".remove-item", function (e) {
            $(this).parent().remove();

            hasChanges = true;

            e.preventDefault()
        });

        $(".delete-button").on('click', function (e) {
            e.preventDefault();

            window.axios.delete('{{ route('admin.menu.destroy', $menu) }}')
                .then(res => {
                    console.log(res);
                    window.location = '{{ route('admin.menu.index') }}';
                }).catch(err => {
                console.log(err)
            });

            return false;
        });

        $("#addItem").click(function (e) {
            e.preventDefault();

            let itemLink = $("input#itemLink").val(),
                itemName = $("input#itemName").val();

            window.axios.post('{{ route('admin.menu.add', [$menu]) }}', {
                itemLink, itemName
            })
                .then(function (res) {
                    let data = res.data;
                    $(this).parent().find("input[type=text], textarea").val("");

                    let template = `<li id="menuItem-${data.id}" data-menu-id="${data.id}"><a href="">${data.name}</a></li>`;

                    $(".sortable").append(template);

                    setup()

                })
                .catch(function (err) {
                    console.log(err.response.status);
                    console.log(err.response.data);

                    if (err.response.status === 422) {

                        let messages = err.response.data.errors,
                            message = '';

                        console.log(messages.length, Object.keys(messages).length);

                        for (let i in messages) {
                            message += messages[i][0] + '\n\r'
                        }
                        // for(let i=0;i<Object.keys(messages).length;i++)
                        // {
                        //     console.log(messages[i], 'emssage');
                        //     message += messages[i]
                        // }

                        console.log(message)
                        alert(message);
                    }
                });

        })
    </script>
@endpush
