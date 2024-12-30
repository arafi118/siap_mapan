@php
$thn_awal = explode('-', $busines->created_at)[0];
@endphp


@extends('layouts.base')

@section('content')

<div class="app-main__inner">

    <div class="main-card mb-3 card">
        <div class="card-body">
            <form action="" class="needs-validation" novalidate method="post" id="FormPelaporan" target="_blank">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <select class=" form-control" name="tahun" id="tahun">
                                <option value="">---</option>
                                @for ($i = $thn_awal; $i <= date('Y'); $i++) <option
                                    {{ $i == date('Y') ? 'selected' : '' }} value="{{ $i }}">
                                    {{ $i }}
                                    </option>
                                    @endfor
                            </select>
                            <small class="text-danger" id="msg_tahun"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="bulan">Bulan</label>
                            <select class=" form-control" name="bulan" id="bulan">
                                <option value="">---</option>
                                <option value="01">01. JANUARI</option>
                                <option value="02">02. FEBRUARI</option>
                                <option value="03">03. MARET</option>
                                <option value="04">04. APRIL</option>
                                <option value="05">05. MEI</option>
                                <option value="06">06. JUNI</option>
                                <option value="07">07. JULI</option>
                                <option value="08">08. AGUSTUS</option>
                                <option value="09">09. SEPTEMBER</option>
                                <option value="10">10. OKTOBER</option>
                                <option value="11">11. NOVEMBER</option>
                                <option value="12">12. DESEMBER</option>
                            </select>
                            <small class="text-danger" id="msg_bulan"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="hari">Tanggal</label>
                            <select class=" form-control" name="hari" id="hari">
                                <option value="">---</option>
                                @for ($j = 1; $j <= 31; $j++) @if ($j < 10) <option value="0{{ $j }}">0{{ $j }}</option>
                                    @else
                                    <option value="{{ $j }}">{{ $j }}</option>
                                    @endif
                                    @endfor
                            </select>
                            <small class="text-danger" id="msg_hari"></small>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div id="namaLaporan" class="col-md-6">
                        <div class="my-2">
                            <div class="form-group">
                                <label for="laporan">Nama Laporan</label>
                                <select class=" form-control" name="laporan" id="laporan">
                                    <option value="">---</option>
                                    @foreach ($laporan as $lap)
                                    <option value="{{ $lap->file }}">
                                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}.
                                        {{ $lap->nama_laporan }}
                                    </option>
                                    @endforeach
                                </select>
                                <small class="text-danger" id="msg_laporan"></small>
                            </div>
                        </div>
                    </div>
                    <div id="subLaporan" class="col-md-6">
                        <div class="my-2">
                            <div class="form-group">
                                <label for="sub_laporan">Nama Sub Laporan</label>
                                <select class=" form-control" name="sub_laporan" id="sub_laporan">
                                    <option value="">---</option>
                                </select>
                                <small class="text-danger" id="msg_sub_laporan"></small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="button" id="SimpanSaldo" class="btn btn-sm btn-danger me-2">Simpan Saldo</button>
                        <button type="button" id="Excel" class="btn btn-sm btn-success me-2">Excel</button>
                        <button type="button" id="Preview" class="btn btn-sm btn-dark">Preview</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <br>
            <div class="card-body p-2" id="LayoutPreview">
                <div class="p-2"></div>
            </div>
            <script>
                // Example starter JavaScript for disabling form submissions if there are invalid fields
                (function () {
                    'use strict';
                    window.addEventListener('load', function () {
                        // Fetch all the forms we want to apply custom Bootstrap validation styles to
                        var forms = document.getElementsByClassName('needs-validation');
                        // Loop over them and prevent submission
                        var validation = Array.prototype.filter.call(forms, function (form) {
                            form.addEventListener('submit', function (event) {
                                if (form.checkValidity() === false) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                }
                                form.classList.add('was-validated');
                            }, false);
                        });
                    }, false);
                })();
            </script>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $('.js-example-basic-single').select2({
        theme: 'bootstrap-4'
    });
    $(document).on('change', '#tahun, #bulan', function (e) {
        e.preventDefault()

        var file = $('select#laporan').val()
        subLaporan(file)
    })

    $(document).on('change', '#laporan', function (e) {
        e.preventDefault()

        var file = $(this).val()
        subLaporan(file)
    })

    function subLaporan(file) {
        var tahun = $('select#tahun').val()
        var bulan = $('select#bulan').val()

        if (file == 'calk') {
            $('#namaLaporan').removeClass('col-md-6')
            $('#namaLaporan').addClass('col-md-12')
            $('#subLaporan').removeClass('col-md-6')
            $('#subLaporan').addClass('col-md-12')
        }

        $.get('/pelaporan/sub_laporan/' + file + '?tahun=' + tahun + '&bulan=' + bulan, function (result) {
            $('#subLaporan').html(result)
        })
    }

    $(document).on('click', '#Preview', async function (e) {
        e.preventDefault()

        $(this).parent('form').find('#type').val('pdf')
        var file = $('select#laporan').val()
        if (file == 'calk') {
            await $('textarea#sub_laporan').val(quill.container.firstChild.innerHTML)
        }

        var form = $('#FormPelaporan')
        if (file != '') {
            form.submit()
        }
    })

    $(document).on('click', '#Excel', async function (e) {
        e.preventDefault()

        $(this).parent('form').find('#type').val('excel')
        var file = $('select#laporan').val()
        if (file == 'calk') {
            await $('textarea#sub_laporan').val(quill.container.firstChild.innerHTML)
        }

        var form = $('#FormPelaporan')
        console.log(form.serialize())
        if (file != '') {
            form.submit()
        }
    })

    let childWindow, loading;
    $(document).on('click', '#SimpanSaldo', function (e) {
        e.preventDefault()

        var tahun = $('select#tahun').val()
        var bulan = $('select#bulan').val()
        if (bulan < 1) {
            bulan = 0
        }

        var nama_bulan = namaBulan(bulan)

        var pesan = nama_bulan + " sampai Desember "
        if (bulan == '12') {
            pesan = nama_bulan + " "
        }

        loading = Swal.fire({
            title: "Mohon Menunggu..",
            html: "Menyimpan Saldo Bulan " + pesan + tahun,
            timerProgressBar: true,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        })

        childWindow = window.open('/simpan_saldo?bulan=00&tahun=' + tahun + '&bulan=' + bulan, '_blank');
    })

    window.addEventListener('message', function (event) {
        if (event.data === 'closed') {
            loading.close()
            window.location.reload()
        }
    })

    function namaBulan(bulan) {
        switch (bulan) {
            case '01':
                return 'Januari';
                break;
            case '02':
                return 'Februari';
                break;
            case '03':
                return 'Maret';
                break;
            case '04':
                return 'April';
                break;
            case '05':
                return 'Mei';
                break;
            case '06':
                return 'Juni';
                break;
            case '07':
                return 'Juli';
                break;
            case '08':
                return 'Agustus';
                break;
            case '09':
                return 'September';
                break;
            case '10':
                return 'Oktober';
                break;
            case '11':
                return 'November';
                break;
            case '12':
                return 'Desember';
                break;
        }

        return 'Januari';
    }

</script>
@endsection
