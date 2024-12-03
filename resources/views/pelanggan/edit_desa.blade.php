@extends('layouts.base')

@section('content')
<form action="/villages/{{ $village->id }}" method="post" id="desa">
    @csrf
    @method('PUT')
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div style="display: flex; align-items: center;">
                                    <i class="fa fa-user-secret" style="font-size: 30px; margin-right: 13px;"></i>
                                    <b>Edit Desa</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="kode" id="kode" value="{{ $village->kode }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="kode">Kode</label>
                                    <input autocomplete="off" maxlength="16" type="text" name="kode" id="kode"
                                        class="form-control" value="{{ $village->kode }}">
                                    <small class="text-danger" id="msg_kode">{{ $errors->first('kode') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="nama">Nama Desa</label>
                                    <input autocomplete="off" type="text" name="nama" id="nama" class="form-control"
                                        value="{{ $village->nama }}">
                                    <small class="text-danger" id="msg_nama">{{ $errors->first('nama') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="alamat">Alamat</label>
                                    <input autocomplete="off" type="text" name="alamat" id="alamat" class="form-control"
                                        value="{{ $village->alamat }}">
                                    <small class="text-danger">{{ $errors->first('alamat') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="hp">Telpon</label>
                                    <input autocomplete="off" type="text" name="hp" id="hp" class="form-control"
                                        value="{{ $village->hp }}">
                                    <small class="text-danger">{{ $errors->first('hp') }}</small>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm" id="close">Close</button>
                        <button type="submit" class="btn btn-dark btn-sm float-end" id="SimpanDesa">Simpan Desa</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('script')
<script>
    document.getElementById("close").addEventListener("click", function () {
        window.location.href = "/villages"; // Ganti "/village" dengan URL yang sesuai
    });
</script>
@endsection