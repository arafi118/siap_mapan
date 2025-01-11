@extends('layouts.base')

@section('content')
    <form action="/hamlets" method="post" id="inputDusun">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Bagian Informasi Customer -->
                        <div class="alert alert-info d-flex align-items-center m-0 text-black" role="alert"
                            style="border-radius: 1;">
                            {{-- <!-- Gambar -->
                            <img src="../../assets/img/desa.png"
                                style="max-height: 200px; margin-right: 50px; margin-left: 30px;" class="img-fluid"> --}}
                            <!-- Konten Teks -->
                            <div class="flex-grow-1">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="id_desa">Desa/Kelurahan</label>
                                                <select class="select2 form-control" name="id_desa" id="id_desa">
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
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="password">Dusun</label>
                                                <input autocomplete="off" type="text" name="dusun" id="dusun"
                                                    class="form-control">
                                                <small class="text-danger"
                                                    id="msg_dusun">{{ $errors->first('dusun') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="alamat">Alamat</label>
                                                <input autocomplete="off" type="text" name="alamat" id="alamat"
                                                    class="form-control">
                                                <small class="text-danger"
                                                    id="msg_alamat">{{ $errors->first('alamat') }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="hp">Telpon</label>
                                                <input autocomplete="off" type="text" name="hp" id="hp"
                                                    class="form-control">
                                                <small class="text-danger" id="msg_hp">{{ $errors->first('hp') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-2 bg-white">
                                <div>
                                    Catatan : ( Jika Ada data atau inputan yang kosong bisa di isi ( 0 ) atau ( - ) )
                                </div>
                            </div>
                        </div><br>
                        <div class="col-12 d-flex justify-content-end">
                            <a href="/hamlets/" class="btn btn-light btn-icon-split">
                                <span class="icon text-white-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-sign-turn-slight-left-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM6.864 8.368a.25.25 0 0 1-.451-.039l-1.06-2.882a.25.25 0 0 1 .192-.333l3.026-.523a.25.25 0 0 1 .26.371l-.667 1.154.621.373A2.5 2.5 0 0 1 10 8.632V11H9V8.632a1.5 1.5 0 0 0-.728-1.286l-.607-.364-.8 1.386Z" />
                                    </svg>
                                </span>
                                <span class="text">Kembali</span>
                            </a>
                            <button class="btn btn-secondary btn-icon-split" type="submit" id="SimpanDusun"
                                style="float: right; margin-left: 10px;">
                                <span class="icon text-white-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                    </svg>
                                </span>
                                <span class="text" style="float: right;">Simpan Pembayaran</span>
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
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endsection
