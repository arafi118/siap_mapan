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
