<div class="my-2">
    <label class="form-label" for="sub_laporan">Nama Sub Laporan</label>
    <select class="js-select-2 form-control" name="sub_laporan" id="sub_laporan">
        @foreach ($sub_laporan as $sl)
            <option value="{{ $sl['value'] }}">{{ $sl['title'] }}</option>
        @endforeach
    </select>
    <small class="text-danger" id="msg_sub_laporan"></small>
</div>
<script>
    $(document).ready(function() {
        $('.js-select-2').select2({
            theme: 'bootstrap4',
        });
    });
</script>
