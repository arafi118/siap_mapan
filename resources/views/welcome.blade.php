@extends('layouts.base')

@section('content')
    <div class="row g-3 mb-3">
        <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden">
                <div class="bg-holder bg-card" style="background-image:url(/assets/img/corner-3.png);"></div>

                <div class="card-body position-relative">
                    <h6 class="font-weight-bold">
                        Instalasi
                    </h6>
                    <div class="display-4 fs-5 mb-2 font-weight-normal text-success" id="InstallationCount">
                        {{ $Installation }}
                    </div>
                    <a class="font-weight-bold text-nowrap fs-10" href="#" id="BtnModalInstalasi">
                        Lihat Detail
                        <span class="fas fa-angle-right mr-1"></span>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden">
                <div class="bg-holder bg-card" style="background-image:url(/assets/img/corner-2.png);"></div>

                <div class="card-body position-relative">
                    <h6 class="font-weight-bold">
                        Pemakaian
                    </h6>
                    <div class="display-4 fs-5 mb-2 font-weight-normal text-primary" id="UsageCount">
                        {{ $Usage }}
                    </div>
                    <a class="font-weight-bold text-nowrap fs-10" href="#" id="BtnModalPemakaian">
                        Lihat Detail
                        <span class="fas
                        fa-angle-right mr-1"></span>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden">
                <div class="bg-holder bg-card" style="background-image:url(/assets/img/corner-1.png);"></div>

                <div class="card-body position-relative">
                    <h6 class="font-weight-bold">
                        Tagihan
                    </h6>
                    <div class="display-4 fs-5 mb-2 font-weight-normal text-warning" id="TagihanCount">
                        {{ $Tagihan }}
                    </div>
                    <a class="font-weight-bold text-nowrap fs-10" href="#" id="BtnModalTagihan">
                        Lihat Detail
                        <span class="fas fa-angle-right mr-1"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row flex-between-center py-2">
                                <div class="col d-md-flex d-lg-block flex-between-center">
                                    <h6 class="mb-md-0 mb-lg-2">Saldo Kas</h6>
                                    <span class="badge rounded-pill badge-success">
                                        <span class="fas fa-caret-up"></span>
                                        61.8%
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <h4 class="fs-6 font-weight-normal text-700">
                                        $82.18M
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row flex-between-center py-2">
                                <div class="col d-md-flex d-lg-block flex-between-center">
                                    <h6 class="mb-md-0 mb-lg-2">Revenue</h6>
                                    <span class="badge rounded-pill badge-success">
                                        <span class="fas fa-caret-up"></span>
                                        61.8%
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <h4 class="fs-6 font-weight-normal text-700">
                                        $82.18M
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row flex-between-center py-2">
                                <div class="col d-md-flex d-lg-block flex-between-center">
                                    <h6 class="mb-md-0 mb-lg-2">Revenue</h6>
                                    <span class="badge rounded-pill badge-success">
                                        <span class="fas fa-caret-up"></span>
                                        61.8%
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <h4 class="fs-6 font-weight-normal text-700">
                                        $82.18M
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div id="main" style="width: 100%;height:314px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="ModalInstalasi" tabindex="-1" role="dialog" aria-labelledby="ModalInstalasiLabel"
        aria-modal="false">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalInstalasiLabel">Daftar Instalasi</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <ul id="tabs" class="nav nav-pills justify-content-center">
                                    <li class="nav-item">
                                        <a href="" data-target="#Permohonan" data-toggle="tab"
                                            class="nav-link small text-uppercase active">
                                            Permohonan
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" data-target="#Pasang" data-toggle="tab"
                                            class="nav-link small text-uppercase">
                                            Pasang
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" data-target="#Aktif" data-toggle="tab"
                                            class="nav-link small text-uppercase">
                                            Aktif
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div id="tabsContent" class="tab-content mt-3">
                            <div id="Permohonan" class="tab-pane active show fade">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Kode Instalasi</th>
                                                    <th>Customer</th>
                                                    <th>Alamat</th>
                                                    <th>Paket</th>
                                                    <th>Tanggal Order</th>
                                                </tr>
                                            </thead>
                                            <tbody id="TablePermohonan"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="Pasang" class="tab-pane fade">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Kode Instalasi</th>
                                                    <th>Customer</th>
                                                    <th>Alamat</th>
                                                    <th>Paket</th>
                                                    <th>Tanggal Order</th>
                                                </tr>
                                            </thead>
                                            <tbody id="TablePasang"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="Aktif" class="tab-pane fade">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Kode Instalasi</th>
                                                    <th>Customer</th>
                                                    <th>Alamat</th>
                                                    <th>Paket</th>
                                                    <th>Tanggal Aktif</th>
                                                </tr>
                                            </thead>
                                            <tbody id="TableAktif"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary btn-modal-close">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalPemakaian" tabindex="-1" role="dialog" aria-labelledby="ModalPemakaianLabel"
        aria-modal="false">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalPemakaianLabel">Daftar Pemakaian</h5>
                    <button type="button" class="close btn-modal-close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Kode Instalasi</th>
                                        <th>Customer</th>
                                        <th>Paket</th>
                                        <th>Pemakaian</th>
                                    </tr>
                                </thead>
                                <tbody id="TablePemakaian"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary btn-modal-close">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalTagihan" tabindex="-1" role="dialog" aria-labelledby="ModalTagihanLabel"
        aria-modal="false">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalTagihanLabel">Daftar Tagihan</h5>
                    <button type="button" class="close btn-modal-close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Kode Instalasi</th>
                                        <th>Customer</th>
                                        <th>Tgl Tagihan</th>
                                        <th>Jumlah</th>
                                        <th>Tagihan</th>
                                    </tr>
                                </thead>
                                <tbody id="TableTagihan"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary btn-modal-close">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var myChart = echarts.init(document.getElementById('main'));

        // Specify the configuration items and data for the chart
        option = {
            xAxis: {
                data: ['A', 'B', 'C', 'D', 'E']
            },
            yAxis: {},
            series: [{
                    data: [10, 22, 28, 23, 19],
                    type: 'line',
                    areaStyle: {}
                },
                {
                    data: [25, 14, 23, 35, 10],
                    type: 'line',
                    areaStyle: {
                        color: '#ff0',
                        opacity: 0.5
                    }
                }
            ]
        };

        // Display the chart using the configuration items and data just specified.
        myChart.setOption(option);
    </script>

    <script>
        async function dataInstallations() {
            var result = await $.ajax({
                'url': '/dashboard/installations',
                'type': 'GET',
                'dataType': 'json',
                'success': function(result) {
                    return result
                }
            })

            return result;
        }

        async function dataUsages() {
            var result = await $.ajax({
                'url': '/dashboard/usages',
                'type': 'GET',
                'dataType': 'json',
                'success': function(result) {
                    return result
                }
            })

            return result;
        }

        async function dataTagihan() {
            var result = await $.ajax({
                'url': '/dashboard/tagihan',
                'type': 'GET',
                'dataType': 'json',
                'success': function(result) {
                    return result
                }
            })

            return result;
        }

        $(document).on('click', '#BtnModalInstalasi', async function(e) {
            e.preventDefault();
            var result = await dataInstallations();

            var Permohonan = result.Permohonan;
            var Pasang = result.Pasang;
            var Aktif = result.Aktif;

            $('#TablePermohonan').html('');
            Permohonan.forEach((item, index) => {
                $('#TablePermohonan').append(`
                    <tr>
                        <td>${item.kode_instalasi}</td>
                        <td>${item.customer.nama}</td>
                        <td>${item.customer.alamat}</td>
                        <td>${item.package.kelas}</td>
                        <td>${item.order}</td>
                    </tr>
                `)
            })

            $('#TablePasang').html('');
            Pasang.forEach((item, index) => {
                $('#TablePasang').append(`
                    <tr>
                        <td>${item.kode_instalasi}</td>
                        <td>${item.customer.nama}</td>
                        <td>${item.customer.alamat}</td>
                        <td>${item.package.kelas}</td>
                        <td>${item.order}</td>
                    </tr>
                `)
            })

            $('#TableAktif').html('');
            Aktif.forEach((item, index) => {
                $('#TableAktif').append(`
                    <tr>
                        <td>${item.kode_instalasi}</td>
                        <td>${item.customer.nama}</td>
                        <td>${item.customer.alamat}</td>
                        <td>${item.package.kelas}</td>
                        <td>${item.aktif}</td>
                    </tr>
                `)
            })

            $('#ModalInstalasi').modal('toggle');
        });

        $(document).on('click', '#BtnModalPemakaian', async function(e) {
            e.preventDefault();
            var result = await dataUsages();
            var Pemakaian = result.Usages;

            var data = 0;
            var empty = 0;
            $('#TablePemakaian').html('');
            Pemakaian.forEach((item, index) => {
                if (item.one_usage == null) {
                    empty += 1;
                } else {
                    $('#TablePemakaian').append(`
                        <tr>
                            <td>${item.kode_instalasi}</td>
                            <td>${item.customer.nama}</td>
                            <td>${item.package.kelas}</td>
                            <td>${item.one_usage.akhir}</td>
                        </tr>
                    `)
                }

                data += 1
            })

            if (data - empty == 0) {
                $('#TablePemakaian').append(`
                        <tr>
                            <td align="center" colspan="4">Tidak ada data pemakaian</td>
                        </tr>
                    `)
            }

            $('#ModalPemakaian').modal('toggle');
        });

        $(document).on('click', '#BtnModalTagihan', async function(e) {
            e.preventDefault();
            var result = await dataTagihan();
            var Tagihan = result.Tagihan;
            var setting = result.setting;
            var block = result.block


            $('#TableTagihan').html('');
            Tagihan.forEach((item, index) => {
                var paket = JSON.parse(item.installation.package.harga)
                $('#TableTagihan').append(`
                <tr>
                    <td>${item.installation.kode_instalasi}</td>
                    <td>${item.installation.customer.nama}</td>
                    <td>${item.tgl_akhir}</td>
                    <td>${item.jumlah}</td>
                    <td>${paket[block[item.jumlah]]}</td>
                </tr>
            `)
            })

            $('#ModalTagihan').modal('toggle');
        });

        $(document).on('click', '.btn-modal-close', function(e) {
            e.preventDefault();

            $('.modal').modal('hide');
        });
    </script>
@endsection
