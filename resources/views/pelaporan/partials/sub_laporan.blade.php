<div class="my-2">
    {{-- @if (isset($keterangan) && !empty($keterangan))
        <label class="form-label" for="keterangan">Keterangan</label>
        <textarea class="form-control" id="keterangan" rows="5" readonly>{{ $keterangan }}</textarea>
    @else --}}
    <label class="form-label" for="sub_laporan">Nama Sub Laporan</label>
    <select class="js-select-2 form-control" name="sub_laporan" id="sub_laporan">
        @foreach ($sub_laporan as $sl)
            <option value="{{ $sl['value'] }}">{{ $sl['title'] }}</option>
        @endforeach
    </select>
    <small class="text-danger" id="msg_sub_laporan"></small>
    {{-- @endif --}}
</div>

{{-- <script>
    $(document).ready(function() {
        $('.js-select-2').select2({
            theme: 'bootstrap4',
        });
    });
</script> --}}
