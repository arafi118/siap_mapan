<div class="card-body">
    <form action="/pengaturan/sop/pasang_baru" method="post" id="Fromswit">
        @csrf

        <div class="row">
            <div class="col-md-4">
                <div class="position-relative mb-3">
                    <label for="pasang_baru">Biaya pasang baru</label>
                    <input type="text" class="form-control" id="pasang_baru" name="pasang_baru" placeholder="Rp."
                        value="{{ number_format($tampil_settings->pasang_baru, 2) }}">
                    <small class="text-danger" id="msg_pasang_baru"></small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="position-relative mb-3">
                    <label for="abodemen">Abodemen</label>
                    <input type="text" class="form-control" id="abodemen" name="abodemen" placeholder="Rp."
                        value="{{ number_format($tampil_settings->abodemen, 2) }}">
                    <small class="text-danger" id="msg_abodemen"></small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="position-relative mb-3">
                    <label for="denda">Denda</label>
                    <input type="text" class="form-control" id="denda" name="denda" placeholder="Rp."
                        value="{{ number_format($tampil_settings->denda, 2) }}">
                    <small class="text-danger" id="msg_denda"></small>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Swit Tombol Reg.Instalasi</label>
            <div class="custom-control custom-checkbox">
                <input type="radio" class="custom-control-input" id="swit_tombol_1" name="swit_tombol" value="1"
                    {{ isset($tampil_settings) && $tampil_settings->swit_tombol == 1 ? 'checked' : '' }}>
                <label class="custom-control-label" for="swit_tombol_1">A. wajib Lunas</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input type="radio" class="custom-control-input" id="swit_tombol_2" name="swit_tombol" value="2"
                    {{ isset($tampil_settings) && $tampil_settings->swit_tombol == 2 ? 'checked' : '' }}>
                <label class="custom-control-label" for="swit_tombol_2">B. tidak Wajib Lunas</label>
            </div>
        </div>
        <hr>
        <p>Pilih A/B Jenis Pemasangan Meter Baru.</p>
        <div class="col-12 d-flex justify-content-end">
            <button class="btn btn-dark btn-icon-split" type="button" id="SimpanSwit" class="btn btn-dark"
                style="float: right; margin-left: 20px;">
                <span class="text" style="float: right;">Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>
