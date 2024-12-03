@extends('layouts.base')

@section('content')

<div class="container-fluid" id="container-wrapper">
    <div class="col-lg-13">
        <div class="card mb-4">
            <div class="card-body">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" data-target="#Permohonan"
                            href="#"><b>Permohonan(P)</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" data-target="#Pasang" href="#"><b>Pasang (S)</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" data-target="#Aktif" href="#"><b>Aktif(A)</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" data-target="#Blokir" href="#"><b>Blokir(B)</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" data-target="#Cabut" href="#"><b>Cabut(C)</b></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" id="container-wrapper">
    <div id="tabsContent" class="tab-content">
        <!-- Permohonan Tab -->
        <div id="Permohonan" role="tab" class="tab-pane active show">
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
                                            <a href="" class="btn-sm btn-warning mx-1"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                            <a href="" class="btn-sm btn-danger mx-1"><i
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
        <div id="Pasang" role="tab" class="tab-pane ">
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
                                        <td>{{ ($status_s->village) ? $status_s->village->nama:'' }}</td>
                                        <td>{{ ($status_S->package) ? $status_S->package->kelas:'' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($status_S->order)->format('d-m-Y') }}</td>

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

        <!-- Aktif Tab -->
        <div id="Aktif" role="tab" class="tab-pane">
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
        <div id="Blokir" role="tab" class="tab-pane">
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
        <div id="Cabut" role="tab" class="tab-pane">
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

</script>
@endsection
