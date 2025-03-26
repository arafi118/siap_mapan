@extends('layouts.base')
@php
    $label_search = 'Nama/Kode Installasi';

@endphp
@section('content')
    <form action="/usages" method="post" id="FormInputPemakaian">
        @csrf
        <input type="hidden" id="tgl_toleransi" value="{{ $settings->tanggal_toleransi }}">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Bagian Informasi Customer -->
                        <div class="alert alert-info align-items-center text-white {{ auth()->user()->jabatan == '5' ? 'd-none' : 'd-flex mb-3' }}"
                            role="alert" style="border-radius: 1;">
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
                                    <div class="col-md-8 mb-2">
                                        <select class="select2 form-control" name="caters" id="caters">
                                            <option value=""></option>
                                            @foreach ($caters as $cater)
                                                <option value="{{ $cater->id }}">{{ $cater->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="text" name="tanggal" id="tanggal"
                                            class="form-control tanggal date" value="{{ date('d/m/Y') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tabel di Bawah Customer -->
                        <div class="row">
                            <!-- Datatables -->
                            <div class="col-lg-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-5 mb-2">
                                                <h5 class="mb-0">Daftar Pemakaian</h5>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="input-group">
                                                    <input type="text" id="tanggal" class="form-control tanggal date"
                                                        value="{{ date('d/m/Y') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class="input-group">
                                                    <input type="text" id="searchInput" class="form-control"
                                                        placeholder="Search ...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive p-3">
                                        <table class="table align-items-center table-flush table-center table-hover"
                                            id="TbPemakain">
                                            <thead class="thead-light" align="center">
                                                <tr>
                                                    <th>NAMA</th>
                                                    <th>KODE INSTALASI</th>
                                                    <th>AWAL PERMAKAIAN</th>
                                                    <th>AKHIR PERMAKAIAN</th>
                                                    <th>JUMLAH</th>
                                                </tr>
                                            </thead>
                                            <tbody id="DaftarInstalasi">
                                                <!-- Data akan ditambahkan di sini -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12  justify-content-end {{ auth()->user()->jabatan == '5' ? 'd-none' : 'd-flex' }}">
                            <a href="/usages" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div style="display: none;" id="print"></div>
    @include('penggunaan.partials.pemakaian')
@endsection

@section('script')
    <script>
        let dataInstallation;
        let dataSearch;
        let dataPemakaian;

        var id_user = '{{ auth()->user()->id }}'
        $(document).ready(function() {
            $('#caters').val(id_user).change()
        })


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

        $(document).on('change', '.tanggal', function(e) {
            $('.tanggal').val($(this).val());
        })

        $(document).on('change', '#caters, .tanggal', function(e) {
            e.preventDefault()

            var id_cater = $('#caters').val();
            var tanggal = $('#tanggal').val();
            $.get('/installations/cater/' + id_cater + '?tanggal=' + tanggal, function(result) {
                if (result.success) {
                    dataInstallation = result.installations;
                    dataSearch = dataInstallation
                    setTable(dataInstallation)
                }
            })
        })

        $(document).on('click', '#TbPemakain #DaftarInstalasi tr td', function() {
            var parent = $(this).parent()
            var index = parent.attr('data-index')
            var installation = dataSearch[index]
            $('.namaCustomer').html('<b>' + installation.customer.nama + '</b>')
            $('.customer').val(installation.customer_id)
            $('.NikCustomer').html(installation.customer.nik)
            $('.id_instalasi').val(installation.id)
            $('.TlpCustomer').html(installation.customer.hp)
            $('.AlamatCustomer').html(installation.customer.alamat)
            $('.pekerjaan').html(installation.customer.pekerjaan)
            $('.KdInstallasi').html(installation.kode_instalasi)
            $('.CaterInstallasi').html(installation.users.nama)
            $('.PackageInstallasi').html(installation.package.kelas)
            $('.AlamatInstallasi').html(installation.alamat)
            $('.AkhirUsage').val(installation.one_usage?.akhir || 0)
            $('.TglAkhirUsage').val(installation.one_usage?.tgl_akhir || 0)
            $('.PemakaianUsage').val(installation.one_usage?.tgl_pemakaian || 0)

            $('#staticBackdrop').modal('show')
        })

        $(document).on('keyup', '#searchInput', function() {
            searching($(this).val());
        });

        function searching(search) {
            let data = dataInstallation;

            dataSearch = data.filter((element) => {
                return (
                    element.kode_instalasi.includes(search) ||
                    element.customer.nama.toLowerCase().includes(search)
                )
            });

            setTable(dataSearch)
        }

        function setTable(data) {
            var table = $('#DaftarInstalasi');
            table.html('');

            data.forEach((item, index) => {
                var nilai_awal = (item.one_usage) ? item.one_usage.awal : '0';
                var nilai_akhir = (item.one_usage) ? item.one_usage.akhir : '0';
                var nilai_jumlah = (item.one_usage) ? item.one_usage.jumlah : '0';

                //set warna
                function formatbulan1(tanggal,
                    dataReturn = 'date') {
                    if (!tanggal) return '';
                    let parts = tanggal.split('/');
                    if (parts.length === 3) {
                        let [day, month, year] = parts;
                        if (
                            dataReturn == 'month') {
                            return month;
                        }
                    }
                }

                function formatbulan2(tanggal,
                    dataReturn = 'date') {
                    if (!tanggal) return '';
                    let parts = tanggal.split('-');
                    if (parts.length === 3) {
                        let [day, month, year] = parts;
                        if (
                            dataReturn == 'month') {
                            return month;
                        }
                    }
                }

                var tgl_pemakaian = (item.one_usage) ? formatbulan2(item.one_usage.tgl_pemakaian, 'month') : '0';
                var tgl_akhir = (item.one_usage) ? formatbulan2(item.one_usage.tgl_akhir, 'month') : '0';
                var tgl_hariini = formatbulan1($('#tanggal').val(), 'month');

                var colorClass = 'text-danger';
                if (tgl_akhir <= tgl_hariini) {
                    colorClass = 'text-warning';
                }

                if (tgl_pemakaian >= tgl_hariini) {
                    colorClass = 'text-success';
                }

                //endset
                table.append(`
            <tr data-index="${index}" ${tgl_pemakaian}-${tgl_akhir}-${tgl_hariini}>
                <td align="left">${item.customer.nama}</td>    
                <td align="center">${item.kode_instalasi}</td>    
                <td align="right"><b>${nilai_akhir}</b></td> 
                <td align="right" class="${colorClass}"><b>${nilai_akhir}</b></td> 
                <td align="right">${nilai_jumlah}</td> 
            </tr>
        `);
            });
        }

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
            var customer = $('#customer').val();
            var awal = $('#awal_').val();
            var akhir = $('#akhir_').val();
            var jumlah = $('#jumlah_').val();
            var id = $('#id_instalasi').val();
            var tgl = $('#tanggal').val();
            var toleransi = $('#tgl_toleransi').val();

            var data = [{
                id: id,
                tgl_pemakaian: tgl,
                id_cater: id_cater,
                customer: customer,
                awal: awal,
                akhir: akhir,
                jumlah: jumlah,
                toleransi: toleransi
            }]

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
                // success: function(result) {
                //     if (result.success) {
                //         Swal.fire({
                //             title: 'Berhasil',
                //             text: result.message,
                //             icon: 'success',
                //         }).then((res) => {
                //             if (res.isConfirmed) {
                //                 $('#print').html(result.view)

                //                 var prtContent = document.getElementById("print");
                //                 var WinPrint = window.open('', '',
                //                     'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0'
                //                 );
                //                 WinPrint.document.write(prtContent.innerHTML);
                //                 WinPrint.document.close();
                //                 WinPrint.focus();
                //                 WinPrint.print();
                //                 WinPrint.close();
                //             }
                //         })
                //     }
                // }
                success: function(result) {
                    if (result.success) {
                        toastMixin.fire({
                            title: 'Pemakaian Berhasil di Input'
                        });

                        let dataPemakaian = result.pemakaian;

                        $('#caters').val('0').change()
                        setTimeout(() => {
                            $('#caters').val(id_user).change()
                        }, 500);
                    }
                },
            })
        })
    </script>
@endsection
