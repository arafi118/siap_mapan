<div class="col-md-4">
    <label for="tarif">Tarif meteran</label>
    <div class="input-group mb-3">
        <select class="select2 form-control" name="tarif" id="tarif">
            <option value="{{ $package->harga }}">Tarif 1-10 M3 [ Rp. {{ number_format($package->harga, 2) }} ]
            </option>
            <option value="{{ $package->harga1 }}">Tarif >10 M3 [ Rp. {{ number_format($package->harga1, 2) }} ]
            </option>
        </select>
    </div>
</div>
<div class="col-md-4">
    <label for="biaya">Biaya Istalasi</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="biaya" id="biaya" aria-describedby="basic-addon2" readonly
            value="{{ number_format($package->abodemen, 2) }}">

    </div>
</div>
<div class="col-md-4">
    <label for="denda">Denda</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="denda" id="denda" aria-describedby="basic-addon2" readonly
            value="{{ number_format($package->denda, 2) }}">
    </div>
</div>
@section('script')
<script>
    $(document).ready(function () {
        $('.select2').select2({
            theme: 'bootstrap4',
        });
    });

</script>
@endsection
