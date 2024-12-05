@php
$status = Request::get('status');

$tombolP = '';
$tombolS = '';
$tombolA = '';
$tombolB = '';
$tombolC = '';
switch ($status) {
case 'P':
$tombolP = 'active';
break;
case 'S':
$tombolS = 'active';
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
$tombolP = 'active';
break;
}
@endphp

@extends('layouts.base')

@section('content')

<div class="container-fluid" id="container-wrapper">
    <div class="col-lg-13">
        <div class="card mb-4">
            <div class="card-body">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link {{ $tombolP }}" data-status="P" data-toggle="tab" data-target="#Permohonan"
                            href="#"><b>Permohonan (P)</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $tombolS }}" data-status="S" data-toggle="tab" data-target="#Pasang"
                            href="#"><b>Pasang (S)</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $tombolA }}" data-status="A" data-toggle="tab" data-target="#Aktif"
                            href="#"><b>Aktif (A)</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $tombolB }}" data-status="B" data-toggle="tab" data-target="#Blokir"
                            href="#"><b>Blokir (B)</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $tombolC }}" data-status="C" data-toggle="tab" data-target="#Cabut"
                            href="#"><b>Cabut (C)</b></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" id="container-wrapper">
    <div id="tabsContent" class="tab-content">
        <!-- Permohonan Tab -->
        <div id="Permohonan" role="tab" class="tab-pane {{ $tombolP }}">
            <!-- Content for Permohonan -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-flush table-hover" id="TbPermohonan">
                                <thead class="thead-light">
                                    <tr>
                                        <th>kode instalasi</th>
                                        <th>Customer</th>
                                        <th>alamat</th>
                                        <th>Paket</th>
                                        <th>Tanggal Order</th>
                                        <th>Status</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($status_P as $status_P)
                                    <tr>
                                        <td>{{ $status_P->kode_instalasi }}</td>
                                        <td>{{ ($status_P->customer) ? $status_P->customer->nama:'' }}</td>
                                        <td>{{ ($status_P->village) ? $status_P->village->nama:'' }}</td>
                                        <td>{{ ($status_P->package) ? $status_P->package->kelas:'' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($status_P->order)->format('d-m-Y') }}</td>
                                        <td>
                                            @if($status_P->status === 'P')
                                            <span class="badge badge-success">Lunas</span>
                                            @elseif($status_P->status === '0')
                                            <span class="badge badge-warning">Pengajuan</span>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="/installations/{{ $status_P->id}}" class="btn-sm btn-primary"><i
                                                    class="fa fa-exclamation-circle"></i></a>
                                            <a href="/installations/{{ $status_P->id}}/edit"
                                                class="btn-sm btn-warning mx-1"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="#" data-id="{{ $status_P->id }}"
                                                class="btn-sm btn-danger mx-1 Hapus_id"><i
                                                    class="fas fa-trash-alt"></i></a>
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
        <div id="Pasang" role="tab" class="tab-pane {{ $tombolS }}">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-flush table-hover" id="TbPasang">
                                <thead class="thead-light">
                                    <tr>
                                        <th>kode instalasi</th>
                                        <th>Customer</th>
                                        <th>alamat</th>
                                        <th>Paket</th>
                                        <th>Tanggal Order</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($status_S as $status_S)
                                    <tr>
                                        <td>{{ $status_S->kode_instalasi }}</td>
                                        <td>{{ ($status_S->customer) ? $status_S->customer->nama:'' }}</td>
                                        <td>{{ ($status_P->village) ? $status_P->village->nama:'' }}</td>
                                        <td>{{ ($status_S->package) ? $status_S->package->kelas:'' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($status_S->order)->format('d-m-Y') }}</td>

                                        <td style="text-align: center;">
                                            <a href="/installations/{{ $status_S->id}}" class="btn-sm btn-primary"><i
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
                                        <th>kode instalasi</th>
                                        <th>Customer</th>
                                        <th>alamat</th>
                                        <th>Paket</th>
                                        <th>Tanggal Aktif</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($status_A as $status_A)
                                    <tr>
                                        <td>{{ $status_A->kode_instalasi }}</td>
                                        <td>{{ ($status_A->customer) ? $status_A->customer->nama:'' }}</td>
                                        <td>{{ ($status_A->village) ? $status_A->village->nama:'' }}</td>
                                        <td>{{ ($status_A->package) ? $status_A->package->kelas:'' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($status_A->order)->format('d-m-Y') }}</td>

                                        <td style="text-align: center;">
                                            <a href="" class="btn-sm btn-primary"><i
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
                                        <th>kode instalasi</th>
                                        <th>Customer</th>
                                        <th>alamat</th>
                                        <th>Paket</th>
                                        <th>Tanggal Blokir</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($status_B as $status_B)
                                    <tr>
                                        <td>{{ $status_B->kode_instalasi }}</td>
                                        <td>{{ ($status_B->customer) ? $status_B->customer->nama:'' }}</td>
                                        <td>{{ ($status_B->village) ? $status_B->village->nama:'' }}</td>
                                        <td>{{ ($status_B->package) ? $status_B->package->kelas:'' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($status_B->order)->format('d-m-Y') }}</td>

                                        <td style="text-align: center;">
                                            <a href="" class="btn-sm btn-primary"><i
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
                                        <th>kode instalasi</th>
                                        <th>Customer</th>
                                        <th>alamat</th>
                                        <th>Paket</th>
                                        <th>Tanggal Cabut</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($status_C as $status_C)
                                    <tr>
                                        <td>{{ $status_C->kode_instalasi }}</td>
                                        <td>{{ ($status_C->customer) ? $status_C->customer->nama:'' }}</td>
                                        <td>{{ ($status_C->village) ? $status_C->village->nama:'' }}</td>
                                        <td>{{ ($status_C->package) ? $status_C->package->kelas:'' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($status_C->order)->format('d-m-Y') }}</td>

                                        <td style="text-align: center;">
                                            <a href="" class="btn-sm btn-primary"><i
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
    $(document).ready(function () {
        $('#TbPermohonan').DataTable(); // ID From dataTable 
        $('#TbPasang').DataTable();
        $('#TbAktif').DataTable();
        $('#TbBlokir').DataTable();
        $('#TbCabut').DataTable();
    });

    $(document).on('click', '.Hapus_id', function (e) {
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
                    success: function (response) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.message || "Data berhasil dihapus.",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload()
                            } else {
                                window.location.href = '/installations/' + result
                                    .installation
                                    .id;
                            }
                        });
                    },
                    error: function (response) {
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

    $('.nav-pills>.nav-item>.nav-link').on('click', function () {
        var status = $(this).attr('data-status')
        window.history.pushState({}, "", '/installations?status=' + status);
    });

</script>
@endsection
