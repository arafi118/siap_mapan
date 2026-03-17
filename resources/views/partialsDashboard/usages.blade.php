@extends('layouts.base')

@section('content')
<div class="row">
    <div class="col-12 col-md-6 col-lg-6 mb-3">
        <div class="card overflow-hidden">
            <div class="bg-holder bg-card" style="background-image:url(/assets/img/corner-2.png);"></div>
            <div class="card-body position-relative">
                <h6 class="font-weight-bold">
                    Instalasi Pemakaian Meter Air
                </h6>
                <div class="display-4 fs-5 mb-2 font-weight-normal text-success">
                    {{ $air }}
                </div>
                <a class="font-weight-bold text-nowrap fs-10" href="#" id="BtnModalAir">
                    Lihat Detail
                    <span class="fas fa-angle-right mr-1"></span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6 mb-3">
        <div class="card overflow-hidden">
            <div class="bg-holder bg-card" style="background-image:url(/assets/img/corner-3.png);"></div>
            <div class="card-body position-relative">
                <h6 class="font-weight-bold">
                    Instalasi Retribusi Sampah
                </h6>
                <div class="display-4 fs-5 mb-2 font-weight-normal text-success">
                    {{ $sampah }}
                </div>
                <a class="font-weight-bold text-nowrap fs-10" href="#" id="BtnModalSampah">
                    Lihat Detail
                    <span class="fas fa-angle-right mr-1"></span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-4 mb-3">
        <div class="card overflow-hidden pb-2">
            <canvas id="chartInstalasi" height="260" ></canvas>
        </div>
    </div>
    {{-- <div class="col-12 col-md-8 mb-3">
        <div class="card overflow-hidden">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Kategori</th>
                        <th scope="col">Jumlah Instalasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Instalasi Air</td>
                        <td>{{ $air }}</td>
                    </tr>
                    <tr>
                        <td>Retribusi Sampah</td>
                        <td>{{ $sampah }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> --}}
</div>
@endsection
@section('modal')
<div class="modal fade" id="ModalInstalasi" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTitle">Daftar Instalasi</h5>
            </div>
            <div class="modal-body">
                <table class="table table-flush table-bordered">
                    <thead>
                        <tr>
                            <th>No.Induk</th>
                            <th>Customer</th>
                            <th>Alamat</th>
                            <th>Paket</th>
                            <th>Tanggal Aktif</th>
                        </tr>
                    </thead>
                    <tbody id="TableAktif"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-primary btn-modal-close" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).on('click', '#BtnModalAir', function (e) {
        e.preventDefault();
        loadInstalasi('air');
    });

    $(document).on('click', '#BtnModalSampah', function (e) {
        e.preventDefault();
        loadInstalasi('sampah');
    });

    async function dataInstallations(type) {

        let cater_id = "{{ request()->query('cater_id') }}";

        let response = await $.ajax({
            url: "/dashboard/data-installations",
            type: "GET",
            data: {
                type: type,
                cater_id: cater_id
            }
        });

        return response;
    }

    async function loadInstalasi(type) {
        try {
            if (type == 'air') {
                $('#ModalTitle').text('Daftar Instalasi Air');
            } else {
                $('#ModalTitle').text('Daftar Retribusi Sampah');
            }
            var result = await dataInstallations(type);
            var Aktif = result.Aktif || [];
            $('#TableAktif').html('');
            Aktif.forEach(item => {
                let paket = '-';

                if (type == 'air') {
                    paket = item.package?.kelas??'-';
                }

                if (type == 'sampah') {
                    paket = 'Retribusi Sampah';
                }

                $('#TableAktif').append(`
                <tr>
                    <td>${item.kode_instalasi}</td>
                    <td>${item.customer?.nama ?? '-'}</td>
                    <td>${item.customer?.alamat ?? '-'}, Rw. ${item.rw ?? '-'}, Rt. ${item.rt ?? '-'}</td>
                    <td>${paket}</td>
                    <td>${item.aktif ?? '-'}</td>
                </tr>
            `)
            });
            $('#ModalInstalasi').modal('show');
        } catch (error) {
            alert('Gagal memuat data instalasi.');
        }
    }

    const data = {
        labels: ['Instalasi Air', 'Retribusi Sampah'],
        datasets: [{
            label: 'Jumlah Instalasi',
            data: [{{ $air }}, {{ $sampah }}],   
            backgroundColor: [
                '#e3342f',
                '#3490dc' 
            ],
            borderWidth: 1
        },]
    };

    const config = {
        type: 'pie',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Perbandingan Instalasi Air dan Sampah'
                }
            }
        }
    };

    const ctx = document.getElementById('chartInstalasi').getContext('2d');
    new Chart(ctx, config);

</script>
@endsection
