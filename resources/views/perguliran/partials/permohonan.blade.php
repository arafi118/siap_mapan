@extends('layouts.base')

@section('content')
<!-- Form -->
<form action="/packages/{{ $package->id }}" method="post" id="paket">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div style="display: flex; align-items: center;">
                                    <i class="fa fa-cubes" style="font-size: 30px; margin-right: 7px;"></i>
                                    <b>Edit Data</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>&nbsp;</div>
                    <div class="row">
                        <div class="col-3">
                            <div class="position-relative mb-2">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input autocomplete="off" maxlength="16" type="text" name="kelas" id="kelas"
                                    class="form-control form-control-sm" value="{{ $package->alamat }}">
                                <small class="text-danger" id="msg_kelas">{{ $errors->first('kelas') }}</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="font-icon-wrapper">
                                <p><b>Catatan : </b> ( Jika Ada data atau inputan yang kosong bisa di isi ( 0 ) atau ( -
                                    ) )</p>
                            </div>
                        </div>
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-primary btn-sm" id="SimpanPaket">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
