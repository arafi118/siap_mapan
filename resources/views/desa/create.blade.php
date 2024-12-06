@extends('layouts.base')

@section('content')
<form action="/villages" method="post" id="FormInputDesa">
    @csrf
    <!-- Alert -->
    <!-- Form Card -->
    <div class="card">
        <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        Catatan : ( Jika Ada data atau inputan yang kosong bisa di isi ( 0 ) atau ( - ) )
    </div>
        <div class="card-body">
            <!-- Form Inputs -->
            <div class="row g-3">
                <!-- Provinsi -->
                <div class="col-md-3 mb-3">
                    <label for="provinsi" class="form-label">Provinsi</label>
                    <select name="provinsi" id="provinsi" class="form-control form-control-sm">
                        <option value="">Pilih Nama Provinsi</option>
                        @foreach ($provinsi as $prov)
                        <option value="{{ $prov->kode }}">
                            {{ ucwords(strtolower($prov->nama)) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <!-- Kabupaten -->
                <div class="col-md-3 mb-3">
                    <label for="kabupaten" class="form-label">Kabupaten</label>
                    <select name="kabupaten" id="kabupaten" class="form-control form-control-sm">
                        <option value="">Pilih Nama Kabupaten</option>
                    </select>
                </div>
                <!-- Kecamatan -->
                <div class="col-md-3 mb-3">
                    <label for="kecamatan" class="form-label">Kecamatan</label>
                    <select name="kecamatan" id="kecamatan" class="form-control form-control-sm">
                        <option value="">Pilih Nama Kecamatan</option>
                    </select>
                </div>

                <!-- Desa -->
                <div class="col-md-3 mb-3">
                    <label for="desa" class="form-label">Desa</label>
                    <select name="desa" id="desa" class="form-control form-control-sm">
                        <option value="">Pilih Nama Desa</option>
                    </select>
                </div>
                <!-- No. Telp -->
                <div class="col-md-4">
                    <label for="hp" class="form-label">No. Telp</label>
                    <input type="text" name="hp" id="hp" class="form-control form-control-sm">
                    <small class="text-danger" id="msg_hp"></small>
                </div>
                <!-- Alamat -->
                <div class="col-md-6">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control form-control-sm" readonly></textarea>
                    <small class="text-danger" id="msg_alamat"></small>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="/installations/create" class="btn btn-primary btn-sm">Kembali</a>
            <button type="submit" class="btn btn-dark btn-sm" id="Simpandesa">Simpan</button>
        </div>
        
    </div>
</form>

@endsection

@section('script')
<script>
    $(document).on('change', '#provinsi', function () {
        var kode = $(this).val();
        $.get('/ambil_kab/' + kode, function (result) {
            if (result.success) {
                setSelectValue('kabupaten', result.data);
            }
        });
    });

    $(document).on('change', '#kabupaten', function () {
        var kode = $(this).val();
        $.get('/ambil_kec/' + kode, function (result) {
            if (result.success) {
                setSelectValue('kecamatan', result.data);
            }
        });
    });

    $(document).on('change', '#kecamatan', function () {
        var kode = $(this).val();
        $.get('/ambil_desa/' + kode, function (result) {
            if (result.success) {
                setSelectValue('desa', result.data);
            }
        });
    });

    $(document).on('change', '#desa', function () {
        var kode = $(this).val();

        $("#alamat").val('');
        $.get('/set_alamat/' + kode, function (result) {
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
        return str.replace(/\b\w/g, function (char) {
            return char.toUpperCase();
        });
    }

</script>

<script>
    document.getElementById("close").addEventListener("click", function () {
        window.location.href = "/villages"; // Ganti "/villages" dengan URL yang sesuai
    });

</script>
@endsection
