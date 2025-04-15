@extends('layouts.base')

@section('content')
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
                                    <b>Edit data Pelanggan</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="/customers/{{ $customer->id }}" method="post" id="Penduduk">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="_nik" id="_nik" value="{{ $customer->nik }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="nik">NIK</label>
                                        <input autocomplete="off" maxlength="16" type="text" name="nik"
                                            id="nik" class="form-control" value="{{ $customer->nik }}">
                                        <small class="text-danger" id="msg_nik">{{ $errors->first('nik') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="nama_lengkap">Nama lengkap</label>
                                        <input autocomplete="off" type="text" name="nama_lengkap" id="nama_lengkap"
                                            class="form-control" value="{{ $customer->nama }}">
                                        <small class="text-danger"
                                            id="msg_nama_lengkap">{{ $errors->first('nama_lengkap') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="nama_panggilan">Nama Panggilan</label>
                                        <input autocomplete="off" type="text" name="nama_panggilan" id="nama_panggilan"
                                            class="form-control" value="{{ $customer->nama_panggilan }}">
                                        <small class="text-danger">{{ $errors->first('nama_panggilan') }}</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="tempat_lahir">Tempat Lahir</label>
                                        <input autocomplete="off" type="text" name="tempat_lahir" id="tempat_lahir"
                                            class="form-control" value="{{ $customer->tempat_lahir }}">
                                        <small class="text-danger">{{ $errors->first('tempat_lahir') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" for="tgl_lahir">
                                        <label for="simpleDataInput">Tgl Lahir</label>
                                        <div class="input-group">
                                            <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control date"
                                                value={{ $customer->tgl_lahir }} id="simpleDataInput">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative mb-3">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <select class="js-select-2 form-control" name="jenis_kelamin" id="jenis_kelamin">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option {{ $customer->jk == 'L' ? 'selected' : '' }} value="L">Laki-Laki
                                            </option>
                                            <option {{ $customer->jk == 'P' ? 'selected' : '' }} value="P">Perempuan
                                            </option>
                                        </select>
                                        <small class="text-danger">{{ $errors->first('jenis_kelamin') }}</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="no_telp">No. Telp</label>
                                        <input autocomplete="off" type="text" name="no_telp" id="no_telp"
                                            class="form-control" value="{{ $customer->hp }}">
                                        <small class="text-danger">{{ $errors->first('no_telp') }}</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="pekerjaan">Pekerjaan</label>
                                        <input autocomplete="off" type="text" name="pekerjaan" id="pekerjaan"
                                            class="form-control" value="{{ $customer->pekerjaan }}">
                                        <small class="text-danger">{{ $errors->first('pekerjaan') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="position-relative mb-3">
                                        <label for="alamat">Alamat Lengkap</label>
                                        <input autocomplete="off"type="text" name="alamat" id="alamat"
                                            class="form-control" value="{{ $customer->alamat }}">
                                        <small class="text-danger">{{ $errors->first('alamat') }}</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                <button id="kembali" class="btn btn-light btn-icon-split kembali">
                                    <span class="icon text-white-50 d-none d-lg-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-sign-turn-slight-left-fill"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM6.864 8.368a.25.25 0 0 1-.451-.039l-1.06-2.882a.25.25 0 0 1 .192-.333l3.026-.523a.25.25 0 0 1 .26.371l-.667 1.154.621.373A2.5 2.5 0 0 1 10 8.632V11H9V8.632a1.5 1.5 0 0 0-.728-1.286l-.607-.364-.8 1.386Z" />
                                        </svg>
                                    </span>
                                    <span class="text">Kembali</span>
                                </button>

                                <button class="btn btn-secondary btn-icon-split" id="EditPelanggan"
                                    type="submit"style="float: right; margin-left: 10px;">
                                    <span class="icon text-white-50 d-none d-lg-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                        </svg>
                                    </span>
                                    <span class="text" style="float: right;">Simpan Pelanggan</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('click', '#kembali', function(e) {
        e.preventDefault();
        window.location.href = '/customers';
    });
</script>

<script>
    $(document).ready(function() {
        $('.js-select-2').select2({
            theme: 'bootstrap4',
        });
    });


    jQuery.datetimepicker.setLocale('de');
    $('.date').datetimepicker({
        i18n: {
            de: {
                months: [
                    'Januar', 'Februar', 'März', 'April',
                    'Mai', 'Juni', 'Juli', 'August',
                    'September', 'Oktober', 'November', 'Dezember',
                ],
                dayOfWeek: [
                    "So.", "Mo", "Di", "Mi",
                    "Do", "Fr", "Sa.",
                ]
            }
        },
        timepicker: false,
        format: 'd/m/Y'
    });

    $(document).on('click', '#EditPelanggan', function(e) {
        e.preventDefault();
        $('small').html('');

        var form = $('#Penduduk');
        var actionUrl = form.attr('action');

        $.ajax({
            type: 'POST',
            url: actionUrl,
            data: form.serialize(),
            success: function(result) {
                if (result.success) {
                    toastMixin.fire({
                        title: 'Pembaruhan Kelas & Biaya Pemakaian Berhasil'
                    });

                    setTimeout(() => {
                        window.location.href = '/customers/';
                    }, 1500);
                }
            },
            error: function(result) {
                const response = result.responseJSON;
                Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error');
                if (response && typeof response === 'object') {
                    $.each(response, function(key, message) {
                        $('#' + key)
                            .closest('.input-group.input-group-static')
                            .addClass('is-invalid');

                        $('#msg_' + key).html(message);
                    });
                }
            }
        });
    });
</script>
