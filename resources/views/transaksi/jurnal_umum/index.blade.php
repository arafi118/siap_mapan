@extends('layouts.base')
@section('content')
    <div class="container-fluid" id="container-wrapper">
        <form action="/transactions" method="post" id="FormTransaksi">
            @csrf
            <input type="hidden" name="clay" id="clay" value="JurnalUmum">
            <input type="hidden" name="transaction_id" id="transaction_id">

            <div class="row">
                <div class="col-lg-9">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="alert alert-light" role="alert">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="tgl_transaksi">Tanggal Transaksi</label>
                                            <input type="text" class="form-control date" name="tgl_transaksi"
                                                id="tgl_transaksi" style="height: 38px;" value="{{ date('d/m/Y') }}">
                                            <small class="text-danger" id="msg_tgl_transaksi"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="jenis_transaksi">Jenis Transaksi</label>
                                            <select class="form-control select2" name="jenis_transaksi"
                                                id="jenis_transaksi">
                                                <option value="">-- Pilih Jenis Transaksi --</option>
                                                @foreach ($jenis_transaksi as $jt)
                                                    <option value="{{ $jt->id }}">
                                                        {{ $jt->nama_jt }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-danger" id="msg_jenis_transaksi"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="kd_rekening">
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="sumber_dana">Sumber Dana</label>
                                            <select class="form-control select2" name="sumber_dana" id="sumber_dana"
                                                style="height: 38px;">
                                                <option value="">-- Pilih Sumber Dana --</option>
                                                {{-- @foreach ($rekening as $rek1)
                                                    <option value="{{ $rek1->id }}">
                                                        {{ $rek1->kode_akun }} {{ $rek1->nama_akun }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="disimpan">Disimpan ke</label>
                                            <select class="form-control select2" name="disimpan" id="disimpan"
                                                style="height: 38px;">
                                                <option value="">-- Disimpan Ke --</option>
                                                {{-- @foreach ($rekening as $rek1)
                                                    <option value="{{ $rek1->id }}">
                                                        {{ $rek1->kode_akun }} {{ $rek1->nama_akun }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="form_nominal">
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label for="keterangan">Keterangan</label>
                                            <input type="text" class="form-control" name="keterangan" id="keterangan"
                                                style="height: 38px;">
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label for="nominal">Nominal Rp.</label>
                                            <input type="text" class="form-control" name="nominal" id="nominal"
                                                style="height: 38px;">
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-secondary btn-icon-split" type="submit" id="SimpanTransaksi"
                                    style="float: right; margin-left: 10px;">
                                    <span class="icon text-white-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                        </svg>
                                    </span>
                                    <span class="text" style="float: right;">Simpan Transaksi</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card mb-4">
                        <form action="">
                            <div class="card-body">
                                <div class="alert alert-light" role="alert">
                                    <div class="d-flex justify-content-between">
                                        <div class="text-sm">Saldo:</div>
                                        <div class="text-sm fw-bold">
                                            Rp. <span id="saldo">0.00</span>
                                        </div>
                                    </div>
                                    <hr style="border: 1px solid black;">
                                    <div class="text-sm fw-bold text-center">Cetak Buku Bantu</div>
                                    <hr style="border: 1px solid black;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="position-relative mb-3">
                                                <label for="tahun">Tahun</label>
                                                <select class="form-control select2" name="disimpan_ke" id="disimpan_ke"
                                                    style="height: 38px;">
                                                    <option value="kredit">Kredit</option>
                                                    <option value="debit">Debit</option>
                                                </select>
                                                <small class="text-danger" id="msg_tahun"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="position-relative mb-3">
                                                <label for="bulan">Bulan</label>
                                                <select class="form-control select2" name="disimpan_ke" id="disimpan_ke"
                                                    style="height: 38px;">
                                                    <option value="kredit">Kredit</option>
                                                    <option value="debit">Debit</option>
                                                </select>
                                                <small class="text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="position-relative mb-3">
                                                <label for="tanggal">Tanggal</label>
                                                <select class="form-control select2" name="disimpan_ke" id="disimpan_ke"
                                                    style="height: 38px;">
                                                    <option value="kredit">Kredit</option>
                                                    <option value="debit">Debit</option>
                                                </select>
                                                <small class="text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button class="btn btn-success btn-icon-split" type="submit" id="simpanpembayaran"
                                        style="float: right; margin-left: 10px;">
                                        <span class="text" style="float: right;">Detail Transaksi</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        //angka 00,000,00
        $("#nominal").maskMoney({
            allowNegative: true
        });

        //select 2
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
            });
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

        //jenis transaksi
        $(document).on('change', '#jenis_transaksi', function(e) {
            e.preventDefault()

            var tgl_transaksi = $('#tgl_transaksi').val().split('/')
            var tahun = tgl_transaksi[2];
            var bulan = tgl_transaksi[1];
            var hari = tgl_transaksi[0];

            if ($(this).val().length > 0) {
                $.get('/transactions/ambil_rekening/' + $(this).val() + '?tahun=' + tahun + '&bulan=' + bulan,
                    function(result) {
                        $('#kd_rekening').html(result)
                    })
            }
        })

        //form sumber dana & disimpan ke
        $(document).on('change', '#sumber_dana,#disimpan_ke', function(e) {
            e.preventDefault()

            var tgl_transaksi = $('#tgl_transaksi').val()
            var jenis_transaksi = $('#jenis_transaksi').val()
            var sumber_dana = $('#sumber_dana').val()
            var disimpan_ke = $('#disimpan_ke').val()

            $.get('/transactions/form_nominal/', {
                jenis_transaksi,
                sumber_dana,
                disimpan_ke,
                tgl_transaksi
            }, function(result) {
                $('#form_nominal').html(result)
            })
        })

        //simpan Jurnal Umum
        $(document).on('click', '#SimpanTransaksi', function(e) {
            e.preventDefault();
            $('small').html('');

            var form = $('#FormTransaksi');
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            title: result.msg,
                            text: "Lanjut Pembayaran Tagihan?",
                            icon: "success",
                            showDenyButton: true,
                            confirmButtonText: "Lanjutkan",
                            denyButtonText: `Tidak`
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload()
                            } else {
                                window.location.href = '#';
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
