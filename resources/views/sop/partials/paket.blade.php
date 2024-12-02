@extends('layouts.base')

@section('content')
<form action="/packages" method="post" id="paket">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div style="display: flex; align-items: center;">
                                    <i class="fa fa-cubes" style="font-size: 30px; margin-right: 7px;"></i>
                                    <b>Tambah Data</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>&nbsp;</div>
                    <div class="row">
                        <div class="col-3">
                            <div class="position-relative mb-2">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input autocomplete="off" maxlength="16" type="text" name="kelas" id="kelas" class="form-control form-control-sm">
                                <small class="text-danger" id="msg_kelas">{{ $errors->first('kelas') }}</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="position-relative mb-2">
                                <label for="harga" class="form-label">Harga</label>
                                <input autocomplete="off" type="text" name="harga" id="harga" class="form-control form-control-sm">
                                <small class="text-danger" id="msg_harga">{{ $errors->first('harga') }}</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="position-relative mb-2">
                                <label for="harga1" class="form-label">Harga1</label>
                                <input autocomplete="off" type="text" name="harga1" id="harga1" class="form-control form-control-sm">
                                <small class="text-danger" id="msg_harga1">{{ $errors->first('harga1') }}</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="position-relative mb-2">
                                <label for="beban" class="form-label">Beban</label>
                                <input autocomplete="off" type="text" name="beban" id="beban" class="form-control form-control-sm">
                                <small class="text-danger" id="msg_beban">{{ $errors->first('beban') }}</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="position-relative mb-2">
                                <label for="denda" class="form-label">Denda</label>
                                <input autocomplete="off" type="text" name="denda" id="denda" class="form-control form-control-sm">
                                <small class="text-danger" id="msg_denda">{{ $errors->first('denda') }}</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="font-icon-wrapper">
                                <p><b>Catatan : </b> ( Jika Ada data atau inputan yang kosong bisa di isi ( 0 ) atau ( - ) )</p>
                            </div>
                        </div>
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-primary btn-sm" id="SimpanPaket" 
                            style="background-color: rgb(78, 68, 68); color: white; border-color: black;">
                            Simpan
                        </button>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
