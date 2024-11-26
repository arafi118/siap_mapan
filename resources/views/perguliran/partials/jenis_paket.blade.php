<div class="col-md-4">
    <label for="status">Tarif meteran</label>
    <div class="input-group mb-3">
        <select class="select2 form-control" name="state" id="select2Single">
            <option value="{{ $package->harga }}">Tarif 1-10 M3</option>
            <option value="{{ $package->harga }}">Tarif >10 M3</option>
        </select>
    </div>
</div>
<div class="col-md-4">
    <label for="status">Biaya Istalasi</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Masukkan Link Koordinate" aria-describedby="basic-addon2"
            readonly value="{{ $package->abodemen }}">
    </div>
</div>
<div class="col-md-4">
    <label for="status">Denda</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Masukkan Link Koordinate" aria-describedby="basic-addon2"
            readonly value="{{ $package->denda }}">
    </div>
</div>
