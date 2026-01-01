@php
    use App\Utils\Tanggal;
@endphp

@extends('layouts.base')

@section('content')
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <div style="card-header">
                        <div class="row">
                            @if (Session::get('jabatan') != 5)
                                <div class="col-md-12">
                                    <i class="fas fa-tint" style="font-size: 28px; margin-right: 8px;"></i>
                                    <b>Data Pemakaian</b>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="alert alert-info mt-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="tahun_pakai">Tahun Pemakaian</label>
                                    <select id="tahun_pakai" name="tahun_pakai" class="form-control select2">
                                        <option value="">-- Pilih Bulan --</option>
                                        @php
                                            $tahun = date('Y');
                                        @endphp
                                        @for ($i = 2025; $i <= $tahun; $i++)
                                            <option {{ date('Y') == $i ? 'selected' : '' }} value="{{ $i }}">
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="bulan_pakai">Bulan Pemakaian</label>
                                    <select id="bulan_pakai" name="bulan_pakai" class="form-control select2">
                                        <option value="">-- Pilih Bulan --</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            @php
                                                $bulanValue = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                $tanggalObj = $tahun . '-' . $bulanValue . '-01';
                                                $namaBulan = Tanggal::namaBulan($tanggalObj);
                                            @endphp
                                            <option {{ date('n') == $i ? 'selected' : '' }} value="{{ $bulanValue }}">
                                                {{ $namaBulan }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" id="bulan" name="bulan" value="{{ date('Y-m-') . '01' }}">
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    @if (Session::get('jabatan') == 5)
                                        <label for="caters">Cater</label>
                                        {{-- Tampilkan nama cater sebagai input readonly (bisa juga <p> atau <span>) --}}
                                        <input type="text" class="form-control" id="caters_display"
                                            value="{{ $user->nama }}" readonly>
                                        {{-- Hiddenn input untuk filter --}}
                                        <input type="hidden" id="caters" name="caters" value="{{ $user->id }}">
                                    @else
                                        <label for="caters">Cater</label>
                                        <select class="form-control select2" id="caters" name="caters">
                                            <option value="">Pilih Cater</option>
                                            @foreach ($caters as $cater)
                                                <option value="{{ $cater->id }}">{{ $cater->nama }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row justify-content-end">
                            <div class="col-md-3">
                                <button class="btn btn-warning btn-block w-100" id="Registerpemakaian"
                                    @if (Session::get('jabatan') == 6) disabled @endif>
                                    <i class="fas fa-plus"></i> Input Pemakaian
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-danger btn-block w-100" type="button" id="DetailCetakBuktiTagihan">
                                    <i class="fas fa-info-circle"></i> Hasil Input
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-dark btn-block w-100" type="button" id="BtnCetak2">
                                    <i class="fa fa-print"></i> Cetak Form Input
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="alert alert-info mt-3" style="background-color: rgb(63, 63, 63); color: white;"> --}}
                    @if (Session::get('jabatan') == 5)
                        <div class="alert alert-info mt-3">
                            <div
                                style="position: relative; background-color: #32bcfc; padding: 20px 10px 20px 10px; border-radius: 6px; color: white; text-align: left;">
                                <p style="padding-left: 5px; font-weight: bold;">PERHATIAN!</p>
                                <ol style="padding-left: 20px; margin-left: 0;">
                                    <li> Pastikan nama <b>Cater</b> yang tertera di atas adalah nama Anda pribadi. Apabila
                                        bukan,
                                        segera laporkan kepada Bagian Admin.</li>
                                    <li>Untuk &nbsp;melakukan &nbsp;proses &nbsp;input, silakan &nbsp;pilih bulan terlebih
                                        dahulu, kemudian klik
                                        tombol <b>"+Input Pemakaian"</b>. Sistem akan <br>menampilkan seluruh data pelanggan
                                        yang
                                        belum terinput pemakaian airnya.</li>
                                    <li> Untuk melihat hasil input pemakaian air, silakan pilih bulan, lalu klik tombol
                                        <b>"Lihat Hasil Input"</b>.
                                    </li>
                                    <li>Jika terjadi kesalahan dalam penginputan data, harap segera melapor kepada Bagian
                                        Admin untuk mengajukan permohonan<br> koreksi atau pembetulan data.</li>
                                </ol>

                                <!-- Gambar diletakkan mutlak di kanan bawah -->
                                <img src="../../assets/img/air.png" class="mb-3 img-fluid d-none d-lg-block"
                                    style="position: absolute; bottom: 20px; right: 40px; max-height:200px;"
                                    alt="Maskot Air">
                            </div>
                        </div>
                    @endif
                    <div class="table-responsive {{ Session::get('jabatan') == 5 ? 'd-none' : '' }}">
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
                        </table>
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
                                    <div class="d-flex mb-1" style="line-height: 1.2; font-size: 13px;">
                                        <div class="fw-bold" style="width: 120px;">Cater</div>
                                        <div><span>:</span> <span id="NamaCater"></span></div>
                                    </div>
                                    <div class="d-flex" style="line-height: 1.2; font-size: 13px;">
                                        <div class="fw-bold" style="width: 120px;">Maksimal Bayar</div>
                                        <div><span>:</span> <span id="TanggalCetak"></span></div>
                                    </div>
                                </div>

                                <div style="width: 200px; align-self: flex-end; margin-top: 2px;">
                                    <input type="text" id="SearchTagihan" class="form-control form-control-sm"
                                        placeholder="Search ...">
                                </div>
                            </div>

                            <table id="TbTagihan" class="table table-striped midle">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <td align="center" width="40">
                                            <div class="form-check text-center ps-0 mb-0">
                                                <input class="form-check-input" type="checkbox" value="true"
                                                    id="checked" name="checked" checked>
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
                            <form action="/usages/cetak_input" method="post" id="FormCetakBonggol" target="_blank">
                                @csrf
                                <div id="formbonggol"></div>
                            </form>
                        </div>
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
            var table = ''

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

                var tahun = "{{ date('Y') }}";
                var bulanTerpilih = '01' + '/' + $('#bulan').val() + '/' + tahun;
                var caterId = $('#caters').val();

                if (bulanTerpilih && caterId) {
                    window.location.href = '/usages/create?bulan=' + bulanTerpilih + '&cater_id=' + caterId;
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Silakan pilih bulan dan cater terlebih dahulu sebelum melakukan input pemakaian.',
                    });
                }
            });


            var cater = $('#caters').val()
            var bulan = $('#bulan').val()
            var columns = [{
                    "data": "customers.nama"
                },
                {
                    "data": "kode_instalasi_dengan_inisial"
                },
                {
                    "data": "awal"
                },
                {
                    "data": "akhir"
                },
                {
                    "data": "jumlah"
                },
                {
                    "data": "nominal"
                },
                {
                    "data": "tgl_akhir",
                    "render": function(data, type, row) {
                        if (!data) return '';

                        var parts = data.split('/');
                        if (parts.length !== 3) return data;

                        var day = parseInt(parts[0], 10);
                        var month = parseInt(parts[1], 10) - 1;
                        var year = parseInt(parts[2], 10);

                        var t = new Date(year, month, day);
                        t.setDate(t.getDate() - 1);

                        var dd = String(t.getDate()).padStart(2, '0');
                        var mm = String(t.getMonth() + 1).padStart(2, '0');
                        var yyyy = t.getFullYear();

                        return dd + '/' + mm + '/' + yyyy;
                    }
                },
                {
                    "data": "status"
                }
            ];

            @if (Session::get('jabatan') != 5)
                columns.push({
                    "data": "aksi"
                });
            @endif


            $('#caters, #bulan').on('change', function() {
                cater = $('#caters').val()
                bulan = $('#bulan').val()

                if (cater != '') {
                    if (table == '') {
                        table = $('#TbPemakain').DataTable({
                            "processing": true,
                            "serverSide": true,
                            "ajax": {
                                "url": "/usages?bulan=" + bulan + "&cater=" + cater,
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
                            "columns": columns
                        });
                    } else {
                        table.ajax.url("/usages?bulan=" + bulan + "&cater=" + cater).load();
                    }
                }
            });

            function fetchAllDataFullAndShowModal() {
                $.ajax({
                    url: "/usages",
                    type: "GET",
                    data: {
                        bulan: $('#bulan').val(),
                        cater: $('#caters').val(),
                    },
                    success: function(response) {
                        const fullData = response.data || response;

                        if (fullData.length > 0) {
                            const cater = $('#caters').val();
                            const caterText = $('#caters option:selected').text(); // Ambil nama cater
                            const tanggal = fullData[0].tgl_akhir;
                            var tgl = tanggal.split('/');
                            var hari = tgl[0] - 1;

                            $('#NamaCater').text(caterText); // Tampilkan nama, bukan ID
                            $('#TanggalCetak').text(hari + '/' + tgl[1] + '/' + tgl[2]);
                            $('#InputCater').val(cater);
                            $('#InputTanggal').val(tanggal);
                        }

                        setTableData(fullData);
                        $('#CetakBuktiTagihan').modal('show');
                    },
                    error: function(err) {
                        alert('Gagal mengambil data lengkap');
                    }
                });
            }

            $(document).on('click', '#DetailCetakBuktiTagihan', function(e) {
                fetchAllDataFullAndShowModal();
            });


            function setTableData(data) {
                const tbTagihan = $('#TbTagihan');
                tbTagihan.find('tbody').html('');

                const groupedByDusun = {};
                data.forEach(item => {
                    const dusun = item.installation?.village?.dusun || '';
                    if (!groupedByDusun[dusun]) groupedByDusun[dusun] = [];
                    groupedByDusun[dusun].push(item);
                });

                const sortedDusuns = Object.keys(groupedByDusun).sort();

                sortedDusuns.forEach(dusun => {
                    const items = groupedByDusun[dusun];
                    items.sort((a, b) => parseInt(a.installation?.rt || 0) - parseInt(b.installation?.rt || 0));

                    tbTagihan.find('tbody').append(`
                            <tr class="table-secondary fw-bold">
                                <td colspan="11">Dusun : ${dusun}</td>
                            </tr>
                        `);

                    items.forEach(item => {
                        tbTagihan.find('tbody').append(`
                <tr>
                    <td align="center">
                        <div class="form-check text-center ps-0 mb-0">
                            <input checked class="form-check-input" type="checkbox" value="${item.id}" id="${item.id}" name="cetak[]" data-input="checked" data-bulan="${item.bulan}">
                        </div>
                    </td>
                    <td align="left">${item.customers.nama}</td>
                    <td align="left">${item.installation?.village?.nama}</td>
                    <td align="center">${item.installation?.rt}</td>
                    <td align="center">${item.installation?.kode_instalasi} ${item.installation?.package?.kelas.charAt(0)}</td>
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

            $(document).on('change', '#tahun_pakai, #bulan_pakai', function (e) {
                e.preventDefault();

                var tahun = $('#tahun_pakai').val();
                var bulan = $('#bulan_pakai').val();

                var tanggalBulan = tahun + '-' + bulan + '-01';
                $('#bulan).val(tanggalBulan)
            })

            $(document).on('click', '#BtnCetak', function(e) {
                e.preventDefault()

                if ($('#FormCetakBuktiTagihan').serializeArray().length > 1) {
                    var formTagihan = $('#FormCetakBuktiTagihan');

                    var bulan = $('#bulan').val()
                    var caters = $('#caters').val()

                    formTagihan.find('form').html('')
                    var row = formTagihan.append(`
                    <input type="hidden" name="bulan_tagihan" value="${bulan}">
                    <input type="hidden" name="pemakaian_cater" value="${cater}">
                `);
                    formTagihan.submit();
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
                <input type="hidden" name="cater" value="${cater}">
            `);

                $('#FormCetakTagihan').submit();
            })
            $(document).on('click', '#BtnCetak2', function(e) {
                e.preventDefault();

                var formTagihan = $('#formbonggol');

                var bulan = $('#bulan').val();
                var cater = $('#caters').val();

                formTagihan.html('');

                formTagihan.append(`
        <input type="hidden" name="bulan_tagihan" value="${bulan}">
        <input type="hidden" name="cater" value="${cater}">
    `);

                $('#FormCetakBonggol').submit();
            });
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
                var actionUrl = '/usages/' + hapus_pemakaian; // URL endpoint untuk proses hapus

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
                                        window.location.href = '/usages/';
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
        <script>
            document.getElementById('SearchTagihan').addEventListener('keyup', function() {
                const keyword = this.value.toLowerCase();
                const rows = document.querySelectorAll('#TbTagihan tbody tr');

                let currentGroup = null;
                let groupVisible = false;

                rows.forEach(row => {
                    if (row.classList.contains('table-secondary')) {
                        // Ini baris grup (Dusun)
                        currentGroup = row;
                        groupVisible = false;
                        return;
                    }

                    // Gabungkan semua isi sel dalam satu baris
                    const rowText = Array.from(row.cells).map(cell => cell.textContent.toLowerCase()).join(' ');
                    const match = rowText.includes(keyword);

                    row.style.display = match ? '' : 'none';
                    if (match && currentGroup) groupVisible = true;

                    // Jika baris berikutnya bukan baris data, simpan status grup
                    const nextRow = row.nextElementSibling;
                    if (!nextRow || nextRow.classList.contains('table-secondary')) {
                        if (currentGroup) {
                            currentGroup.style.display = groupVisible ? '' : 'none';
                            currentGroup = null;
                        }
                    }
                });
            });
        </script>
    @endsection
