@extends('layouts.base')

@section('content')

<!-- Row -->
<!-- Row -->
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <!-- Bagian kiri: Rekening -->
            <div style="display: flex; align-items: center;">
                <i class="far fa-credit-card" style="font-size: 20px; margin-right: 5px;"></i>
                <b>Rekening</b>
            </div>
            <!-- Bagian kanan: Tombol -->
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#RegisterRekening" id="#myBtn">
                    Register Rekening
                </button>
            </div>
        </div>
    </div>
    
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="dataTable">
                    <thead class="thead-light">
                        <div>&nbsp;</div>
                        <tr>
                            <th>KODE AKUN</th>
                            <th>NAMA AKUN</th>
                            <th>JENIS MUTASI</th>
                            <th style="text-align: center;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekening as $rek)
                        <tr>
                            <td>{{ $rek->kode_akun}}</td>
                            <td>{{ $rek->nama_akun }}</td>
                            <td>{{ $rek->jenis_mutasi }}</td>
                            <td style="text-align: center;"> 
                                <a href="/packages/{{ $rek->kode_akun }}/edit" class="btn btn-warning"><i class=" fas fa-pencil-alt"></i></a>
                                <a href="/packages/{{ $rek->kode_akun }}" class="btn btn-danger"><i class=" fas fa-trash-alt"></i></a>
                              </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="RegisterRekeningLabelLogout"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="RegisterRekeningLabelLogout">Ohh No!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to logout?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                <a href="login.html" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('modal')
    @include('rekening.create')
@endsection
