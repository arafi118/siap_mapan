@php
    $status = Request::get('status');

    $tombolR = '';
    $tombolI = '';
    $tombolA = '';
    $tombolB = '';
    $tombolC = '';
    switch ($status) {
        case 'R':
            $tombolR = 'active';
            break;
        case 'I':
            $tombolI = 'active';
            break;
        case 'A':
            $tombolA = 'active';
            break;
        case 'B':
            $tombolB = 'active';
            break;
        case 'C':
            $tombolC = 'active';
            break;

        default:
            $tombolR = 'active';
            break;
    }
@endphp

@extends('layouts.base')

@section('content')
    <style>
        .nav-pills .nav-link {
            background-color: #f8f9fa;
            /* Warna default */
            color: #000;
            /* Warna teks */
        }

        .nav-pills .nav-link.active {
            background-color: #ff8400 !important;
            /* Warna biru muda */
            color: white !important;
            /* Warna teks saat aktif */
        }
    </style>
    <div class="container-fluid" id="container-wrapper">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body p-0"> <!-- Menghapus padding default card-body -->
                        <ul class="nav nav-pills nav-fill"> <!-- Menambahkan nav-fill untuk lebar sama -->
                            <li class="nav-item">
                                <a class="nav-link {{ $tombolR }} w-100 text-center" data-status="R" data-toggle="tab"
                                    data-target="#Permohonan" href="#"><b>Permohonan ( R )</b></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $tombolI }} w-100 text-center" data-status="I" data-toggle="tab"
                                    data-target="#Pasang" href="#"><b>Pasang ( I )</b></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $tombolA }} w-100 text-center" data-status="A" data-toggle="tab"
                                    data-target="#Aktif" href="#"><b>Aktif ( A )</b></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $tombolB }} w-100 text-center" data-status="B" data-toggle="tab"
                                    data-target="#Blokir" href="#"><b>Blokir ( B )</b></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $tombolC }} w-100 text-center" data-status="C" data-toggle="tab"
                                    data-target="#Cabut" href="#"><b>Cabut ( C )</b></a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" id="container-wrapper">
        <div id="tabsContent" class="tab-content">
            <!-- Permohonan Tab -->
            <div id="Permohonan" role="tab" class="tab-pane {{ $tombolR }}">
                <!-- Content for Permohonan -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="table-responsive p-3">
                                <table class="table align-items-center table-flush table-hover" id="TbPermohonan">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No.Induk</th>
                                            <th>Customer</th>
                                            <th>alamat</th>
                                            <th>Paket</th>
                                            <th>Tanggal Order</th>
                                            <th>Status</th>
                                            <th style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($status_R as $status_R)
                                            <tr>
                                                <td>{{ $status_R->kode_instalasi }}
                                                    {{ substr($status_R->package->kelas, 0, 1) }}</td>
                                                <td>{{ $status_R->customer ? $status_R->customer->nama : '' }}</td>
                                                <td>{{ $status_R->village ? $status_R->village->nama : '' }}</td>
                                                <td>{{ $status_R->package ? $status_R->package->kelas : '' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($status_R->order)->format('d-m-Y') }}</td>
                                                <td>
                                                    @if ($status_R->status === 'R')
                                                        <span class="badge badge-success">PAID</span>
                                                    @elseif($status_R->status === '0')
                                                        <span class="badge badge-warning">UNPAID</span>
                                                    @endif
                                                </td>

                                                <td
                                                    style="text-align: center; display: flex; gap: 5px; justify-content: center;">
                                                    <a href="/installations/{{ $status_R->id }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-info-circle"></i>
                                                    </a>
                                                    <a href="/installations/{{ $status_R->id }}/edit"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                    </a>
                                                    <a href="#" data-id="{{ $status_R->id }}"
                                                        class="btn btn-danger btn-sm Hapus_id">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pasang Tab -->
            <div id="Pasang" role="tab" class="tab-pane {{ $tombolI }}">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="table-responsive p-3">
                                <table class="table align-items-center table-flush table-hover" id="TbPasang">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No.Induk</th>
                                            <th>Customer</th>
                                            <th>alamat</th>
                                            <th>Paket</th>
                                            <th>Tanggal Order</th>
                                            <th>Status</th>
                                            <th style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($status_I as $status_I)
                                            <tr>
                                                <td>{{ $status_I->kode_instalasi }}
                                                    {{ substr($status_I->package->kelas, 0, 1) }}</td>
                                                <td>{{ $status_I->customer ? $status_I->customer->nama : '' }}</td>
                                                <td>{{ $status_I->village ? $status_I->village->nama : '' }}</td>
                                                <td>{{ $status_I->package ? $status_I->package->kelas : '' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($status_I->order)->format('d-m-Y') }}</td>
                                                <td>
                                                    @if ($status_I->status === 'I')
                                                        <span class="badge badge-success">PASANG</span>
                                                    @endif
                                                </td>

                                                <td style="text-align: center;">
                                                    <a href="/installations/{{ $status_I->id }}"
                                                        class="btn-sm btn-primary"><i
                                                            class="fa fa-exclamation-circle"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aktif Tab -->
            <div id="Aktif" role="tab" class="tab-pane {{ $tombolA }}">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="table-responsive p-3">
                                <table class="table align-items-center table-flush table-hover" id="TbAktif">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No.Induk</th>
                                            <th>Customer</th>
                                            <th>alamat</th>
                                            <th>Paket</th>
                                            <th>Tanggal Aktif</th>
                                            <th>Status</th>
                                            <th style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($status_A as $status_A)
                                            <tr>
                                                <td>{{ $status_A->kode_instalasi }}
                                                    {{ substr($status_A->package->kelas, 0, 1) }}</td>
                                                <td>{{ $status_A->customer ? $status_A->customer->nama : '' }}</td>
                                                <td>{{ $status_A->village ? $status_A->village->nama : '' }}</td>
                                                <td>{{ $status_A->package ? $status_A->package->kelas : '' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($status_A->order)->format('d-m-Y') }}</td>
                                                <td>
                                                    @if ($status_A->status === 'A')
                                                        <span class="badge badge-primary">AKTIF</span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center;">
                                                    <a href="/installations/{{ $status_A->id }}"
                                                        class="btn-sm btn-primary"><i
                                                            class="fa fa-exclamation-circle"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blokir Tab -->
            <div id="Blokir" role="tab" class="tab-pane {{ $tombolB }}">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="table-responsive p-3">
                                <table class="table align-items-center table-flush table-hover" id="TbBlokir">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No.Induk</th>
                                            <th>Customer</th>
                                            <th>alamat</th>
                                            <th>Paket</th>
                                            <th>Tanggal Blokir</th>
                                            <th>Status</th>
                                            <th style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($status_B as $status_B)
                                            <tr>
                                                <td>{{ $status_B->kode_instalasi }}
                                                    {{ substr($status_B->package->kelas, 0, 1) }}</td>
                                                <td>{{ $status_B->customer ? $status_B->customer->nama : '' }}</td>
                                                <td>{{ $status_B->village ? $status_B->village->nama : '' }}</td>
                                                <td>{{ $status_B->package ? $status_B->package->kelas : '' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($status_B->order)->format('d-m-Y') }}</td>
                                                <td>
                                                    @if ($status_B->status === 'B')
                                                        <span class="badge badge-warning">BLOKIR</span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center;">
                                                    <a
                                                        href="/installations/{{ $status_B->id }}"class="btn-sm btn-primary"><i
                                                            class="fa fa-exclamation-circle"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Cabut Tab -->
            <div id="Cabut" role="tab" class="tab-pane {{ $tombolC }}">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="table-responsive p-3">
                                <table class="table align-items-center table-flush table-hover" id="TbCabut">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No.Induk</th>
                                            <th>Customer</th>
                                            <th>alamat</th>
                                            <th>Paket</th>
                                            <th>Tanggal Cabut</th>
                                            <th>Status</th>
                                            <th style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($status_C as $status_C)
                                            <tr>
                                                <td>{{ $status_C->kode_instalasi }}
                                                    {{ substr($status_C->package->kelas, 0, 1) }}</td>
                                                <td>{{ $status_C->customer ? $status_C->customer->nama : '' }}</td>
                                                <td>{{ $status_C->village ? $status_C->village->nama : '' }}</td>
                                                <td>{{ $status_C->package ? $status_C->package->kelas : '' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($status_C->order)->format('d-m-Y') }}</td>
                                                <td>
                                                    @if ($status_C->status === 'C')
                                                        <span class="badge badge-danger">CABUT</span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center;">
                                                    <a href="/installations/{{ $status_C->id }}"
                                                        class="btn-sm btn-primary"><i
                                                            class="fa fa-exclamation-circle"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="FormHapus">
        @method('DELETE')
        @csrf
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#TbPermohonan').DataTable(); // ID From dataTable untuk memunculkan search
            $('#TbPasang').DataTable();
            $('#TbAktif').DataTable();
            $('#TbBlokir').DataTable();
            $('#TbCabut').DataTable();
        });

        $(document).on('click', '.Hapus_id', function(e) {
            e.preventDefault();

            var hapus_id = $(this).attr('data-id'); // Ambil ID yang terkait dengan tombol hapus
            var actionUrl = '/installations/' + hapus_id; // URL endpoint untuk proses hapus

            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data Akan dihapus secara permanen dari aplikasi tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#FormHapus')
                    $.ajax({
                        type: form.attr('method'), // Gunakan metode HTTP DELETE
                        url: actionUrl,
                        data: form.serialize(),
                        success: function(response) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: response.message || "Data berhasil dihapus.",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then((res) => {
                                if (res.isConfirmed) {
                                    window.location.reload()
                                } else {
                                    window.location.href = '/installations/';
                                }
                            });
                        },
                        error: function(response) {
                            const errorMsg = "Terjadi kesalahan.";
                            Swal.fire({
                                title: "Error",
                                text: errorMsg,
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: "Dibatalkan",
                        text: "Data tidak jadi dihapus.",
                        icon: "info",
                        confirmButtonText: "OK"
                    });
                }
            });
        });

        $('.nav-pills>.nav-item>.nav-link').on('click', function() {
            var status = $(this).attr('data-status')
            window.history.pushState({}, "", '/installations?status=' + status);
        });
    </script>
@endsection
