@php
    $logo = $user->foto;
    if ($logo == 'no_image.png') {
        $logo = '/assets/img/' . $logo;
    } else {
        $logo = '/storage/profil/' . $logo;
    }
@endphp

@extends('layouts.base')

@section('content')
    <div class="main-body mb-3">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="{{ $logo }}" alt="User" class="rounded-circle p-1 bg-primary" width="110">
                            <div class="mt-3">
                                <h4 class="NamaUser">{{ $user->nama }}</h4>
                                <p class="text-secondary mb-1">{{ $user->jabatan }}</p>
                                <p class="text-muted font-size-sm AlamatUser mb-1">{{ $user->alamat }}</p>
                            </div>
                        </div>

                        <hr class="my-3">
                        <form action="/profil/data_login" method="post" id="FormDataLogin">
                            @csrf

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" id="username"
                                    value="{{ $user->username }}">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="konfirmasi_password"
                                    id="konfirmasi_password" placeholder="Konfirmasi Password">
                                <sup>(Kosongkan password jika tidak ingin diubah)</sup>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" id="BtnSimpanDataLogin" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header pt-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Data Diri</h6>
                    </div>
                    <div class="card-body">
                        <form action="/profil" method="post" id="FormDataDiri">
                            @csrf

                            <div class="form-group row">
                                <label for="nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama" id="nama"
                                        value="{{ $user->nama }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="alamat" id="alamat"
                                        value="{{ $user->alamat }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telpon" class="col-sm-3 col-form-label">Telpon</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="telpon" id="telpon"
                                        value="{{ $user->telpon }}">
                                </div>
                            </div>
                            <fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-label col-sm-3 pt-0">Jenis Kelamin</legend>
                                    <div class="col-sm-9">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" {{ $user->jenis_kelamin == 'L' ? 'checked' : '' }}
                                                id="laki_laki" name="jenis_kelamin" class="custom-control-input"
                                                value="L">
                                            <label class="custom-control-label" for="laki_laki">Laki Laki</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" {{ $user->jenis_kelamin == 'P' ? 'checked' : '' }}
                                                id="perempuan" name="jenis_kelamin" class="custom-control-input"
                                                value="P">
                                            <label class="custom-control-label" for="perempuan">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group row mb-0">
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="button" id="BtnSimpanDataDiri" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).on('click', '#BtnSimpanDataLogin', function(e) {
            e.preventDefault();

            var password = $('#password').val();
            var konfirmasi_password = $('#konfirmasi_password').val();

            if (password != konfirmasi_password && password != '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Konfirmasi password tidak sama',
                })
                return;
            } else {
                var form = $('#FormDataLogin');
                $.ajax({
                    url: form.attr('action'),
                    type: 'post',
                    data: form.serialize(),
                    success: function(data) {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: data.message,
                            }).then((result) => {
                                window.location.href = '/auth';
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: data.message,
                            })
                        }
                    }
                })
            }
        })

        $(document).on('click', '#BtnSimpanDataDiri', function(e) {
            e.preventDefault();

            var form = $('#FormDataDiri');
            $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: form.serialize(),
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message,
                        })

                        $('.NamaUser').text(data.nama);
                        $('.AlamatUser').text(data.alamat);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message,
                        })
                    }
                }
            })
        })
    </script>
@endsection
