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
                                style="max-height: 160px; margin-right: 15px; margin-left: 10px;"
                                class="img-fluid d-none d-lg-block">

                            <div class="flex-grow-1">
                                <div class="mt-3">
                                    <h3><b>Input Pemakaian Air Bulanan</b></h3>
                                </div>
                                <hr class="my-2 bg-white">
                                <div class="row">
                                    <div class="col-6 col-md-8">
                                        <select class="select2 form-control" name="caters" id="caters">
                                            <option value=""></option>
                                            @foreach ($caters as $cater)
                                                <option value="{{ $cater->id }}">
                                                    {{ $cater->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <input type="text" name="tanggal" id="tanggal" class="form-control date"
                                            value="{{ date('d/m/Y') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tabel di Bawah Customer -->
                        <br>
                        <div class="row">
                            <!-- Datatables -->
                            <div class="col-lg-12">
                                <div class="card mb-4">
                                    <div class="table-responsive p-3">
                                        <table class="table align-items-center table-flush table-center" id="TbPemakain">
                                            <thead class="thead-light" align="center">
                                                <tr>
                                                    <th>Checklist</th>
                                                    <th>NAMA</th>
                                                    <th>KODE INSTALASI</th>
                                                    <th>AWAL PERMAKAIAN</th>
                                                    <th>AKHIR PERMAKAIAN</th>
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
                            &nbsp;
                            <a href="#" type="button" id="SimpanPemakaian" class="btn btn-secondary">Simpan
                                Pemakaian</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div style="display: none;" id="print"></div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
            });
        });

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

        $(document).on('change', '#caters, #tanggal', function(e) {
            e.preventDefault()

            var id_cater = $('#caters').val();
            var tanggal = $('#tanggal').val();
            $.get('/installations/cater/' + id_cater + '?tanggal=' + tanggal, function(result) {
                if (result.success) {

                    var table = $('#DaftarInstalasi')
                    table.html('')

                    result.installations.forEach((item, index) => {
                        var nilai_akhir = (item.one_usage) ? item.one_usage.akhir : '0'
                        table.append(`
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checklist" name="check[${item.id}]" id="check_${item.id}" value="${item.id}">   
                                        <label class="custom-control-label" for="check_${item.id}"></label>
                                    </div>
                                </td>    
                                <td>${item.customer.nama}</td>    
                                <td>${item.kode_instalasi}</td>    
                                <td>${nilai_akhir}</td>    
                                <td>
                                    <input type="hidden" class="form-control" name="customer[item.id]" id="customer_${item.id}" value="${item.customer.id}">    
                                    <input type="hidden" class="form-control input-nilai-awal" name="awal[item.id]" id="awal_${item.id}" value="${nilai_akhir}">    
                                    <input type="text" class="form-control input-nilai-akhir" name="akhir[item.id]" id="akhir_${item.id}" value="${nilai_akhir}">    
                                </td>    
                                <td>
                                    <input type="text" class="form-control input-jumlah" name="jumlah[item.id]" id="jumlah_${item.id}" value="0" readonly>     
                                </td>    
                            </tr>
                        `)
                    });
                }
            })
        })

        $(document).on('focus', '.input-nilai-akhir', function(e) {
            e.preventDefault();
            $(this).select();
        });

        $(document).on('change', '.input-nilai-akhir', function(e) {
            e.preventDefault()

            var id = $(this).attr('id').split('_')[1]
            var nilai_akhir = $(this).val()
            var nilai_awal = $('#awal_' + id).val()
            if (nilai_akhir - nilai_awal < 0) {
                Swal.fire({
                    title: 'Periksa kembali nilai yang dimasukkan',
                    text: 'Nilai Akhir tidak boleh lebih kecil dari Nilai Awal',
                    icon: 'warning',
                })

                $(this).val(nilai_awal)
                return;
            }

            var jumlah = nilai_akhir - nilai_awal
            $('#jumlah_' + id).val(jumlah)
        })

        $(document).on('click', '#SimpanPemakaian', function(e) {
            e.preventDefault()

            var id_cater = $('#caters').val();
            var data = []

            var checklist = $('.checklist')
            checklist.each(function(index, item) {
                if ($(item).is(':checked')) {
                    var id = $(item).val()
                    var customer = $('#customer_' + id).val()
                    var awal = $('#awal_' + id).val()
                    var akhir = $('#akhir_' + id).val()
                    var jumlah = $('#jumlah_' + id).val()

                    data.push({
                        id_cater: id_cater,
                        id: id,
                        customer: customer,
                        awal: awal,
                        akhir: akhir,
                        jumlah: jumlah
                    })
                }
            })

            var form = $('#FormInputPemakaian')
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: {
                    _token: form.find('input[name="_token"]').val(),
                    tanggal: $('#tanggal').val(),
                    data: data
                },
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: result.message,
                            icon: 'success',
                        }).then((res) => {
                            if (res.isConfirmed) {
                                $('#print').html(result.view)

                                var prtContent = document.getElementById("print");
                                var WinPrint = window.open('', '',
                                    'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0'
                                );
                                WinPrint.document.write(prtContent.innerHTML);
                                WinPrint.document.close();
                                WinPrint.focus();
                                WinPrint.print();
                                WinPrint.close();
                            }
                        })
                    }
                }
            })
        })
    </script>
@endsection
