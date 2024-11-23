@extends('layouts.base')

@section('content')

<div class="container-fluid" id="container-wrapper">
    <div class="col-lg-13">
        <div class="card mb-4">
            <div class="card-body">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" data-target="#Permohonan" href="#">Permohonan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" data-target="#Pasang" href="#">Pasang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" data-target="#Aktif" href="#">Aktif</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" data-target="#Blokir" href="#">Blokir</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" data-target="#Cabut" href="#">Cabut</a>
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
                            <table class="table align-items-center table-flush" id="TbPermohonan">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Permohonan</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>$320,800</td>
                                        <td style="text-align: center;">
                                            <a href="" class="btn btn-warning mx-1"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="" class="btn btn-danger mx-1"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pasang Tab -->
        <div id="Pasang" role="tab" class="tab-pane">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-flush" id="TbPasang">
                                <thead class="thead-light">
                                    <tr>
                                        <th>pasang</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>$320,800</td>
                                        <td style="text-align: center;">
                                            <a href="" class="btn btn-warning mx-1"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="" class="btn btn-danger mx-1"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
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
                            <table class="table align-items-center table-flush" id="TbAktif">
                                <thead class="thead-light">
                                    <tr>
                                        <th>aktif</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>$320,800</td>
                                        <td style="text-align: center;">
                                            <a href="" class="btn btn-warning mx-1"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="" class="btn btn-danger mx-1"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
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
                            <table class="table align-items-center table-flush" id="TbBlokir">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Blokir</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>$320,800</td>
                                        <td style="text-align: center;">
                                            <a href="" class="btn btn-warning mx-1"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="" class="btn btn-danger mx-1"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
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
                            <table class="table align-items-center table-flush" id="TbCabut">
                                <thead class="thead-light">
                                    <tr>
                                        <th>cabut</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>$320,800</td>
                                        <td style="text-align: center;">
                                            <a href="" class="btn btn-warning mx-1"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="" class="btn btn-danger mx-1"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
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
