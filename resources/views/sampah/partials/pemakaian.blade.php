<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width:500px">
        <div class="modal-content p-2">

            <div class="modal-body">

                <div class="card mb-2 alert-secondary">
                    <div class="card-body py-2 px-3 text-white">
                        <h6 class="mb-0">INSTALASI <b>SAMPAH</b></h6>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <div class="d-flex mb-2">
                            <div style="width:120px">No. Induk</div>
                            <div>: <span class="KdInstallasi"></span></div>
                        </div>

                        <hr class="my-2">

                        <div class="d-flex mb-2">
                            <div style="width:120px">Nama</div>
                            <div>: <span class="namaCustomer"></span></div>
                        </div>

                        <hr class="my-2">

                        <div class="d-flex">
                            <div style="width:120px">Alamat</div>
                            <div>: <span class="AlamatInstallasi"></span></div>
                        </div>

                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <label>Jumlah Bayar</label>
                        <input type="text" class="form-control input-jumlah-bayar" id="jumlah_bayar">
                    </div>
                </div>

            </div>

            <div class="modal-footer py-2">
                <input type="hidden" id="tgl_akhir" class="TglAkhirUsage">
                <input type="hidden" id="tgl_pemakaian" class="PemakaianUsage">
                <input type="hidden" class="customer" id="customer">
                <input type="hidden" id="jumlah_">
                <input type="hidden" class="id_instalasi" id="id_instalasi">

                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Kembali</button>
                <button type="button" id="SimpanSampah" class="btn btn-warning">Simpan Pemakaian</button>
            </div>

        </div>
    </div>
</div>

<script>
    jQuery.datetimepicker.setLocale('de')

    $('.date').datetimepicker({
        timepicker: false,
        format: 'd/m/Y'
    })

    $(document).on('input', '#jumlah_bayar', function () {
        $('#jumlah_').val($(this).val())
    })

</script>
