<style>
    .equal-height {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .camera-wrapper {
        position: relative;
        width: 100%;
        height: 100px;
        border-radius: 10px;
        overflow: hidden;
        background: #868686;
    }

    .camera-wrapper video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .scanner-frame {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 60%;
        height: 30%;
        transform: translate(-50%, -50%);
        border: 2px solid #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 10px #ffffff;
        z-index: 2;
    }

    .scanner-line {
        position: absolute;
        top: 0;
        left: 50%;
        width: 60%;
        height: 2px;
        background: rgba(255, 255, 255, 0.8);
        transform: translateX(-50%);
        animation: scanMove 2s infinite;
        z-index: 3;
    }

    @keyframes scanMove {
        0% {
            top: 25%;
        }

        50% {
            top: 55%;
        }

        100% {
            top: 25%;
        }
    }

    .dark-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1;
    }
</style>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width: 500px;">
        <div class="modal-content p-2">
            <div class="modal-body">
                <!-- PELANGGAN -->
                {{-- <div class="mb-3">
                    <div class="card border-success mb-2">
                        <div class="card-body py-2 px-3 text-white" style="background-color: #868686;">
                            <h6 class="mb-0">PELANGGAN</h6>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-2 d-flex">
                                <div style="width: 100px;">Nama</div>
                                <div>: <span class="namaCustomer"></span></div>
                            </div>
                            <hr class="my-2">
                            <div class="mb-2 d-flex">
                                <div style="width: 100px;">NIK</div>
                                <div>: <span class="NikCustomer"></span></div>
                            </div>
                            <hr class="my-2">
                            <div class="mb-2 d-flex">
                                <div style="width: 100px;">Alamat</div>
                                <div>: <span class="AlamatCustomer"></span></div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- INSTALASI -->
                <div class="mb-3">
                    <div class="card border-success mb-2">
                        <div class="card-body py-2 px-3 text-white" style="background-color: #868686;">
                            <h6 class="mb-0">INSTALASI</h6>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-2 d-flex">
                                <div style="width: 120px;">No. Induk</div>
                                <div>: <span class="KdInstallasi"></span></div>
                            </div>
                            <hr class="my-2">
                            <div class="mb-2 d-flex">
                                <div style="width: 120px;">Nama</div>
                                <div>: <span class="namaCustomer"></span></div>
                            </div>
                            <hr class="my-2">
                            <div class="mb-2 d-flex">
                                <div style="width: 120px;">Alamat</div>
                                <div>: <span class="AlamatInstallasi"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Input Meter & Scan -->
                <div class="row mt-3">
                    <div class="col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="form-group mb-2">
                                    <label for="awal">Meter Awal</label>
                                    <input type="text" class="form-control AkhirUsage input-nilai-awal"
                                        name="awal_" id="awal_" placeholder="Awal Pemakaian" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="akhir">Meter Akhir</label>
                                    <input type="text" class="form-control AkhirUsage input-nilai-akhir"
                                        name="akhir_" id="akhir_" placeholder="Akhir Pemakaian">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-center mb-2">
                                    <div style="max-width: 320px; width: 100%; margin: 0 auto;">
                                        <canvas id="tmpImage" style="display: none;"></canvas>
                                        <canvas id="previewImage" style="display: none;"></canvas>

                                        <div class="camera-wrapper">
                                            <video id="scanMeter" autoplay playsinline></video>

                                            <!-- Lapisan gelap sekeliling area scan -->
                                            <div class="dark-overlay"></div>

                                            <!-- Frame area scan -->
                                            <div class="scanner-frame"></div>

                                            <!-- Garis animasi -->
                                            <div class="scanner-line"></div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="btnScanMeter" class="btn btn-info w-100">Scan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-2">
                <input type="hidden" id="tgl_akhir" class="TglAkhirUsage">
                <input type="hidden" id="tgl_pemakaian" class="PemakaianUsage">
                <input type="hidden" name="customer" class="customer" id="customer">
                <input type="hidden" name="jumlah_" class="jumlah_" id="jumlah_">
                <input type="hidden" name="id_instalasi" class="id_instalasi" id="id_instalasi">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Kembali</button>
                <button type="button" id="SimpanPemakaian" class="btn btn-warning">Simpan Pemakaian</button>
            </div>
        </div>
    </div>
</div>
<script>
    //tanggal
    jQuery.datetimepicker.setLocale('de');
    $('.date').datetimepicker({
        i18n: {
            de: {
                months: [
                    'Januar', 'Februar', 'März', 'April',
                    'Mai', 'Juni', 'Juli', 'August',
                    'September', 'Oktober', 'November', 'Dezember',
                ],
                dayOfWeek: [
                    "So.", "Mo", "Di", "Mi",
                    "Do", "Fr", "Sa.",
                ]
            }
        },
        timepicker: false,
        format: 'd/m/Y'
    });
</script>
