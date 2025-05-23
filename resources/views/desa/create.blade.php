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
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <!-- Alerts with Icon -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="alert alert-info alert-dismissible custom-alert" role="alert">
                        <h4><i class="fas fa-info-circle"></i>&nbsp;&nbsp; Register Desa Baru !</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="/villages" method="post" id="FormInputDesa">
        @csrf
        <!-- Alert -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="position-relative mb-3">
                            <label for="provinsi">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="form-control form-control-sm">
                                <option value="">Pilih Nama Provinsi</option>
                                @foreach ($provinsi as $prov)
                                    <option value="{{ $prov->kode }}">
                                        {{ ucwords(strtolower($prov->nama)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative mb-3">
                            <label for="kabupaten">Kabupaten</label>
                            <select name="kabupaten" id="kabupaten" class="form-control form-control-sm">
                                <option value="">Pilih Nama Kabupaten</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="position-relative mb-3">
                            <label for="provinsi">kecamatan</label>
                            <select name="kecamatan" id="kecamatan" class="form-control form-control-sm">
                                <option value="">Pilih Nama Kecamatan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative mb-3">
                            <label for="desa">Desa/Kalurahan</label>
                            <select name="desa" id="desa" class="form-control form-control-sm">
                                <option value="">Pilih Nama Desa</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="position-relative mb-3">
                            <label for="dusun">Dusun/Pedukuhan</label>
                            <input type="text" name="dusun" id="dusun" class="form-control">
                            <small class="text-danger" id="msg_dusun"></small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="position-relative mb-3">
                            <label for="hp">No Hp</label>
                            <input type="text" name="hp" id="hp" class="form-control">
                            <small class="text-danger" id="msg_hp"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative mb-3">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" readonly></textarea>
                            <small class="text-danger" id="msg_alamat"></small>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button class="btn btn-secondary btn-icon-split" id="Simpandesa"
                        type="submit"style="float: right; margin-left: 10px;">
                        <span class="icon text-white-50 d-none d-lg-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                <path
                                    d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                            </svg>
                        </span>
                        <span class="text" style="float: right;">Simpan Desa Baru</span>
                    </button>
                </div>
            </div>

        </div>
    </form> <br>
@endsection

@section('script')
    <script>
        $(document).on('click', '#kembali', function(e) {
            e.preventDefault();
            window.location.href = '/villages';
        });

        $(document).ready(function() {
            $('.form-control-sm').select2({
                theme: 'bootstrap4',
            });
        });


        $(document).on('change', '#provinsi', function() {
            var kode = $(this).val();
            $.get('/ambil_kab/' + kode, function(result) {
                if (result.success) {
                    setSelectValue('kabupaten', result.data);
                }
            });
        });

        $(document).on('change', '#kabupaten', function() {
            var kode = $(this).val();
            $.get('/ambil_kec/' + kode, function(result) {
                if (result.success) {
                    setSelectValue('kecamatan', result.data);
                }
            });
        });

        $(document).on('change', '#kecamatan', function() {
            var kode = $(this).val();
            $.get('/ambil_desa/' + kode, function(result) {
                if (result.success) {
                    setSelectValue('desa', result.data);
                }
            });
        });

        $(document).on('change', '#desa', function() {
            var kode = $(this).val();

            $("#alamat").val('');
            $.get('/set_alamat/' + kode, function(result) {
                if (result.success) {
                    $("#alamat").val(result.alamat);
                }
            });
        });

        function setSelectValue(id, data) {
            var label = ucwords(id);
            $('#' + id).empty();
            $('#' + id).append('<option>-- Pilih ' + label + ' --</option>');
            data.forEach((val) => {
                $('#' + id).append('<option value="' + val.kode + '">' + val.nama + '</option>');
            });
        }

        function ucwords(str) {
            return str.replace(/\b\w/g, function(char) {
                return char.toUpperCase();
            });
        }


        //simpan
        $(document).on('click', '#Simpandesa', function(e) {
            e.preventDefault();
            $('small').html('');

            var form = $('#FormInputDesa');
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            title: result.msg,
                            text: "Tambahkan Register Desa Baru?",
                            icon: "success",
                            showDenyButton: true,
                            confirmButtonText: "Tambahkan",
                            denyButtonText: `Tidak`
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload()
                            } else {
                                window.location.href = '/villages/';
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
