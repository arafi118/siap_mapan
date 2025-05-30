@php
    use App\Utils\Tanggal;
@endphp

@extends('layouts.base')

@section('content')
    @if (session('success'))
        <div id="success-alert" class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <li class="	fas fa-check-circle"></li>
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <div style="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <i class="fas fa-tint" style="font-size: 28px; margin-right: 8px;"></i>
                                <b>Data Pemakaian</b>
                            </div>

                        </div>
                    </div>

                    <div class="alert alert-info mt-3">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="bulan">Bulan Pemakaian</label>
                                    {{-- JANUARI,FEBRUARI,MARET --}}
                                    <select id="bulan" name="bulan" class="form-control select2">
                                        <option value="">-- Pilih Bulan --</option>
@php
    $tgl_pakai = '2024-05-12';
    $start = Carbon\Carbon::parse($tgl_pakai)->startOfMonth();
    $end = Carbon\Carbon::now()->endOfMonth();
    $current = Carbon\Carbon::now();
    
    $months = [];
    while ($start <= $end) {
        $months[] = [
            'value' => $start->format('Y-m'),
            'label' => Tanggal::namaBulan($start->format('Y-m-d')) . ' ' . $start->format('Y'),
            'is_current' => $start->month == $current->month && $start->year == $current->year
        ];
        $start->addMonth();
    }
    
    // Urutkan dari bulan terbaru ke terlama
    $months = array_reverse($months);
@endphp

@foreach ($months as $month)
    <option value="{{ $month['value'] }}" {{ $month['is_current'] ? 'selected' : '' }}>
        {{ $month['label'] }}
    </option>
@endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="caters">Cater</label>
                                        <select class="form-control select2" id="caters" name="caters">
                                            @if ($caters->count() > 1)
                                                <option value="">Semua</option>
                                            @endif
                                            @foreach ($caters as $cater)
                                                <option value="{{ $cater->id }}">{{ $cater->nama }}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button class="btn btn-danger btn-block" type="button" id="DetailCetakBuktiTagihan">
                                    <i class="fas fa-info-circle"></i> Hasil Input
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" id="TbPemakain">
                            <thead class="thead-light" align="center">
                                <tr>
                                    <th width="12%">Nama</th>
                                    <th width="15%">No. Induk</th>
                                    <th width="13%">Meter Awal</th>
                                    <th width="13%">Meter Akhir</th>
                                    <th width="5%">Pemakaian</th>
                                    <th width="12%">Tagihan</th>
                                    <th width="15%">Tanggal Akhir Bayar</th>
                                    <th width="5%">Status</th>

                                    <th style="text-align: center;" width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="CetakBuktiTagihan" tabindex="-1" aria-labelledby="CetakBuktiTagihanLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="CetakBuktiTagihanLabel">
                    </h1>
                </div>
                <div class="modal-body">
                    <form action="/usages/cetak" method="post" id="FormCetakBuktiTagihan" target="_blank">
                        @csrf
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <div class="d-flex mb-1">
                                    <div class="fw-bold me-2" style="width: 120px;">Cater</div>
                                    <div>: <span id="NamaCater"></span></div>
                                </div>
                                <div class="d-flex">
                                    <div class="fw-bold me-2" style="width: 120px;">Maksimal Bayar</div>
                                    <div>: <span id="TanggalCetak"></span></div>
                                </div>
                            </div>

                            <div style="width: 200px; align-self: flex-end; margin-top: 2px;">
                                <input type="text" id="SearchTagihan" class="form-control form-control-sm"
                                    placeholder="Search ...">
                            </div>
                        </div>
                        {{-- <div class="d-flex justify-content-between mb-1">
                            <div>
                                <span class="fw-bold">&nbsp;Cater</span> : <span id="NamaCater">-</span>
                            </div>
                            <div>
                                <span class="fw-bold">Tanggal Akhir</span> : <span id="TanggalCetak">-</span>
                            </div>
                        </div> --}}

                        <!-- Hidden input untuk dikirim ke backend -->
                        <input type="hidden" name="cater" id="InputCater">
                        <input type="hidden" name="tanggal" id="InputTanggal">

                        <!-- Tabel tagihan -->
                        <table id="TbTagihan" class="table table-striped midle">
                            {{-- <div class="card-header bg-dark text-white p-2 pe-2 pb-2 pt-2">
                                <div class="row align-items-center">
                                    <div class="col-md-10 mb-0">
                                        <h6 class="mb-0"><b>Daftar Tagihan Pemakaian</b></h6>
                                    </div>
                                    <div class="col-md-2 mb-0">
                                        <div class="input-group input-group-sm">
                                            <input type="text" id="SearchTagihan" class="form-control form-control-sm"
                                                placeholder="Search ...">
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <thead class="bg-dark text-white">
                                <tr>
                                    <td align="center" width="40">
                                        <div class="form-check text-center ps-0 mb-0">
                                            <input class="form-check-input" type="checkbox" value="true" id="checked"
                                                name="checked" checked>
                                        </div>
                                    </td>
                                    <td align="center" width="120">Nama</td>
                                    <td align="center" width="100">Desa</td>
                                    <td align="center" width="100">RT</td>
                                    <td align="center" width="100">No. Induk</td>
                                    <td align="center" width="80">Meter Awal</td>
                                    <td align="center" width="80">Meter Akhir</td>
                                    <td align="center" width="100">Pemakaian</td>
                                    <td align="center" width="100">Tagihan Air</td>
                                    <td align="center" width="100">Status</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </form>


                    <div class="d-none">
                        <form action="/usages/cetak_tagihan" method="post" id="FormCetakTagihan" target="_blank">
                            @csrf

                            <div id="form"></div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="BtnCetak1" class="btn btn-sm btn-dark">
                        Cetak Daftar Tagihan
                    </button>
                    <button type="button" id="BtnCetak" class="btn btn-sm btn-info">
                        Cetak Struk
                    </button>
                    <button type="button" id="kembali" class="btn btn-danger btn-sm">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="FormHapusPemakaian">
        @method('DELETE')
        @csrf
    </form>
@endsection
@section('script')
    <script>
        let dataSearch;

        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
            });
        });

        $(document).on('click', '#kembali', function(e) {
            e.preventDefault();
            $('#CetakBuktiTagihan').modal('hide');
        });

        $(document).on('click', '#Registerpemakaian', function(e) {
            e.preventDefault();

            var caterId = $('#caters').val(); // ambil cater yang dipilih
            var bulan = $('#bulan').val();    // ambil bulan yang dipilih
            var url = '/usages/create';
            var params = [];

            if (caterId) {
                params.push('cater_id=' + caterId);
            }

            if (bulan) {
                params.push('tgl_kondisi=' + bulan);
            }

            if (params.length > 0) {
                url += '?' + params.join('&');
            }

            window.location.href = url;
        });


        var cater = $('#caters').val()
        var bulan = $('#bulan').val()
        var table = $('#TbPemakain').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "/usages/cater?bulan=" + bulan + "&cater=" + cater,
                "type": "GET"
            },
            "language": {
                "processing": `<i class="fas fa-spinner fa-spin"></i> Mohon Tunggu....`,
                "emptyTable": "Tidak ada data yang tersedia",
                "search": "",
                "searchPlaceholder": "Pencarian...",
                "paginate": {
                    "next": "<i class='fas fa-angle-right'></i>",
                    "previous": "<i class='fas fa-angle-left'></i>"
                }
            },
            "columns": [
                {
                    "data": "nama"
                },
                {
                    "data": "no_induk"
                },
                {
                    "data": "meter_awal"
                },
                {
                    "data": "meter_akhir"
                },
                {
                    "data": "pemakaian"
                },
                {
                    "data": "tagihan"
                },
                {
                    "data": "tgl_akhir_bayar"
                },
                {
                    "data": "status",
                    "className": "text-center" 
                },
                {
                    "data": "aksi"
                }
            ]
        });
        $('#caters').on('change', function() {
            cater = $(this).val()
            table.ajax.url("/usages/cater?bulan=" + bulan + "&cater=" + cater).load();
        });

        $('#bulan').on('change', function() {
            bulan = $(this).val()
            table.ajax.url("/usages/cater?bulan=" + bulan + "&cater=" + cater).load();
        });



        function searching(search) {
            let data = table.data().toArray();

            search = search.toLowerCase()
            dataSearch = data.filter((element) => {
                console.log(element)
                return (
                    element.installation.kode_instalasi.includes(search) ||
                    element.customers.nama.toLowerCase().includes(search)
                )
            });

            setTableData(dataSearch)
        }

        $(document).on('click', '#DetailCetakBuktiTagihan', function(e) {
            const data = table.data().toArray();

            if (data.length > 0) {
                const cater = data[0].users_cater.nama;
                const tanggal = data[0].tgl_akhir; // 2025-05-22 | 22/05/2025

                var tgl = tanggal.split('/') // [2025, 05, 22]
                var hari = tgl[0] - 1;

                $('#NamaCater').text(cater);
                $('#TanggalCetak').text(hari + '/' + tgl[1] + '/' + tgl[2]);
                $('#InputCater').val(cater);
                $('#InputTanggal').val(tanggal);
            }

            setTableData(data);

            $('#CetakBuktiTagihan').modal('show');
        });

        function setTableData(data) {
            const tbTagihan = $('#TbTagihan');
            tbTagihan.find('tbody').html('');

            // Kelompokkan data berdasarkan dusun
            const groupedByDusun = {};
            data.forEach(item => {
                const dusun = item.installation.village.dusun || 'Lainnya';
                if (!groupedByDusun[dusun]) groupedByDusun[dusun] = [];
                groupedByDusun[dusun].push(item);
            });

            // Urutkan nama dusun
            const sortedDusuns = Object.keys(groupedByDusun).sort();

            sortedDusuns.forEach(dusun => {
                const items = groupedByDusun[dusun];

                // Urutkan berdasarkan RT
                items.sort((a, b) => parseInt(a.installation.rt || 0) - parseInt(b.installation.rt || 0));

                // Tambah baris judul dusun
                tbTagihan.find('tbody').append(`
            <tr class="table-secondary fw-bold">
                <td colspan="11">Dusun : ${dusun}</td>
            </tr>
        `);
                // Tambah baris data
                items.forEach(item => {
                    tbTagihan.find('tbody').append(`
                <tr>
                    <td align="center">
                        <div class="form-check text-center ps-0 mb-0">
                            <input checked class="form-check-input" type="checkbox" value="${item.id}" id="${item.id}" name="cetak[]" data-input="checked" data-bulan="${item.bulan}">
                        </div>
                    </td>
                    <td align="left">${item.customers.nama}</td>
                    <td align="left">${item.installation.village.nama}</td>
                    <td align="center">${item.installation.rt}</td>
                    <td align="center">${item.installation.kode_instalasi} ${item.installation.package.kelas.charAt(0)}</td>
                    <td align="center">${item.awal}</td>
                    <td align="center">${item.akhir}</td>
                    <td align="center">${item.jumlah}</td>
                    <td align="right">${item.nominal}</td>
                    <td align="center">${item.status}</td>
                </tr>
            `);
                });
            });
        }


        $(document).on('click', '#BtnCetak', function(e) {
            e.preventDefault()

            if ($('#FormCetakBuktiTagihan').serializeArray().length > 1) {
                $('#FormCetakBuktiTagihan').submit();
            } else {
                Swal.fire('Error', "Tidak ada transaksi yang dipilih.", 'error')
            }
        })
        $(document).on('click', '#BtnCetak1', function(e) {
            e.preventDefault()

            var data = table.data().toArray()
            var formTagihan = $('#form');

            var bulan = $('#bulan').val()
            var caters = $('#caters').val()

            formTagihan.find('form').html('')
            var row = formTagihan.append(`
                <input type="hidden" name="bulan_tagihan" value="${bulan}">
                <input type="hidden" name="pemakaian_cater" value="${cater}">
            `);

            $('#FormCetakTagihan').submit();
        })
    </script>

    @if (Session::has('berhasil'))
        <script>
            toastMixin.fire({
                text: '{{ Session::get('berhasil') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
    <script>
        // Tunggu hingga DOM selesai dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Pilih elemen notifikasi
            const alert = document.getElementById('success-alert');
            if (alert) {
                // Atur timer untuk menghilangkan notifikasi setelah 3 detik
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s'; // Animasi hilang
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500); // Hapus elemen setelah animasi selesai
                }, 3000);
            }
        });
        $(document).on('click', '.Hapus_pemakaian', function(e) {
            e.preventDefault();

            var hapus_pemakaian = $(this).attr('data-id'); // Ambil ID yang terkait dengan tombol hapus
            var actionUrl = '/usages/cater/' + hapus_pemakaian; // URL endpoint untuk proses hapus

            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data Akan dihapus secara permanen dari aplikasi tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#FormHapusPemakaian')
                    $.ajax({
                        type: form.attr('method'), // Gunakan metode HTTP DELETE
                        url: actionUrl,
                        data: form.serialize(),
                        success: function(response) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: response.message || "Data berhasil dihapus.",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then((res) => {
                                if (res.isConfirmed) {
                                    window.location.reload()
                                } else {
                                    window.location.href = '/usages/cater/';
                                }
                            });
                        },
                        error: function(response) {
                            const errorMsg = "Terjadi kesalahan.";
                            Swal.fire({
                                title: "Error",
                                text: errorMsg,
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: "Dibatalkan",
                        text: "Data tidak jadi dihapus.",
                        icon: "info",
                        confirmButtonText: "OK"
                    });
                }
            });
        });

        $(document).ready(function() {
            // Filter baris berdasarkan bulan akhir
            $('#filter-bulan').on('change', function() {
                var selectedMonth = $(this).val();
                $('[data-input=checked]').each(function() {
                    var row = $(this).closest('tr');
                    var bulan = $(this).data('bulan');
                    if (!selectedMonth || bulan == selectedMonth) {
                        row.show();
                    } else {
                        row.hide();
                        $(this).prop('checked', false); // Uncheck jika disembunyikan
                    }
                });
            });

            // Centang semua baris yang terlihat saat checkbox utama diklik
            $('#checked').on('click', function() {
                var status = $(this).is(':checked');
                $('[data-input=checked]:visible').prop('checked', status);
            });
        });
    </script>
@endsection
