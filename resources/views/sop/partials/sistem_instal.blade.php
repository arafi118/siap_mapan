<div class="card-body">
    <form action="/pengaturan/sop/sistem_instal" method="post" id="FromInstal">
        @csrf
        <div class="row">
            <div class="col-md-8">

                <div class="position-relative mb-3 d-md-flex flex-column flex-md-row align-items-md-center">
                    <label for="abodemen" class="me-md-3 mb-2 mb-md-0" style="min-width: 200px;">Abodemen</label>
                    <input type="text" class="form-control" id="abodemen" name="abodemen" placeholder="Rp."
                        value="{{ number_format($tampil_settings->abodemen, 2) }}">
                </div>
                <small class="text-danger" id="msg_abodemen"></small>

                <div class="position-relative mb-3 d-md-flex flex-column flex-md-row align-items-md-center">
                    <label for="denda" class="me-md-3 mb-2 mb-md-0" style="min-width: 200px;">Denda
                        Keterlambatan</label>
                    <input type="text" class="form-control" id="denda" name="denda" placeholder="Rp."
                        value="{{ number_format($tampil_settings->denda, 2) }}">
                </div>
                <small class="text-danger" id="msg_denda"></small>

                <div class="position-relative mb-3 d-md-flex flex-column flex-md-row align-items-md-center">
                    <label for="batas_tagihan" class="me-md-3 mb-2 mb-md-0" style="min-width: 200px;">Toleransi
                        Menunggak</label>
                    <input type="number" class="form-control" id="batas_tagihan" name="batas_tagihan"
                        placeholder="3 bulan" value="{{ $tampil_settings->batas_tagihan }}">
                </div>
                <small class="text-danger" id="msg_batas_tagihan"></small>

            </div>

            <div class="col-md-4">
                <div class="position-relative mb-3">
                    <label for="tanggal_toleransi " class="mb-1">Batas Tagihan Bulanan</label>
                    <input type="number" class="form-control" id="tanggal_toleransi " placeholder="Setiap Tanggal"
                        name="tanggal_toleransi " value="{{ $tampil_settings->tanggal_toleransi }}">

                    <small class="text-danger" id="msg_tanggal_toleransi"></small>
                </div>

                <div class="position-relative mb-3">
                    <label for="biaya_aktivasi" class="mb-1">Biaya Aktivasi Ulang</label>
                    <input type="text" class="form-control" id="biaya_aktivasi" name="biaya_aktivasi"
                        placeholder="Rp." value="{{ number_format($tampil_settings->biaya_aktivasi, 2) }}">
                    <small class="text-danger" id="msg_biaya_aktivasi"></small>
                </div>
            </div>

        </div>
        <hr>
        <p style="text-align: justify;">
            Apabila Instalasi dengan Status <b>AKTIF</b> memiliki tagihan menunggakan sesuai angka diatas, maka aplikasi
            pamsimas secara otomatis merubah status Instalasi menjadi status <b>BLOKIR</b> dan sekaligus menjadi
            perintah untuk dilakukan penutupan air sementara sampai dengan dilakukan pembayaran tunggakan ditambah biaya
            aktivasi ulang.</p>
        <div class="col-12 d-flex justify-content-end">
            <button class="btn btn-dark btn-icon-split" type="button" id="SimpanInstal" class="btn btn-dark"
                style="float: right; margin-left: 20px;">
                <span class="text" style="float: right;">Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>
