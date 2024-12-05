@extends('layouts.base')

@section('content')
<form action="/villages" method="post" id="FormInputDesa">
    @csrf
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <p>Catatan: Jika ada data atau inputan yang kosong, bisa diisi dengan (0) atau (-).</p>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <!-- Title -->
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading d-flex align-items-center">
                                <i class="fas fa-clinic-medical" style="font-size: 25px; margin-right: 7px;"></i>
                                <b>Tambah Desa</b>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3"></div>
                    <!-- Form Inputs -->
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="provinsi" class="form-label">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="form-control form-control-sm">
                                <option>Pilih Nama Provinsi</option>
                                @foreach ($provinsi as $prov)
                                <option value="{{ $prov->kode }}">
                                    {{ ucwords(strtolower($prov->nama)) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="kabupaten" class="form-label">Kabupaten</label>
                            <select name="kabupaten" id="kabupaten" class="form-control form-control-sm">
                                <option>Pilih Nama Kabupaten</option>
                            </select>
                        </div> 
                        <div class="col-md-3 mb-3">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" class="form-control form-control-sm">
                                <option>Pilih Nama Kecamatan</option>
                            </select>
                        </div> 
                        <div class="col-md-3 mb-3">
                            <label for="desa" class="form-label">Desa</label>
                            <select name="desa" id="desa" class="form-control form-control-sm">
                                <option>Pilih Nama Desa</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="alamat" class="form-label">ALAMAT</label>
                            <textarea id="alamat" class="form-control form-control-sm" readonly></textarea>
                            <small class="text-danger" id="msg_alamat"></small>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary btn-sm" id="close">Close</button>
                        <button type="submit" class="btn btn-dark btn-sm" id="Simpandesa">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
<script>
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
</script>

<script>
    document.getElementById("close").addEventListener("click", function () {
        window.location.href = "/villages"; // Ganti "/villages" dengan URL yang sesuai
    });
</script>
@endsection
