@extends('layouts.base')

@section('content')

<div class="col-lg-13">
    <div class="card mb-4">
        <div class="card-body button-group">
            <button type="button" class="btn btn-outline-primary mb-1">Order (O)</button>
            <button type="button" class="btn btn-outline-primary mb-1">Pasang (P)</button>
            <button type="button" class="btn btn-outline-primary mb-1">Aktif (A)</button>
            <button type="button" class="btn btn-outline-primary mb-1">Blokir (B)</button>
            <button type="button" class="btn btn-outline-primary mb-1">Cabut (C)</button>

        </div>
    </div>
</div>
</div>
<div class="container-fluid" id="container-wrapper">
    <!-- Row -->
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">

                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
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
                                    <a href="" class="btn btn-warning"><i class=" fas fa-pencil-alt"></i></a>
                                    <a href="" class="btn btn-danger"><i class=" fas fa-trash-alt"></i></a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection
