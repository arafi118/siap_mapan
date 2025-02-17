@extends('layouts.base')

@section('content')
    <style>
        .custom-alert {
            padding: 20px;
            /* Jarak seragam di semua sisi dalam alert */
            border-radius: 5px;
            /* Membuat sudut sedikit melengkung */
            margin: 1px;
            /* Menambahkan jarak di luar alert */
        }
    </style>

    <form action="/caters/{{ $cater->id }}" method="post" id="forcater">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
                <!-- Alerts with Icon -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="alert alert-info alert-dismissible custom-alert" role="alert">
                            <h6><i class="fas fa-info-circle"></i>&nbsp;<b> Form Edit Data Cater !</b></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="table-responsive p-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="nama">Nama</label>
                                    <input autocomplete="off" type="text" name="nama" id="nama"
                                        value="{{ $cater->nama }}" class="form-control">
                                    <small class="text-danger" id="msg_nama">{{ $errors->first('nama') }}</small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="position-relative mb-3">
                                    <label for="wilayah">Wilayah</label>
                                    <input autocomplete="off" type="text" name="wilayah" id="wilayah"
                                        value="{{ $cater->wilayah }}" class="form-control">
                                    <small class="text-danger" id="msg_wilayah">{{ $errors->first('wilayah') }}</small>
                                    {{-- <select class="select2 form-control" name="jabatan" id="jabatan">
                                        <option value="" disabled {{ $cater->position ? '' : 'selected' }}>Pilih
                                            Jabatan</option>
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}"
                                                {{ $cater->position && $cater->position->id == $position->id ? 'selected' : '' }}>
                                                {{ $position->nama_jabatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="msg_jabatan"></small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="position-relative mb-3">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="select2 form-control" name="jenis_kelamin" id="jenis_kelamin">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option {{ $cater->jenis_kelamin == 'L' ? 'selected' : '' }} value="L">
                                            Laki-Laki</option>
                                        <option {{ $cater->jenis_kelamin == 'P' ? 'selected' : '' }} value="P">
                                            Perempuan</option>
                                    </select>
                                    <small class="text-danger">{{ $errors->first('jenis_kelamin') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="alamat">ALamat</label>
                                    <input autocomplete="off" type="text" name="alamat" id="alamat"
                                        value="{{ $cater->alamat }}" class="form-control">
                                    <small class="text-danger" id="msg_alamat">{{ $errors->first('alamat') }}</small>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="telpon">No Telpon</label>
                                    <input autocomplete="off" type="text" name="telpon" id="telpon"
                                        value="{{ $cater->telpon }}" class="form-control">
                                    <small class="text-danger" id="msg_telpon">{{ $errors->first('telpon') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="username">Username</label>
                                    <input autocomplete="off" type="text" name="username" id="username"
                                        value="{{ $cater->username }}" class="form-control">
                                    <small class="text-danger" id="msg_username">{{ $errors->first('username') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="password">Pasword</label>
                                    <input autocomplete="off" type="text" name="password" id="password"
                                        value="{{ $cater->password }}" class="form-control">
                                    <small class="text-danger" id="msg_password">{{ $errors->first('password') }}</small>
                                </div>
                            </div>
                        </div>
                        <div>
                            Catatan : ( Jika Ada data atau inputan yang kosong bisa di isi ( 0 ) atau ( - ) )
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button id="kembali" class="btn btn-light btn-icon-split">
                                <span class="icon text-white-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-sign-turn-slight-left-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM6.864 8.368a.25.25 0 0 1-.451-.039l-1.06-2.882a.25.25 0 0 1 .192-.333l3.026-.523a.25.25 0 0 1 .26.371l-.667 1.154.621.373A2.5 2.5 0 0 1 10 8.632V11H9V8.632a1.5 1.5 0 0 0-.728-1.286l-.607-.364-.8 1.386Z" />
                                    </svg>
                                </span>
                                <span class="text">Kembali</span>
                            </button>

                            <button class="btn btn-secondary btn-icon-split" id="SimpanCater"
                                type="submit"style="float: right; margin-left: 10px;">
                                <span class="icon text-white-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                    </svg>
                                </span>
                                <span class="text" style="float: right;">Simpan Caater</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script>
        $(document).on('click', '#kembali', function(e) {
            e.preventDefault();
            window.location.href = '/caters';
        });

        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endsection
