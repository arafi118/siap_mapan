{{-- @php
    $Class = 'col-12 mb-4';
    if (in_array('jurnal_umum.detail_transaksi', (array) Session::get('tombol'))) {
        $Class = 'col-lg-9 mb-4';
    }
@endphp --}}

@extends('layouts.base')
@section('content')
    <div class="container-fluid" id="container-wrapper">
        <form action="/transactions" method="post" id="FormTransaksi">
            @csrf
            <input type="hidden" name="clay" id="clay" value="JurnalUmum">

            <div class="row">
                <div class="col-9">
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
                                            </select>
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="disimpan_ke">Disimpan ke</label>
                                            <select class="form-control select2" name="disimpan_ke" id="disimpan_ke"
                                                style="height: 38px;">
                                                <option value="">-- Disimpan Ke --</option>
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
                            <br>
                            {{-- @if (in_array('jurnal_umum.simpan_transaksi', (array) Session::get('tombol'))) --}}
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-secondary btn-icon-split" type="button" id="SimpanTransaksi">
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
                            {{-- @endif --}}
                        </div>
                    </div>
                </div>

                {{-- @if (in_array('jurnal_umum.detail_transaksi', (array) Session::get('tombol'))) --}}
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
                                                <select class="form-control select2" name="tahun" id="tahun">
                                                    @php
                                                        $tgl_pakai = $business->tgl_pakai ?? '2000-01-01';
                                                        $th_pakai = explode('-', $tgl_pakai)[0];
                                                    @endphp
                                                    @for ($i = $th_pakai; $i <= date('Y'); $i++)
                                                        <option value="{{ $i }}"
                                                            {{ old('tahun', date('Y')) == $i ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                <small class="text-danger" id="msg_tahun"></small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="position-relative mb-3">
                                                <label for="bulan">Bulan</label>
                                                <select class="form-control select2" name="bulan" id="bulan">
                                                    <option value="">--</option>
                                                    <option {{ date('m') == '01' ? 'selected' : '' }} value="01">
                                                        01.
                                                        JANUARI
                                                    </option>
                                                    <option {{ date('m') == '02' ? 'selected' : '' }} value="02">
                                                        02.
                                                        FEBRUARI
                                                    </option>
                                                    <option {{ date('m') == '03' ? 'selected' : '' }} value="03">
                                                        03.
                                                        MARET
                                                    </option>
                                                    <option {{ date('m') == '04' ? 'selected' : '' }} value="04">
                                                        04.
                                                        APRIL
                                                    </option>
                                                    <option {{ date('m') == '05' ? 'selected' : '' }} value="05">
                                                        05.
                                                        MEI
                                                    </option>
                                                    <option {{ date('m') == '06' ? 'selected' : '' }} value="06">
                                                        06.
                                                        JUNI
                                                    </option>
                                                    <option {{ date('m') == '07' ? 'selected' : '' }} value="07">
                                                        07.
                                                        JULI
                                                    </option>
                                                    <option {{ date('m') == '08' ? 'selected' : '' }} value="08">
                                                        08.
                                                        AGUSTUS
                                                    </option>
                                                    <option {{ date('m') == '09' ? 'selected' : '' }} value="09">
                                                        09.
                                                        SEPTEMBER
                                                    </option>
                                                    <option {{ date('m') == '10' ? 'selected' : '' }} value="10">
                                                        10.
                                                        OKTOBER
                                                    </option>
                                                    <option {{ date('m') == '11' ? 'selected' : '' }} value="11">
                                                        11.
                                                        NOVEMBER
                                                    </option>
                                                    <option {{ date('m') == '12' ? 'selected' : '' }} value="12">
                                                        12.
                                                        DESEMBER
                                                    </option>
                                                </select>
                                                <small class="text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="position-relative mb-3">
                                                <label for="tanggal">Tanggal</label>
                                                <select class="form-control select2" name="tanggal" id="tanggal">
                                                    <option value="">--</option>
                                                    @for ($j = 1; $j <= 31; $j++)
                                                        @php $no=str_pad($j, 2, "0" , STR_PAD_LEFT) @endphp
                                                        <option value="{{ $no }}">{{ $no }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                <small class="text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button class="btn btn-success btn-icon-split" type="button" id="BtndetailTransaksi"
                                        style="float: right; margin-left: 10px;">
                                        <span class="text" style="float: right;">Detail Transaksi</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- @endif --}}

            </div>
        </form>
    </div>
    <div id="notifikasi"></div>

    <!-- Modal detailTransaksi -->
    <div class="modal fade" id="detailTransaksi" tabindex="-1" role="dialog" aria-labelledby="detailTransaksiLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable"
            style="max-width: 100%; margin: 0; height: 100%;" role="document">
            <div class="modal-content" style="height: 100%; border-radius: 0;">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailTransaksiLabel">Detail Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y: auto;">
                    <div id="LayoutdetailTransaksi"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="BtnCetakBuktiTransaksi" class="btn btn-info btn-sm">
                        Cetak Bukti Transaksi
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal CetakBuktiTransaksi -->
    <div class="modal fade" id="CetakBuktiTransaksi" tabindex="-1" aria-labelledby="CetakBuktiTransaksiLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="CetakBuktiTransaksiLabel">
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="LayoutCetakBuktiTransaksi"></div>
                </div>
                <div class="modal-footer">
                    {{-- @if (in_array('jurnal_umum.cetak_bukti_transaksi', Session::get('tombol')))
                        <button type="button" id="BtnCetak" class="btn btn-sm btn-info">
                            Print
                        </button>
                    @endif --}}
                    <button type="button" id="BtnCetakBuktiTransaksi" class="btn btn-danger btn-sm">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Action -->
    <form action="/transactions/reversal" method="post" id="formReversal">
        @csrf

        <input type="hidden" name="rev_idt" id="rev_idt">
        <input type="hidden" name="rev_idtp" id="rev_idtp">
        <input type="hidden" name="rev_id_pinj" id="rev_id_pinj">
    </form>

    <form action="/transactions/hapus" method="post" id="formHapus">
        @csrf

        <input type="hidden" name="del_idt" id="del_idt">
        <input type="hidden" name="del_idtp" id="del_idtp">
        <input type="hidden" name="del_id_pinj" id="del_id_pinj">
    </form>

    <input type="hidden" name="saldo_trx" id="saldo_trx">
@endsection

@section('script')
    <script>
        //formatter
        var formatter = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });

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
        });

        //tgl_transaksi
        $(document).on('change', '#tgl_transaksi', function(e) {
            e.preventDefault()

            var tgl_transaksi = $(this).val().split('/')
            var tahun = tgl_transaksi[2];
            var bulan = tgl_transaksi[1];
            var hari = tgl_transaksi[0];

            if ($('#sumber_dana').val() != '') {
                var sumber_dana = $('#sumber_dana').val();
                var tgl_transaksi = $(this).val().split('/')

                setSaldo(sumber_dana, tgl_transaksi)
            }
        });

        //sumber_dana
        $(document).on('change', '#sumber_dana', function(e) {
            e.preventDefault()
            var sumber_dana = $(this).val()

            if (sumber_dana == '1.2.02.01') {
                simpan.setChoiceByValue('5.1.07.08')
            }

            if (sumber_dana == '1.2.02.02') {
                simpan.setChoiceByValue('5.1.07.09')
            }

            if (sumber_dana == '1.2.02.03') {
                simpan.setChoiceByValue('5.1.07.10')
            }

            var tgl_transaksi = $('#tgl_transaksi').val().split('/')

            setSaldo(sumber_dana, tgl_transaksi)
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
            e.preventDefault()
            $('small').html('')
            $('#notifikasi').html('')

            var nominal = $('#nominal').val()
            var saldo_rek = parseFloat($('#saldo_trx').val())

            if (!nominal) {
                nominal = $('#harga_perolehan').val()
            }

            if (nominal) {
                nominal = parseFloat(nominal.split(',').join(''))
            } else {
                nominal = 0
            }

            var sumber_dana = $('#sumber_dana').val()
            if (sumber_dana == '1.2.02.01') {
                saldo_rek *= -1;
            }

            if (sumber_dana == '1.2.02.02') {
                saldo_rek *= -1;
            }

            if (sumber_dana == '1.2.02.03') {
                saldo_rek *= -1;
            }

            if (sumber_dana == '1.1.04.01') {
                saldo_rek *= -1;
            }

            if (sumber_dana == '1.1.04.02') {
                saldo_rek *= -1;
            }

            if (sumber_dana == '1.1.04.03') {
                saldo_rek *= -1;
            }

            var saldo_rek = 999999999999999
            if (saldo_rek >= nominal) {
                var form = $('#FormTransaksi')
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(result) {
                        if (result.success) {
                            Swal.fire('Berhasil', result.msg, 'success').then(() => {
                                $("#jenis_transaksi").maskMoney();

                                $('#notifikasi').html(result.view)
                                var sumber_dana = $('#sumber_dana').val()
                                var tgl_transaksi = $('#tgl_transaksi').val().split('/')

                                setSaldo(sumber_dana, tgl_transaksi)
                            })
                        } else {
                            Swal.fire('Error', result.msg, 'error')
                        }
                    },
                    error: function(result) {
                        const respons = result.responseJSON;

                        Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error')
                        $.map(respons, function(res, key) {
                            $('#' + key).parent('.input-group.input-group-static').addClass(
                                'is-invalid')
                            $('#msg_' + key).html(res)
                        })
                    }
                })
            } else {
                Swal.fire('Error', 'Nominal transaksi melebihi saldo', 'error')
            }
        })

        $(document).on('change', '#harga_satuan,#jumlah', function(e) {
            var harga = $('#harga_satuan').val()
            var jumlah = ($('#jumlah').val()) ? $('#jumlah').val() : 0

            if (harga == '') {
                harga = 0
            } else {
                harga = parseInt(harga.split(',').join('').split('.00').join(''))
            }

            var harga_perolehan = harga * jumlah
            $('#harga_perolehan').val(formatter.format(harga_perolehan))
        })


        $(document).on('change', '#nama_barang', function(e) {
            var value = $(this).val().split('#')

            var id = value[0]
            var unit = parseInt(value[1])
            var nilai_buku = parseInt(value[2])

            var harga = nilai_buku / unit

            $('#unit').attr('max', unit)

            $('#unit').val(unit)
            $('#harsat').val(harga)
            $('#_nilai_buku').val(nilai_buku)
            $('#nilai_buku').val(formatter.format(nilai_buku))
            $('#harga_jual').val(formatter.format(nilai_buku))
        })

        $(document).on('change', '#unit', function() {
            var max = parseInt($(this).attr('max'))
            var unit = parseInt($(this).val())

            if (unit > max) {
                $(this).val(max)
                unit = max
            }

            if (unit < 1) {
                $(this).val(max)
                unit = max
            }

            var harga = parseInt($('#harsat').val())
            var nilai_buku = unit * harga

            $('#_nilai_buku').val(nilai_buku)
            $('#nilai_buku').val(formatter.format(nilai_buku))
            $('#harga_jual').val(formatter.format(nilai_buku))
        })

        $(document).on('change', '#alasan', function() {
            var status = $(this).val()

            var col_harga_jual = false
            if (status == "dijual") {
                var col_harga_jual = true

                $('#col_harga_jual').find('label[for="harga_jual"]').text('Harga Jual')
            }

            if (status == "revaluasi") {
                var col_harga_jual = true

                $('#col_harga_jual').find('label[for="harga_jual"]').text('Harga Revaluasi')
            }

            if (col_harga_jual) {
                $('#col_nilai_buku,#col_unit').attr('class', 'col-sm-4')
                $('#col_harga_jual').show()
                $("#col_harga_jual").focus()
            } else {
                $('#col_nilai_buku,#col_unit').attr('class', 'col-sm-6')
                $('#col_harga_jual').hide()
            }
        })

        $(document).on('click', '#BtndetailTransaksi', function(e) {
            var tahun = $('select#tahun').val()
            var bulan = $('select#bulan').val()
            var hari = $('select#tanggal').val()
            var kode_akun = $('#sumber_dana').val()

            if (kode_akun != '') {
                $.ajax({
                    url: '/transactions/detail_transaksi',
                    type: 'get',
                    data: {
                        tahun,
                        bulan,
                        hari,
                        account_id
                    },
                    success: function(result) {
                        $('#detailTransaksi').modal('show')

                        $('#detailTransaksiLabel').html(result.label)
                        $('#LayoutdetailTransaksi').html(result.view)

                        $('#CetakBuktiTransaksiLabel').html(result.label)
                        $('#LayoutCetakBuktiTransaksi').html(result.cetak)
                    }
                })
            }
        })

        $(document).on('click', '#BtnCetakBuktiTransaksi', function(e) {
            e.preventDefault()

            $('#CetakBuktiTransaksi').modal('toggle')
        })

        $(document).on('click', '.btn-struk', function(e) {
            e.preventDefault()

            var idtp = $(this).attr('data-idtp')
            Swal.fire({
                title: "Cetak Kuitansi Angsuran",
                showDenyButton: true,
                confirmButtonText: "Biasa",
                denyButtonText: "Dot Matrix",
                confirmButtonColor: "#3085d6",
                denyButtonColor: "#3085d6",
            }).then((result) => {
                if (result.isConfirmed) {
                    open_window('/transaksi/angsuran/struk/' + idtp)
                } else if (result.isDenied) {
                    open_window('/transaksi/angsuran/struk_matrix/' + idtp)
                }
            });
        })

        $(document).on('click', '.btn-link', function(e) {
            var action = $(this).attr('data-action')

            open_window(action)
        })

        $(document).on('click', '.btn-reversal', function(e) {
            e.preventDefault()

            var idt = $(this).attr('data-idt')
            $.get('/transaksi/data/' + idt, function(result) {

                $('#rev_idt').val(result.idt)
                $('#rev_idtp').val(result.idtp)
                $('#rev_id_pinj').val(result.id_pinj)
                Swal.fire({
                    title: 'Peringatan',
                    text: 'Setelah menekan tombol Reversal dibawah, maka aplikasi akan membuat transaksi minus (-) senilai Rp. -' +
                        result.jumlah,
                    showCancelButton: true,
                    confirmButtonText: 'Reversal',
                    cancelButtonText: 'Batal',
                    icon: 'warning'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $('#formReversal')
                        $.ajax({
                            type: form.attr('method'),
                            url: form.attr('action'),
                            data: form.serialize(),
                            success: function(result) {
                                if (result.success) {
                                    Swal.fire('Berhasil!', result.msg, 'success')
                                        .then(() => {
                                            childWindow = window.open(
                                                '/simpan_saldo?bulan=' + result
                                                .bulan + '&tahun=' +
                                                result.tahun + '&kode_akun=' +
                                                result.kode_akun, '_blank');
                                            $('#detailTransaksi').modal('hide')
                                        })
                                }
                            }
                        })
                    }
                })
            })
        })

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault()

            var idt = $(this).attr('data-idt')
            $.get('/transaksi/data/' + idt, function(result) {

                $('#del_idt').val(result.idt)
                $('#del_idtp').val(result.idtp)
                $('#del_id_pinj').val(result.id_pinj)
                Swal.fire({
                    title: 'Peringatan',
                    text: 'Setelah menekan tombol Hapus Transaksi dibawah, maka transaksi ini akan dihapus dari aplikasi secara permanen.',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus Transaksi',
                    cancelButtonText: 'Batal',
                    icon: 'warning'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $('#formHapus')
                        $.ajax({
                            type: form.attr('method'),
                            url: form.attr('action'),
                            data: form.serialize(),
                            success: function(result) {
                                if (result.success) {
                                    Swal.fire('Berhasil!', result.msg, 'success')
                                        .then(() => {
                                            childWindow = window.open(
                                                '/simpan_saldo?bulan=' + result
                                                .bulan + '&tahun=' +
                                                result.tahun + '&kode_akun=' +
                                                result.kode_akun, '_blank');
                                            $('#detailTransaksi').modal('hide')
                                        })
                                }
                            }
                        })
                    }
                })
            })
        })

        $(document).on('click', '#BtnCetak', function(e) {
            e.preventDefault()

            if ($('#FormCetakDokumenTransaksi').serializeArray().length > 1) {
                $('#FormCetakDokumenTransaksi').submit();
            } else {
                Swal.fire('Error', "Tidak ada transaksi yang dipilih.", 'error')
            }
        })

        function initializeBootstrapTooltip() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')),
                tooltipList = tooltipTriggerList.map(function(e) {
                    return new bootstrap.Tooltip(e)
                });
        }

        function setSaldo(sumber_dana, tgl_transaksi) {

            if (!sumber_dana) {
                console.warn("Sumber dana kosong. Permintaan tidak akan dijalankan.");
                return; // Hentikan eksekusi jika sumber_dana kosong
            }

            var tahun = tgl_transaksi[2];
            var bulan = tgl_transaksi[1];
            var hari = tgl_transaksi[0];

            $.get('/transactions/saldo/' + sumber_dana + '?tahun=' + tahun + '&bulan=' + bulan + '&hari=' + hari,
                function(result) {
                    $('#saldo').html(formatter.format(result.saldo))
                    $('#saldo_trx').val(result.saldo)
                })
        }
    </script>
@endsection
