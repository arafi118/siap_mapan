@extends('layouts.base')

@section('content')
    <form action="/villages/{{ $village->id }}" method="post" id="Formdesa">
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
                                        <b>Edit Data Desa</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="kode" id="kode" value="{{ $village->kode }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="kode">Kode</label>
                                        <input autocomplete="off" maxlength="16" type="text" name="kode"
                                            id="kode" class="form-control" value="{{ $village->kode }}" disabled>
                                        <small class="text-danger" id="msg_kode">{{ $errors->first('kode') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="nama">Nama Desa</label>
                                        <input autocomplete="off" type="text" name="nama" id="nama"
                                            class="form-control" value="{{ $village->nama }}">
                                        <small class="text-danger" id="msg_nama">{{ $errors->first('nama') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="position-relative mb-3">
                                        <label for="dusun">Dusun/Pedukuhan</label>
                                        <input type="text" name="dusun" id="dusun" value="{{ $village->dusun }}"
                                            class="form-control">
                                        <small class="text-danger" id="msg_dusun"></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="position-relative mb-3">
                                        <label for="hp">No Hp</label>
                                        <input type="text" name="hp" id="hp" value="{{ $village->hp }}"
                                            class="form-control">
                                        <small class="text-danger" id="msg_hp"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="alamat">Alamat</label>
                                        <input autocomplete="off" type="text" name="alamat" id="alamat"
                                            class="form-control" value="{{ $village->alamat }}">
                                        <small class="text-danger">{{ $errors->first('alamat') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button id="kembali" class="btn btn-light btn-icon-split">
                                    <span class="icon text-white-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-sign-turn-slight-left-fill"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM6.864 8.368a.25.25 0 0 1-.451-.039l-1.06-2.882a.25.25 0 0 1 .192-.333l3.026-.523a.25.25 0 0 1 .26.371l-.667 1.154.621.373A2.5 2.5 0 0 1 10 8.632V11H9V8.632a1.5 1.5 0 0 0-.728-1.286l-.607-.364-.8 1.386Z" />
                                        </svg>
                                    </span>
                                    <span class="text">Kembali</span>
                                </button>

                                <button class="btn btn-secondary btn-icon-split" id="SimpanDesa"
                                    type="submit"style="float: right; margin-left: 10px;">
                                    <span class="icon text-white-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                        </svg>
                                    </span>
                                    <span class="text" style="float: right;">Simpan Perubahan</span>
                                </button>
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
        $(document).on('click', '#kembali', function(e) {
            e.preventDefault();
            window.location.href = '/villages';
        });
    </script>
@endsection
