@extends('layouts.base')
@php
    $ketik_search = 'CariCustommers';
    $label_search = 'Installations (Kode Installasi / Nama Custommers)';
@endphp
@section('content')
    <div class="container-fluid" id="container-wrapper">
        <form action="/transactions" method="post" id="FormPembayaran">
            @csrf
            <input type="text" name="transaction_id" id="transaction_id" hidden>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- Bagian Informasi Customer -->
                            <div class="alert alert-info d-flex align-items-center m-0 text-white" role="alert"
                                style="border-radius: 1;">
                                <!-- Gambar -->
                                <img src="../../assets/img/pls.png"
                                    style="max-height: 160px; margin-right: 15px; margin-left: 10px;" class="img-fluid">

                                <!-- Konten Teks -->
                                <div class="flex-grow-1">
                                    <form class="navbar-search">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="typeahead form-control bg-light border-1 small search"
                                                id="{{ $ketik_search }}" placeholder="{{ $label_search }}">
                                            <div class="invalid-feedback">Masukkan (Kode Installasi / Nama Custommers)</div>
                                        </div>
                                    </form>

                                    <hr class="my-2 bg-white">
                                    <div class="mt-3">
                                        <table class="table table-bordered table-striped mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th colspan="4" class="text-black">Detail Instalasi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 50%; font-size: 14px; padding: 8px;"
                                                        class="text-black">
                                                        Tgl Order
                                                        <input
                                                            style="float: right; width: 40%; padding: 1px; text-align: center;"
                                                            id="order" disabled>
                                                    </td>
                                                    <td style="width: 50%; font-size: 14px; padding: 8px;"
                                                        class="text-black">
                                                        Kode Instalasi

                                                        <input
                                                            style="float: right; width: 40%; padding: 1px; text-align: center;"
                                                            id="kode_instalasi" disabled>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%; font-size: 14px; padding: 8px;"
                                                        class="text-black">
                                                        Alamat
                                                        <input
                                                            style="float: right; width: 40%; padding: 1px; text-align: center;"
                                                            id="alamat" disabled>
                                                    </td>
                                                    <td style="width: 50%; font-size: 14px; padding: 8px;">
                                                        Package
                                                        <input
                                                            style="float: right; width: 40%; padding: 1px; text-align: center;"
                                                            id="package" disabled>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabel di Bawah Customer -->
                            <br>
                            <div class="alert alert-light" role="alert">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="position-relative mb-3">
                                            <label for="tgl_transaksi">Tanggal Pelunasan</label>
                                            <input type="text" class="form-control date" name="tgl_transaksi"
                                                id="tgl_transaksi"value=" {{ date('d/m/Y') }}">
                                            <small class="text-danger" id="msg_tgl_transaksi"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative mb-3">
                                            <label for="abodemen">Abodemen</label>
                                            <input type="text" class="form-control" id="abodemen" name="abodemen">
                                            <small class="text-danger" id="msg_abodemen"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative mb-3">
                                            <label for="biaya_sudah_dibayar">Biaya sudah dibayar</label>
                                            <input type="text" class="form-control" name="biaya_sudah_dibayar"
                                                id="biaya_sudah_dibayar">
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="position-relative mb-3">
                                            <label for="tagihan">Tagihan</label>
                                            <input type="text" class="form-control" id="tagihan">
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative mb-3">
                                            <label for="pembayaran">Pembayaran</label>
                                            <input type="text" class="form-control total" name="pembayaran"
                                                id="pembayaran">
                                            <small class="text-danger" id="msg_pembayaran"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative mb-3">
                                            <label for="total">Total</label>
                                            <input type="text" class="form-control" id="_total" disabled>
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-secondary btn-icon-split" type="submit" id="simpanpembayaran"
                                    style="float: right; margin-left: 10px;">
                                    <span class="icon text-white-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                        </svg>
                                    </span>
                                    <span class="text" style="float: right;">Simpan Pembayaran</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $("#abodemen").maskMoney({
            allowNegative: true
        });

        $("#biaya_instalasi").maskMoney({
            allowNegative: true
        });

        $("#tagihan").maskMoney({
            allowNegative: true
        });

        $(".total").maskMoney({
            allowNegative: true
        });

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

        $(document).on('change', '#pembayaran', function() {
            var jumlah = $(this).val()
            var jumlah_bayar = $("#biaya_sudah_dibayar").val()
            var abodemen = $("#abodemen").val()

            $('#_total').val(abodemen - (jumlah + jumlah_bayar))
        })

        // search
        document.querySelector('.search').addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });

        $(document).on('click', '#simpanpembayaran', function(e) {
            e.preventDefault();
            $('small').html('');

            var form = $('#FormPembayaran');
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            title: result.msg,
                            text: "Tambahkan Pembayaran Baru?",
                            icon: "success",
                            showDenyButton: true,
                            confirmButtonText: "Tambahkan",
                            denyButtonText: `Tidak`
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload()
                            } else {
                                window.location.href = '/installations/' + result.installation
                                    .id;
                            }
                        });
                    }
                },
                error: function(result) {
                    const response = result.responseJSON;

                    Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error');

                    if (response && typeof response === 'object') {
                        $.each(response, function(key, message) {
                            $('#' + key)
                                .closest('.input-group.input-group-static')
                                .addClass('is-invalid');

                            $('#msg_' + key).html(message);
                        });
                    }
                }
            });
        });
    </script>
@endsection
