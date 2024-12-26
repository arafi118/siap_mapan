@extends('layouts.base')

@section('content')
@if (session('success'))
<div id="success-alert" class="alert alert-success alert-dismissible fade show text-center" role="alert">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<form action="/caters" method="post" id="inputCater">
    @csrf
    <!-- Alert Section -->
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        Catatan : ( Jika Ada data atau inputan yang kosong bisa di isi ( 0 ) atau ( - ) )
    </div>
    <!-- Form Card -->
    <div class="card">
        <div class="card-body">
            <!-- Form Inputs -->
            <div class="row g-3">
                <!-- Jabatan -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input autocomplete="off" type="text" name="nama" id="nama" class="form-control">
                        <small class="text-danger" id="msg_nama">{{ $errors->first('nama') }}</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <select class="js-select-2 form-control" name="jabatan" id="jabatan">
                            <option value="">Pilih Jabatan</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}">{{ $position->nama_jabatan }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="msg_jabatan"></small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="position-relative mb-3">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select class="js-select-2 form-control" name="jenis_kelamin" id="jenis_kelamin">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        <small class="text-danger">{{ $errors->first('jenis_kelamin') }}</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input autocomplete="off" type="text" name="alamat" id="alamat" class="form-control">
                        <small class="text-danger" id="msg_alamat">{{ $errors->first('alamat') }}</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="telpon" class="form-label">Telpon</label>
                        <input autocomplete="off" type="text" name="telpon" id="telpon" class="form-control">
                        <small class="text-danger" id="msg_telpon">{{ $errors->first('telpon') }}</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input autocomplete="off" type="text" name="username" id="username" class="form-control">
                        <small class="text-danger" id="msg_username">{{ $errors->first('username') }}</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input autocomplete="off" type="text" name="password" id="password" class="form-control">
                        <small class="text-danger" id="msg_password">{{ $errors->first('password') }}</small>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Footer -->
        <div class="card-footer text-end">
            <a href="/caters" class="btn btn-primary btn-sm">Kembali</a>
            <button type="submit" class="btn btn-dark btn-sm" id="SimpanCater">Simpan</button>
        </div>
    </div>
</form>
@endsection
@section('script')
<script>
    document.getElementById("close").addEventListener("click", function () {
        window.location.href = "/caters"; // Ganti "/dusun" dengan URL yang sesuai
    });

    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(() => {
                alert.classList.add('d-none');
            }, 5000); // Notifikasi hilang setelah 5 detik
        }
    });
</script>

@endsection
