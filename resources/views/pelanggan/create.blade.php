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

    <form action="/customers" method="post" id="FormCustommer">
        @csrf
        <!-- Row -->
        <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
                <!-- Alerts with Icon -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="alert alert-success alert-dismissible custom-alert" role="alert">
                            <h6><i class="fas fa-info-circle"></i><b> Success!</b></h6>
                            Register Pelangan Baru !
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
                                    <label for="nik">NIK</label>
                                    <input autocomplete="off" maxlength="16" type="text" name="nik" id="nik"
                                        class="form-control" value="">
                                    <small class="text-danger" id="msg_nik">{{ $errors->first('nik') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="nama_lengkap">Nama lengkap</label>
                                    <input autocomplete="off" type="text" name="nama_lengkap" id="nama_lengkap"
                                        class="form-control">
                                    <small class="text-danger"
                                        id="msg_nama_lengkap">{{ $errors->first('nama_lengkap') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="nama_panggilan">Nama Panggilan</label>
                                    <input autocomplete="off" type="text" name="nama_panggilan" id="nama_panggilan"
                                        class="form-control">
                                    <small class="text-danger">{{ $errors->first('nama_panggilan') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="no_kk">No. KK</label>
                                    <input autocomplete="off" type="text" name="no_kk" id="no_kk"
                                        class="form-control" value="">
                                    <small class="text-danger" id="msg_no_kk">{{ $errors->first('no_kk') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input autocomplete="off" type="text" name="tempat_lahir" id="tempat_lahir"
                                        class="form-control" value="">
                                    <small class="text-danger"
                                        id="msg_tempat_lahir">{{ $errors->first('tempat_lahir') }}</small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="tgl_lahir">Tgl Lahir</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control date" name="tgl_lahir" id="tgl_lahir"
                                            value="{{ date('d/m/Y') }}">
                                        <small
                                            class="text-danger"id="msg_tgl_lahir">{{ $errors->first('tgl_lahir') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="position-relative mb-3">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L">Laki Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                    <small class="text-danger">{{ $errors->first('jenis_kelamin') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-2">
                                <div class="position-relative mb-3">
                                    <label for="no_telp">No. Telepon</label>
                                    <input autocomplete="off" type="text" name="no_telp" id="no_telp"
                                        class="form-control">
                                    <small class="text-danger" id="msg_no_telp">{{ $errors->first('no_telp') }}</small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="position-relative mb-3">
                                    <label for="desa">Desa/Kelurahan</label>
                                    <select class="js-select-2 form-control" name="desa" id="desa">
                                        <option>Pilih Desa/Kelurahan</option>
                                        @foreach ($desa as $ds)
                                            <option value="{{ $ds->id }}">
                                                {{ $ds->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="msg_desa"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="alamat">Alamat KTP</label>
                                    <input autocomplete="off" type="text" name="alamat" id="alamat"
                                        class="form-control" value="">
                                    <small class="text-danger" id="msg_alamat">{{ $errors->first('alamat') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="domisi">Domisili saat ini</label>
                                    <input autocomplete="off" type="text" name="domisi" id="domisi"
                                        class="form-control">
                                    <small class="text-danger" id="msg_domisi">{{ $errors->first('domisi') }}</small>
                                </div>
                            </div>
                        </div>
                        <div>
                            Catatan : ( Jika Ada data atau inputan yang kosong bisa di isi ( 0 ) atau ( - ) )
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-secondary btn-icon-split" id="SimpanPenduduk" type="submit">
                                <span class="icon text-white-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                    </svg>
                                </span>
                                <span class="text" style="float: right;">Simpan Pelanggan</span>
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

        //simpan
        $(document).on('click', '#SimpanPenduduk', function(e) {
            e.preventDefault();
            $('small').html('');

            var form = $('#FormCustommer');
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            title: result.msg,
                            text: "Tambahkan Customer  Baru?",
                            icon: "success",
                            showDenyButton: true,
                            confirmButtonText: "Tambahkan",
                            denyButtonText: `Tidak`
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload()
                            } else {
                                window.location.href = '/customers/';
                            }
                        });
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
@endsection
