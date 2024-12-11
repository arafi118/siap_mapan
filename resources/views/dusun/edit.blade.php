@extends('layouts.base')

@section('content')
<form action="/hamlets/{{ $hamlet->id }}" method="post" id="dusun">
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
                                    <b>Edit Dusun</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       
                        <div class="row">
                            <!-- Kolom Nama Desa -->
                            <div class="col-md-6">
                                <div class="position-relative mb-3">
                                    <label for="id_desa">Nama Desa</label>
                                    <input autocomplete="off" type="text" name="id_desa" id="id_desa" class="form-control"
                                        value="{{ $hamlet->village->nama }}">
                                    <small class="text-danger" id="msg_id_desa">{{ $errors->first('id_desa') }}</small>
                                </div>
                            </div>
                        
                            <!-- Kolom Alamat -->
                            <div class="col-md-6">
                                <div class="position-relative mb-3">
                                    <label for="alamat">Alamat</label>
                                    <input autocomplete="off" type="text" name="alamat" id="alamat" class="form-control"
                                        value="{{ $hamlet->alamat }}">
                                    <small class="text-danger">{{ $errors->first('alamat') }}</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="hp">Telpon</label>
                                    <input autocomplete="off" type="text" name="hp" id="hp" class="form-control"
                                        value="{{ $hamlet->hp }}">
                                    <small class="text-danger">{{ $errors->first('hp') }}</small>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm" id="close">Close</button>
                        <button type="submit" class="btn btn-dark btn-sm float-end" id="SimpanDusun">Simpan Dusun</button>
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
        window.location.href = "/hamlets"; // Ganti "/hamlet" dengan URL yang sesuai
    });
</script>
@endsection