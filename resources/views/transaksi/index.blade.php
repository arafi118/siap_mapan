@extends('layouts.base')
@php
    $search = 'TagihanBulanan';
    $label = 'Installations (Kode Installasi / Nama Custommers)';
@endphp
@section('content')
    <div class="container-fluid" id="container-wrapper">
        <form action="/transactions" method="post" id="FormPembayaran">
            @csrf
            <input type="text" name="id_transaction" id="id_transaction" hidden>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <input type="text" class="form-control is-valid" id="{{ $search }}"
                            placeholder="{{ $label }}">
                    </div>
                    <hr class="my-2 bg-white">
                    <br>
                </div>
                <div class="col-lg-9">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="alert alert-light" role="alert">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="abodemen">Abodemen</label>
                                            <input type="text" class="form-control" id="abodemen" name="abodemen">
                                            <small class="text-danger" id="msg_abodemen"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="biaya_sudah_dibayar">Biaya sudah dibayar</label>
                                            <input type="text" class="form-control" name="biaya_sudah_dibayar"
                                                id="biaya_sudah_dibayar">
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="tagihan">Tagihan</label>
                                            <input type="text" class="form-control" id="tagihan">
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="pembayaran">Pembayaran</label>
                                            <input type="text" class="form-control total" name="pembayaran"
                                                id="pembayaran">
                                            <small class="text-danger" id="msg_pembayaran"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="abodemen">Abodemen</label>
                                            <input type="text" class="form-control" id="abodemen" name="abodemen">
                                            <small class="text-danger" id="msg_abodemen"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="biaya_sudah_dibayar">Biaya sudah dibayar</label>
                                            <input type="text" class="form-control" name="biaya_sudah_dibayar"
                                                id="biaya_sudah_dibayar">
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal" id="#exampleModal">Detail Customer</button>

                                <button class="btn btn-warning btn-icon-split" type="submit" id="simpanpembayaran"
                                    style="float: right; margin-left: 10px;">
                                    <span class="text" style="float: right;">Loan id</span>
                                </button>

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
                <div class="col-lg-3">
                    <div class="card">
                        <div
                            class="card-header py-4 bg-primary d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-light">Detail Installation</h6>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info" role="alert">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label for="aktif"> Tgl Pakai</label>
                                            <input type="text" class="form-control" id="aktif" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label for="kode_instalasi"> Kode Instalasi</label>
                                            <input type="text" class="form-control" id="kode_instalasi" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label for="desa"> Alamat</label>
                                            <input type="text" class="form-control" id="desa" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label for="package"> Package</label>
                                            <input type="text" class="form-control" id="package" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('modal')
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Custommer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="4" class="text-black">Data Custommer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 50%; font-size: 14px; padding: 8px;" class="text-black">
                                    Loan id
                                    <input style="float: right; width: 40%; padding: 1px; text-align: center;"
                                        id="thl_aktif" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; font-size: 14px; padding: 8px;" class="text-black">
                                    Nama
                                    <input style="float: right; width: 40%; padding: 1px; text-align: center;"
                                        id="" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; font-size: 14px; padding: 8px;" class="text-black">
                                    Nik
                                    <input style="float: right; width: 40%; padding: 1px; text-align: center;"
                                        id="alamat" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; font-size: 14px; padding: 8px;" class="text-black">
                                    Jenis Kelamin
                                    <input style="float: right; width: 40%; padding: 1px; text-align: center;"
                                        id="alamat" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; font-size: 14px; padding: 8px;" class="text-black">
                                    Tempat dan Tanggal lahir
                                    <input style="float: right; width: 40%; padding: 1px; text-align: center;"
                                        id="order" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; font-size: 14px; padding: 8px;" class="text-black">
                                    Telpon/SMS
                                    <input style="float: right; width: 40%; padding: 1px; text-align: center;"
                                        id="alamat" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; font-size: 14px; padding: 8px;" class="text-black">
                                    Desa
                                    <input style="float: right; width: 40%; padding: 1px; text-align: center;"
                                        id="order" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; font-size: 14px; padding: 8px;" class="text-black">
                                    Alamat
                                    <input style="float: right; width: 40%; padding: 1px; text-align: center;"
                                        id="alamat" disabled>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">&nbsp; Close &nbsp;</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        //angka 00,000,00
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

        //hitung _total
        $(document).on('change', '#pembayaran', function() {
            function cleanNumber(value) {
                let cleanNumber = value.toString().replace(/,/g, ''); // Remove commas
                return parseFloat(cleanNumber); // Convert back to number
            }


            var jumlah = cleanNumber($(this).val());
            var jumlah_bayar = cleanNumber($("#biaya_sudah_dibayar").val());
            var abodemen = cleanNumber($("#abodemen").val());
            var total = abodemen - (jumlah + jumlah_bayar);

            $("#_total").val(numFormat.format(total));
        });




        //simpan
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
                                window.location.href = '/installations?status=P';
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
