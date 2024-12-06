@extends('layouts.base')

@section('content')
<form action="/packages" method="post" id="paket">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Bagian Informasi Customer -->
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <!-- Gambar -->
                        <img src="../../assets/img/air.png" style="max-height: 250px; margin-right: 20px;"
                            class="img-fluid">
                        <div>
                            <h4 class="alert-heading"><b>Tentukan Harga Paket</b></h4>
                            <hr>
                            <div class="row">
                                <div class="col-4">
                                    <div class="position-relative mb-2">
                                        <label for="kelas" class="form-label">Kelas</label>
                                        <input autocomplete="off" maxlength="16" type="text" name="kelas" id="kelas"
                                            class="form-control form-control-sm">
                                        <small class="text-danger" id="msg_kelas"></small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="position-relative mb-2">
                                        <label for="abodemen" class="form-label">Beban</label>
                                        <input autocomplete="off" type="text" name="abodemen" id="abodemen"
                                            class="form-control form-control-sm">
                                        <small class="text-danger" id="msg_abodemen"></small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="position-relative mb-2">
                                        <label for="denda" class="form-label">Denda</label>
                                        <input autocomplete="off" type="text" name="denda" id="denda"
                                            class="form-control form-control-sm">
                                        <small class="text-danger" id="msg_denda"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div class="position-relative mb-2">
                                        <label for="block_1" class="form-label">block 1.[ 0-10 m3 ]</label>
                                        <input autocomplete="off" maxlength="16" type="text" name="block_1" id="block_1"
                                            class="form-control form-control-sm">
                                        <small class="text-danger" id="msg_block_1"></small>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="position-relative mb-2">
                                        <label for="block_2" class="form-label">block 2.[ 10-20 m3 ]</label>
                                        <input autocomplete="off" type="text" name="block_2" id="block_2"
                                            class="form-control form-control-sm">
                                        <small class="text-danger" id="msg_block_2"></small>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="position-relative mb-2">
                                        <label for="block_3" class="form-label">block 3.[ 20-30 m3 ]</label>
                                        <input autocomplete="off" type="text" name="block_3" id="block_3"
                                            class="form-control form-control-sm">
                                        <small class="text-danger" id="msg_block_3"></small>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="position-relative mb-2">
                                        <label for="block_4" class="form-label">block 4.[ 30 > m3 ]</label>
                                        <input autocomplete="off" type="text" name="block_4" id="block_4"
                                            class="form-control form-control-sm">
                                        <small class="text-danger" id="msg_block_4"></small>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-12 text-right">
                                <button class="btn btn-secondary btn-icon-split" type="submit" id="SimpanPaket"
                                    class="btn btn-dark" style="float: right; margin-left: 10px;">
                                    <span class="icon text-white-50"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" fill="currentColor" class="bi bi-sign-intersection-fill"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                        </svg>
                                    </span><span class="text" style="float: right;">Simpan Harga</span>
                                </button>
                            </div>
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
    $(document).on('click', '#SimpanPaket', function (e) {
        e.preventDefault();
        $('small').html('');

        var form = $('#paket');
        var actionUrl = form.attr('action');

        $.ajax({
            type: 'POST',
            url: actionUrl,
            data: form.serialize(),
            success: function (result) {
                if (result.success) {
                    Swal.fire({
                        title: result.msg,
                        text: "Tambahkan Paket Baru?",
                        icon: "success",
                        showDenyButton: true,
                        confirmButtonText: "Tambahkan",
                        denyButtonText: `Tidak`
                    }).then((res) => {
                        if (res.isConfirmed) {
                            window.location.reload()
                        } else {
                            window.location.href = '/packages/';
                        }
                    });
                }
            },
            error: function (result) {
                const response = result.responseJSON;

                Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error');

                if (response && typeof response === 'object') {
                    $.each(response, function (key, message) {
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
