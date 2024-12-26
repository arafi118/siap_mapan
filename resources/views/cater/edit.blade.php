@extends('layouts.base')

@section('content')
<form action="/caters/{{ $cater->id }}" method="post" id="forcater">
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
                                    <i class="far fa-clipboard" style="font-size: 30px; margin-right: 13px;"></i>
                                    <b>Edit Cater</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="nama">Nama</label>
                                    <input autocomplete="off" type="text" name="nama" id="nama" class="form-control"
                                        value="{{ $cater->nama }}">
                                    <small class="text-danger" id="msg_nama">{{ $errors->first('nama') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="alamat">Alamat</label>
                                    <input autocomplete="off" type="text" name="alamat" id="alamat" class="form-control"
                                        value="{{ $cater->alamat }}">
                                    <small class="text-danger">{{ $errors->first('alamat') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="js-select-2 form-control" name="jenis_kelamin" id="jenis_kelamin">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option {{ $cater->jenis_kelamin == 'L' ? 'selected' : '' }} value="L">Laki-Laki</option>
                                        <option {{ $cater->jenis_kelamin == 'P' ? 'selected' : '' }} value="P">Perempuan</option>
                                    </select>
                                    <small class="text-danger">{{ $errors->first('jenis_kelamin') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="telpon">Telpon</label>
                                    <input autocomplete="off" type="text" name="telpon" id="telpon" class="form-control"
                                        value="{{ $cater->telpon }}">
                                    <small class="text-danger">{{ $errors->first('telpon') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="jabatan">Jabatan</label>
                                    <input autocomplete="off" type="text" name="jabatan" id="jabatan" class="form-control"
                                        value="{{ $cater->position->nama_jabatan }}">
                                    <small class="text-danger" id="msg_jabatan">{{ $errors->first('jabatan') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="username">Username</label>
                                    <input autocomplete="off" type="text" name="username" id="username" class="form-control"
                                        value="{{ $cater->username }}">
                                    <small class="text-danger" id="msg_username">{{ $errors->first('username') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="password">Password</label>
                                    <input autocomplete="off" type="text" name="password" id="password" class="form-control"
                                        value="{{ $cater->password }}">
                                    <small class="text-danger" id="msg_password">{{ $errors->first('password') }}</small>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm" id="close">Close</button>
                        <button type="submit" class="btn btn-dark btn-sm"id="SimpanCater">Simpan Cater</button>
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
        window.location.href = "/caters"; // Ganti "/cater" dengan URL yang sesuai
    });
</script>
@endsection