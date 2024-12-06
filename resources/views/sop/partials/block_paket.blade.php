<div class="card-body">
    <form action="/pengaturan/sop/sistem_instalasi" method="post" id="Fromswit">
        @csrf

        <div class="form-group">
            <label>Swit Tombol</label>
            <div class="custom-control custom-switch">
                <input type="radio" class="custom-control-input" id="swit_tombol_1" name="swit_tombol" value="1"
                    {{ isset($tampil_settings) && $tampil_settings->swit_tombol == 1 ? 'checked' : '' }}>
                <label class="custom-control-label" for="swit_tombol_1">
                    progres instalasi (Nominal <b>tidak boleh</b> nyicil)
                </label>
            </div>
            <div class="custom-control custom-switch">
                <input type="radio" class="custom-control-input" id="swit_tombol_2" name="swit_tombol" value="2"
                    {{ isset($tampil_settings) && $tampil_settings->swit_tombol == 2 ? 'checked' : '' }}>
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

@section('script')
    <script>
        $(document).on('click', '#SimpanSwit', function(e) {
            e.preventDefault();
            var form = $('#Fromswit');
            var actionUrl = form.attr('action');

            var toastMixin = Swal.mixin({
                toast: true,
                icon: 'success',
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            $.ajax({
                type: 'GET',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        toastMixin.fire({
                            title: 'Pembaruhan Sistem Instalasi Berhasil'
                        });
                        setTimeout(() => window.location.reload(), 3000);
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error');
                }
            });
        });
    </script>
@endsection
