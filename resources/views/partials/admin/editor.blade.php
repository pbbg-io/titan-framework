@push('scripts')
    <script>
        $(function() {
            $("#{{ $id }}").summernote({
                height: 300
            })
        })
    </script>
@endpush

<textarea name="{{ $name }}" id="{{ $id }}">{{ $default ?? '' }}</textarea>
