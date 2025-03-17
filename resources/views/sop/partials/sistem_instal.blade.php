<div class="card-body">
    <form action="/pengaturan/sop/sistem_instal" method="post" id="FromInstal">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="position-relative mb-3">
                    <label for="batas_tagihan">Batas Tagihan Bulanan Aktif.</label>
                    <input type="number" class="form-control" id="batas_tagihan" name="batas_tagihan"
                        placeholder="3 bulan" value="{{ $tampil_settings->batas_tagihan }}">
                    <small class="text-danger" id="msg_batas_tagihan"></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Swit Tombol Trx.Tagihan</label>
                    <div class="custom-control custom-checkbox">
                        <input type="radio" class="custom-control-input" id="swit_tombol_trx_1" name="swit_tombol_trx"
                            value="1"
                            {{ isset($tampil_settings) && $tampil_settings->swit_tombol_trx == 1 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="swit_tombol_trx_1">A. wajib Lunas</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="radio" class="custom-control-input" id="swit_tombol_trx_2" name="swit_tombol_trx"
                            value="2"
                            {{ isset($tampil_settings) && $tampil_settings->swit_tombol_trx == 2 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="swit_tombol_trx_2">B. tidak Wajib Lunas</label>
                    </div>
                </div>
            </div>

        </div>
        <hr>
        <p style="text-align: justify;">
            Jika ada data tagihan dengan Status <b>AKTIF</b> dan melebihi batas tagihan yang ditentukan, maka Aplikasi
            akan secara otomatis memindahkan data tersebut ke Status <b>BLOKIR</b> sesuai batas yang sudah ditentukan.
        </p>
        <div class="col-12 d-flex justify-content-end">
            <button class="btn btn-dark btn-icon-split" type="button" id="SimpanInstal" class="btn btn-dark"
                style="float: right; margin-left: 20px;">
                <span class="text" style="float: right;">Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>
