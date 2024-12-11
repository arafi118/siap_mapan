@extends('layouts.base')

@section('content')
@if (session('success'))
<div id="success-alert" class="alert alert-success alert-dismissible fade show text-center" role="alert">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<form action="/hamlets" method="post" id="inputDusun">
    @csrf
    <!-- Alert -->
    <!-- Form Card -->
    <div class="card">
        <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        Catatan : ( Jika Ada data atau inputan yang kosong bisa di isi ( 0 ) atau ( - ) )
    </div>
        <div class="card-body">
            <!-- Form Inputs -->
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="position-relative mb-3">
                        <label for="id_desa">Desa/Kelurahan</label>
                        <select class="js-select-2 form-control" name="id_desa" id="id_desa">
                            <option>Pilih Desa/Kelurahan</option>
                            @foreach ($desa as $ds)
                            <option value="{{ $ds->id }}">
                                {{ $ds->nama }}
                            </option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="msg_id_desa"></small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="position-relative mb-3">
                        <label for="dusun">Dusun</label>
                        <input autocomplete="off" type="text" name="dusun" id="dusun" class="form-control">
                        <small class="text-danger" id="msg_dusun">{{ $errors->first('dusun') }}</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="position-relative mb-3">
                        <label for="alamat">Alamat</label>
                        <input autocomplete="off" type="text" name="alamat" id="alamat" class="form-control">
                        <small class="text-danger" id="msg_alamat">{{ $errors->first('alamat') }}</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="position-relative mb-3">
                        <label for="hp">Telpon</label>
                        <input autocomplete="off" type="text" name="hp" id="hp" class="form-control">
                        <small class="text-danger" id="msg_hp">{{ $errors->first('hp') }}</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="/hamlets" class="btn btn-primary btn-sm">Kembali</a>
            <button type="submit" class="btn btn-dark btn-sm" id="SimpanDusun">Simpan</button>
        </div>
        
    </div>
</form>

@endsection

@section('script')
<script>
    document.getElementById("close").addEventListener("click", function () {
        window.location.href = "/hamlets"; // Ganti "/dusun" dengan URL yang sesuai
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
