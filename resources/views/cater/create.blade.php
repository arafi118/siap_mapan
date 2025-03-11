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
    <form action="/caters" method="post" id="FormCater">
        @csrf

        <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
                <!-- Alerts with Icon -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="alert alert-info alert-dismissible custom-alert" role="alert">
                            <h4><i class="fas fa-info-circle"></i>&nbsp;&nbsp; Register Cater Baru !</h4>
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
                                        class="form-control">
                                    <small class="text-danger" id="msg_nama">{{ $errors->first('nama') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="select2 form-control" name="jenis_kelamin" id="jenis_kelamin">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L">Laki Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                    <small class="text-danger">{{ $errors->first('jenis_kelamin') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="alamat">ALamat</label>
                                    <input autocomplete="off" type="text" name="alamat" id="alamat"
                                        class="form-control">
                                    <small class="text-danger" id="msg_alamat">{{ $errors->first('alamat') }}</small>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="telpon">No Telpon</label>
                                    <input autocomplete="off" type="text" name="telpon" id="telpon"
                                        class="form-control">
                                    <small class="text-danger" id="msg_telpon">{{ $errors->first('telpon') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="username">Username</label>
                                    <input autocomplete="off" type="text" name="username" id="username"
                                        class="form-control">
                                    <small class="text-danger" id="msg_username">{{ $errors->first('username') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="password">Pasword</label>
                                    <input autocomplete="off" type="password" name="password" id="password"
                                        class="form-control">
                                    <small class="text-danger" id="msg_password">{{ $errors->first('password') }}</small>
                                </div>
                            </div>
                        </div>
                        <div>
                            Catatan : ( Jika Ada data atau inputan yang kosong bisa di isi ( 0 ) atau ( - ) )
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-secondary btn-icon-split" id="SimpanCater" type="submit">
                                <span class="icon text-white-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                    </svg>
                                </span>
                                <span class="text" style="float: right;">Simpan Cater</span>
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

        //simpan
        $(document).on('click', '#SimpanCater', function(e) {
            e.preventDefault();
            $('small').html('');

            var form = $('#FormCater');
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            title: result.msg,
                            text: "Tambahkan Register Cater Baru?",
                            icon: "success",
                            showDenyButton: true,
                            confirmButtonText: "Tambahkan",
                            denyButtonText: `Tidak`
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload()
                            } else {
                                window.location.href = '/caters/';
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
