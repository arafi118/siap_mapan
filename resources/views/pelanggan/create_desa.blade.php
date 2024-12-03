@extends('layouts.base')

@section('content')
<form action="/villages" method="post" id="desa">
    @csrf
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        Catatan : ( Jika Ada data atau inputan yang kosong bisa di isi ( 0 ) atau ( - ) )
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div style="display: flex; align-items: center;">
                                    <i class="fas fa-clinic-medical" style="font-size: 25px; margin-right: 7px;"></i>
                                    <b>Tambah Desa</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>&nbsp;</div>
                    <div class="row">
                        <div class="col-3">
                            <div class="position-relative mb-2">
                                <label for="kode" class="form-label">KODE</label>
                                <input autocomplete="off" maxlength="16" type="text" name="kode" id="kode" class="form-control form-control-sm">
                                <small class="text-danger" id="msg_kode">{{ $errors->first('kode') }}</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="position-relative mb-2">
                                <label for="nama" class="form-label">NAMA DESA</label>
                                <input autocomplete="off" type="text" name="nama" id="nama" class="form-control form-control-sm">
                                <small class="text-danger" id="msg_nama">{{ $errors->first('nama') }}</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="position-relative mb-2">
                                <label for="alamat" class="form-label">ALAMAT</label>
                                <input autocomplete="off" type="text" name="alamat" id="alamat" class="form-control form-control-sm">
                                <small class="text-danger" id="msg_alamat">{{ $errors->first('alamat') }}</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="position-relative mb-2">
                                <label for="hp" class="form-label">TELPON</label>
                                <input autocomplete="off" type="text" name="hp" id="hp" class="form-control form-control-sm">
                                <small class="text-danger" id="msg_hp">{{ $errors->first('hp') }}</small>
                            </div>
                        </div>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <div class="col-12 text-right">
                            <button type="button" class="btn btn-primary btn-sm" id="close">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm" id="Simpandesa" style="background-color: rgb(72, 72, 72); color: white;">Simpan</button>
                        </div>
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
