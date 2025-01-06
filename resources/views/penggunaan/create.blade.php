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
        <input type="hidden" name="customer_id" id="customer_id">
        <input type="hidden" name="id_instalasi" id="id_instalasi">

        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Bagian Informasi Customer -->
                        <div class="alert alert-info d-flex align-items-center m-0 text-white" role="alert"
                            style="border-radius: 1;">
                            <!-- Gambar -->
                            <img src="../../assets/img/meteran.png"
                                style="max-height: 160px; margin-right: 15px; margin-left: 10px;" class="img-fluid">

                            <div class="flex-grow-1">
                                <div class="mt-3">
                                    <h3><b>Pembayaran Pemakaian Bulanan</b></h3>
                                </div>
                                <hr class="my-2 bg-white">
                                <div class="form-group">
                                    <input type="text" class="typeahead form-control bg-light border-1 small search"
                                        id="carianggota" name="customer" placeholder="{{ $label_search }}">
                                </div>
                            </div>
                        </div>
                        <!-- Tabel di Bawah Customer -->
                        <br>
                        <div class="alert alert-light" role="alert">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="tgl_akhir">Tanggal Akhir</label>
                                        <input type="text" class="form-control date" name="tgl_akhir"
                                            id="tgl_akhir"value=" {{ date('d/m/Y') }}">
                                        <small class="text-danger">{{ $errors->first('tgl_akhir') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="awal">Awal Pemakaian</label>
                                        <input type="text" class="form-control hitungan" id="awal" name="awal"
                                            readonly>
                                        <small class="text-danger" id="msg_awal"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="akhir">Akhir Pemakaian</label>
                                        <input type="text" class="form-control total hitungan" name="akhir"
                                            id="akhir">
                                        <small class="text-danger" id="msg_akhir"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="jumlah">Jumlah</label>
                                        <input type="text" class="form-control" name="jumlah" id="jumlah" readonly>
                                        <small class="text-danger"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <a href="/usages" class="btn btn-light btn-sm">Kembali</a>
                            <button class="btn btn-secondary btn-icon-split" type="submit" id="SimpanPemakaian"
                                style="float: right; margin-left: 10px;">
                                <span class="icon text-white-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                    </svg>
                                </span>
                                <span class="text" style="float: right;">Simpan Pembayaran</span>
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
        document.getElementById("close").addEventListener("click", function() {
            window.location.href = "/usages"; // Url kembali
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.add(
                        'd-none'); // Menyembunyikan notifikasi dengan menambahkan class 'd-none'
                }, 5000); // Notifikasi hilang setelah 5 detik
            }
        });

        $(document).on('change', '.hitungan', function() {
            var awal = $('#awal').val()
            var akhir = $('#akhir').val()

            if (akhir - awal < 0 || akhir == '') {
                return;
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
