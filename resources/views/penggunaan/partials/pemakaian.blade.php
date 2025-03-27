<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-2">
            <div class="card p-2">
                <div class="modal-body">
                    <div class="d-flex align-items-center mb-2">
                        <img src="../../assets/img/userr.png" alt="Logo" class="logo-img mr-2  d-none d-lg-block"
                            style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 3px solid rgb(224, 224, 224);">
                        <div class="ms-3">
                            <table id="tableCard" class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td width="50%"></td>
                                    <td width="5%" colspan="2" align="center">
                                        <h4 class="mb-1 namaCustomer"></h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%">
                                        No NIK</td>
                                    <td width="5%">:</td>
                                    <td class="NikCustomer"></td>
                                </tr>
                                <tr>
                                    <td width="50%">No Telepon</td>
                                    <td width="5%">:</td>
                                    <td class="TlpCustomer"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Pekerjaan</td>
                                    <td width="5%">:</td>
                                    <td class="pekerjaan"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Alamat</td>
                                    <td width="5%">:</td>
                                    <td class="AlamatCustomer"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td width="40%">Kode Instalasi</td>
                                    <td width="2%">:</td>
                                    <td width="50%" class="KdInstallasi"></td>
                                </tr>
                                <tr>
                                    <td width="40%">Cater</td>
                                    <td width="2%">:</td>
                                    <td width="50%" class="CaterInstallasi"></td>
                                </tr>
                                <tr>
                                    <td width="40%">Package</td>
                                    <td width="2%">:</td>
                                    <td width="50%" class="PackageInstallasi"></td>
                                </tr>
                                <tr>
                                    <td width="40%">Alamat</td>
                                    <td width="2%">:</td>
                                    <td width="50%" class="AlamatInstallasi"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label for="awal">Awal Pemakaian</label>
                                <input type="text" class="form-control AkhirUsage input-nilai-awal" name="awal_"
                                    id="awal_" placeholder="Awal Pemakaian" readonly>
                            </div>
                            <div class="form-group">
                                <label for="akhir">Akhir Pemakaian</label>
                                <input type="text" class="form-control input-nilai-akhir" name="akhir_"
                                    id="akhir_" placeholder="Akhir Pemakaian">
                            </div>
                        </div>
                    </div>
                    <p>Data Sudah di Input, Untuk Pengeditan Data Bisa Request Ke <b>Direktur</b> ! </p>

                    <input type="hidden" id="tgl_akhir" class="TglAkhirUsage">
                    <input type="hidden" id="tgl_pemakaian" class="PemakaianUsage">
                    <input type="hidden" name="customer" class="customer" id="customer">
                    <input type="hidden" name="jumlah_" class="jumlah_" id="jumlah_">
                    <input type="hidden" name="id_instalasi" class="id_instalasi" id="id_instalasi">
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Kembali</button>
                        <button type="button" id="SimpanPemakaian" class="btn btn-info">Simpan Pemakaian</button>
                    </div>
                </div>
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
