<form action="/installations/..." method="post" id="Form_status_R">
    @csrf
    @method('PUT')
    <input type="text" name="status" id="status" value="..." hidden>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Bagian Informasi Customer -->
                    <div class="alert alert-success" role="alert">
                        <div class="row">
                            <div class="col-md-2 mb-2">
                                <div class="col-md-3 text-center">
                                    <div class="d-inline-block border border-2 rounded bg-light shadow-sm"
                                        style="width: 120px; height: 120px; padding: 10px; display: flex; align-items: center; justify-content: left;">
                                        ...
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10 mb-2">
                                <h4 class="alert-heading">
                                    <b>Nama Pelanggan: <span id="namaCustomer"></span></b>
                                </h4>
                                <hr>
                                <p class="mb-0">
                                    Dusun <span id="desaInstallation"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel di Bawah Customer -->
                    <div class="mt-4">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th colspan="4">Detail Installation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                        <span style="float: left;">No. Induk</span>
                                        <span class="badge badge-success"
                                            style="float: right; width: 30%; padding: 5px; text-align: center;"
                                            id="kodeInstallation">
                                        </span>
                                    </td>
                                    <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                        <span style="float: left;">Abodemen</span>
                                        <span class="badge badge-success"
                                            style="float: right; width: 30%; padding: 5px; text-align: center;"
                                            id="Abodemen">
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                        <span style="float: left;">Tgl Order</span>
                                        <span class="badge badge-success"
                                            style="float: right; width: 30%; padding: 5px; text-align: center;"
                                            id="tanggalOrder">
                                        </span>
                                    </td>
                                    <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                        <span style="float: left;">Status</span>
                                        <span class="badge badge-success"
                                            style="float: right; width: 30%; padding: 5px; text-align: center;"
                                            id="statusInstallation">
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                        <span style="float: left;">Paket Instalasi</span>
                                        <span class="badge badge-success"
                                            style="float: right; width: 30%; padding: 5px; text-align: center;"
                                            id="paketInstalasi">
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="alert alert-light" role="alert">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="kode_instalasi">Kode Instalasi</label>
                                    <input type="text" class="form-control date" name="kode_instalasi"
                                        id="kode_instalasi" value="" disabled>
                                    <small class="text-danger" id="msg_kode_instalasi"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="pasang">Tanggal Pasang</label>
                                    <input type="text" class="form-control date" name="pasang" id="pasang"
                                        value="{{ date('d/m/Y') }}">
                                    <small class="text-danger" id="msg_pasang"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="biaya_instalasi">Jumlah Pembayaran</label>
                                    <input type="text" class="form-control" name="biaya_instalasi"
                                        id="biaya_instalasi" value="" disabled>
                                    <small class="text-danger" id="msg_biaya_instalasi"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-end align-items-center gap-2">
                        <button id="cetakBrcode" class="btn btn-danger btn-icon-split" target="_blank">
                            <span class="icon text-white-50 d-none d-lg-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-receipt" viewBox="0 0 16 16">
                                    <path
                                        d="M1.92.5a.5.5 0 0 0-.5.5v14a.5.5 0 0 0 .76.429L3 14.5l1.32.929a.5.5 0 0 0 .56 0L6.2 14.5l1.32.929a.5.5 0 0 0 .56 0L9.4 14.5l1.32.929a.5.5 0 0 0 .56 0L12.6 14.5l1.32.929a.5.5 0 0 0 .76-.429V1a.5.5 0 0 0-.5-.5H1.92z" />
                                    <path
                                        d="M2.5 3.5a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                                </svg>
                            </span>
                            <span class="text">Cetak</span>
                        </button>

                        <button id="kembali" class="btn btn-light btn-icon-split kembali"
                            style="float: right; margin-left: 10px;">
                            <span class="icon text-white-50 d-none d-lg-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-sign-turn-slight-left-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM6.864 8.368a.25.25 0 0 1-.451-.039l-1.06-2.882a.25.25 0 0 1 .192-.333l3.026-.523a.25.25 0 0 1 .26.371l-.667 1.154.621.373A2.5 2.5 0 0 1 10 8.632V11H9V8.632a1.5 1.5 0 0 0-.728-1.286l-.607-.364-.8 1.386Z" />
                                </svg>
                            </span>
                            <span class="text">Kembali</span>
                        </button>
                        <button class="btn btn-secondary btn-icon-split" type="submit" id="Simpan_status_R"
                            style="float: right; margin-left: 10px;">
                            <span class="icon text-white-50 d-none d-lg-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                </svg>
                            </span>
                            <span class="text" style="float: right;">Pemasangan Selesai</span>
                        </button>
                        <button class="btn btn-secondary btn-icon-split" type="submit" id="Simpan_status_R"
                            style="float: right; margin-left: 10px;">
                            <span class="icon text-white-50 d-none d-lg-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                </svg>
                            </span>
                            <span class="text" style="float: right;">Pemasangan Selesai</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
