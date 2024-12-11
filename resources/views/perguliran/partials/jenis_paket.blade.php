@php
    $blok = json_decode($tampil_settings->block, true);
    $jumlah_blok = count($blok);
    $harga = json_decode($package->harga, true);
@endphp

@for ($i = 0; $i < $jumlah_blok; $i++)
    <div class="col-{{ 12 / $jumlah_blok }}">
        <div class="position-relative mb-2">
            <label for="tarif" class="form-label">{{ $blok[$i]['nama'] }} .[ {{ $blok[$i]['jarak'] }} ]
            </label>
            <input autocomplete="off" maxlength="16" type="text" class="form-control form-control-sm block"
                value="{{ number_format(isset($harga[$i]) ? $harga[$i] : '0', 2) }}" readonly>
            <small class="text-danger"></small>
        </div>
    </div>
@endfor

<div class="col-md-6">
    <label for="biaya">Biaya Istalasi</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="biaya" id="biaya" aria-describedby="basic-addon2"
            readonly value="{{ number_format($package->abodemen, 2) }}">
    </div>
</div>
<div class="col-md-6">
    <label for="denda">Denda</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control"aria-describedby="basic-addon2" readonly
            value="{{ number_format($package->denda, 2) }}">
    </div>
</div>
@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endsection
