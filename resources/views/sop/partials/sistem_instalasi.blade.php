@extends('layouts.base')

@section('content')
<div class="col-lg-6">
    <!-- General Element -->
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Sistem Instalasi</h6>
        </div>
        <div class="card-body">
            <form action="/pengaturan/sop/sistem_instalasi" method="post" id="Fromswit">
                @csrf

                <div class="form-group">
                    <label>Swit Tombol</label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="swit_tombol_1" name="swit_tombol"
                            value="1">
                        <label class="custom-control-label" for="swit_tombol_1">
                            progres instalasi (Nominal <b>tidak boleh</b> nyicil)
                        </label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="swit_tombol_2" name="swit_tombol"
                            value="2">
                        <label class="custom-control-label" for="swit_tombol_2">
                            progres instalasi (Nominal <b>boleh</b> nyicil)
                        </label>
                    </div>
                </div>

                <hr>
                <div div class="col-12 text-right">
                    <button type="submit" class="btn btn-primary btn-sm" id="SimpanSwit"
                        style="background-color: rgb(78, 68, 68); color: white; border-color: black;">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).on('click', '#SimpanSwit', function (e) {
        e.preventDefault();
        $('small').html('');

        var form = $('#Fromswit');
        var actionUrl = form.attr('action');

        $.ajax({
            type: 'GET',
            url: actionUrl,
            data: form.serialize(),
            success: function (result) {
                if (result.success) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Pembaruhan Sistem Instalasi Berhasil",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((res) => {
                        window.location.reload()
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
