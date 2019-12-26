<div class="float-right">
    <button class="btn btn-primary" data-click="addStat"><i class="fa fa-plus-circle"></i> Add stat</button>
</div>
<h2 class="mb-4">Add stats to the item</h2>
<div id="stats-list">
    @if(isset($item))
        @foreach($item->stats as $stat)

            <div class="stat-template">

                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="inp-stat_names[]" class="">Stat Name</label>
                            <input class="form-control stat" type="text" name="stat_names[]" id="id-{{ $stat->id }}"
                                   value="{{ $stat->key }}">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="id-{{ $stat->id }}" class="">Stat Default Value</label>
                            <input class="form-control stat" type="text" name="stat_values[]" id="id-{{ $stat->id }}"
                                   value="{{ $stat->value }}">
                        </div>
                    </div>

                    <div class="col-1 d-flex align-items-center">
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <button class="form-control btn btn-danger" data-click="removeStat">
                                <i class="fa fa-times-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    @endif

</div>
<div id="stat-template" class="d-none stat-template">
    <div class="form-row">
        <div class="col">
            {!! \Form::text('stat_names[]', 'Stat Name')->attrs([
            'class' =>  'stat'
        ]) !!}
        </div>
        <div class="col">
            {!! \Form::text('stat_values[]', 'Stat Default Value')->attrs([
            'class' =>  'stat'
        ]) !!}
        </div>

        <div class="col-1 d-flex align-items-center">
            <div class="form-group">
                <label for="">&nbsp;</label>
                <button class="form-control btn btn-danger" data-click="removeStat">
                    <i class="fa fa-times-circle"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        (function () {

            $(document).on("click", "[data-click='addStat']", function (e) {
                addStat();
                e.preventDefault();
            });

            $(document).on("click", "[data-click='removeStat']", function (e) {
                $(this).closest('.stat-template').remove();
                e.preventDefault();
            })

            $("#stats-list").keyup(() => {
                console.log('key');

                let statsList = $("#stats-list");

                let lastInput = $("#stats-list > div:last-of-type input[name='stat_names[]']");

                if (statsList.children().length === 0) {
                    addStat();
                }

                if (lastInput.first().val() !== "") {
                    addStat();
                }
            });
        })();

        function addStat() {

            let statsList = $("#stats-list");
            $("#stat-template").clone().appendTo(statsList).removeClass('d-none').attr('id', '');
        }
    </script>
@endpush
