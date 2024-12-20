@extends('layouts.base')
@php
$label_search = 'Nama/Kode Installasi';
@endphp
@section('content')
@if (session('success'))
<div id="success-alert" class="alert alert-success alert-dismissible fade show text-center" role="alert">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<form action="/usages" method="post" id="FormInputPemakaian">
    @csrf
    <div class="card">
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            Catatan : ( Jika Ada data atau inputan yang kosong bisa di isi ( 0 ) atau ( - ) )
        </div>
        <div class="card-body">
            <!-- Form Inputs -->
            {{-- <input type="hidden" name="_block" id="_block" value="{{ $setting->block }}">
            <input type="hidden" name="_daftar_harga" id="_daftar_harga"> --}}

            <input type="hidden" name="customer_id" id="customer_id">
            <div class="row g-3">
                <div class="col-md-6 mb-3">
                    <label for="carianggota" class="form-label">Nama</label>
                    <input type="text" class="typeahead form-control bg-light border-1 small search" id="carianggota"
                        name="customer" placeholder="{{ $label_search }}">
                    <div class="invalid-feedback">Masukkan (Kode Instalasi / Nama Customer)</div>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="awal" class="form-label">Awal</label>
                    <input type="text" name="awal" id="awal" readonly class="form-control hitungan" value="">
                    <small class="text-danger" id="msg_awal"></small>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="akhir" class="form-label">Akhir</label>
                    <input type="text" name="akhir" id="akhir" class="form-control hitungan">
                    <small class="text-danger" id="msg_akhir"></small>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="text" readonly name="jumlah" id="jumlah" class="form-control">
                    <small class="text-danger" id="msg_jumlah"></small>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="tgl_akhir" class="form-label">Tgl Akhir</label>
                    <input type="text" class="form-control date" name="tgl_akhir" id="tgl_akhir"
                        aria-describedby="tgl_akhir" placeholder="Tgl Akhir" value="{{ date('d/m/Y') }}">
                    <small class="text-danger" id="msg_tgl_akhir"></small>
                </div>
            </div>
            <div class="">
                <a href="/usages" class="btn btn-primary btn-sm">Kembali</a>
                <button type="submit" class="btn btn-dark btn-sm" id="SimpanPemakaian">Simpan</button>
            </div>

        </div>
</form>

</div>
</form>
@endsection

@section('script')
<script>
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
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(() => {
                alert.classList.add(
                    'd-none'); // Menyembunyikan notifikasi dengan menambahkan class 'd-none'
            }, 5000); // Notifikasi hilang setelah 5 detik
        }
    });


    <
    script >
        document.getElementById("close").addEventListener("click", function () {
            window.location.href = "/usages"; // Url kembali
        });

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(() => {
                alert.classList.add(
                'd-none'); // Menyembunyikan notifikasi dengan menambahkan class 'd-none'
            }, 5000); // Notifikasi hilang setelah 5 detik
        }
    });

    $(document).on('change', '#customer', function (e) {
        var value = $(this).val().split("|");
        if (value.length > 0) { // Pastikan value memiliki elemen untuk menghindari error
            var kode = value[0]; // Ambil elemen pertama dari value
            $('#kode_instalasi').val(kode); // Set elemen dengan ID 'kode_instalasi'
        }
    });

    $(document).on('change', '#customer', function (e) {
        var value = $(this).val().split("|");
        if (value.length > 0) { // Pastikan value memiliki elemen untuk menghindari error
            var kode = value[0]; // Ambil elemen pertama dari value
            $('#kode_instalasi').val(kode); // Set elemen dengan ID 'kode_instalasi'
        }
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

</script>

@endsection
