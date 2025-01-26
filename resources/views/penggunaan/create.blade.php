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
                                    <h3><b>Input Pemakaian Air Bulanan</b></h3>
                                </div>
                                <hr class="my-2 bg-white">
                                <select class="select2 form-control" name="caters" id="caters">
                                    @foreach ($caters as $cater)
                                        <option value="{{ $cater->id }}">
                                            {{ $cater->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Tabel di Bawah Customer -->
                        <br>
                        <div class="row">
                            <!-- Datatables -->
                            <div class="col-lg-12">
                                <div class="card mb-4">
                                    <div class="table-responsive p-3">
                                        <table class="table align-items-center table-flush" id="TbPemakain">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Checklist</th>
                                                    <th>NAMA</th>
                                                    <th>KODE INSTALASI</th>
                                                    <th>AWAL</th>
                                                    <th>AKHIR</th>
                                                    <th>JUMLAH</th>
                                                    {{-- <th style="text-align: center;">AKSI</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody id="DaftarInstalasi"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <a href="/usages" class="btn btn-white">Kembali</a>
                            <button class="btn btn-secondary ml-2" type="submit" id="SimpanPemakaian">
                                <span class="icon">
                                    <i class="fas fa-plus"></i>
                                </span>
                                <span class="text">Simpan</span>
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

        $(document).on('change', '#caters', function(e) {
            e.preventDefault()

            var id_cater = $(this).val();
            $.get('/installations/cater/' + id_cater, function(result) {
                if (result.success) {

                    var table = $('#DaftarInstalasi')
                    table.html('')

                    result.installations.forEach((item, index) => {
                        var nilai_akhir = (item.one_usage) ? item.one_usage.akhir : '0'
                        table.append(`
                            <tr>
                                <td>
                                    <input type="checkbox" name="check[${item.id}]" id="check_${item.id}">   
                                </td>    
                                <td>${item.customer.nama}</td>    
                                <td>${item.kode_instalasi}</td>    
                                <td>${nilai_akhir}</td>    
                                <td>
                                    <input type="text" class="form-control" name="akhir[item.id]" id="akhir_${item.id}" value="${nilai_akhir}">    
                                </td>    
                                <td>
                                    <input type="text" class="form-control" name="jumlah[item.id]" id="jumlah_${item.id}" value="${nilai_akhir}">     
                                </td>    
                            </tr>
                        `)
                    });
                }
            })
        })
    </script>
@endsection
