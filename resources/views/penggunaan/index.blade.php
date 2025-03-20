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
                    <table class="table align-items-center table-flush" id="TbPemakain">
                        <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                            <!-- Data Desa -->
                            <div style="display: flex; align-items: center;">
                                <i class="fas fa-tint" style="font-size: 28px; margin-right: 8px;"></i>
                                <b>Data Pemakaian</b>
                            </div>
                            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                                @if (auth()->user()->jabatan == 1)
                                    <button class="btn btn-danger" type="button" id="DetailCetakBuktiTagihan">
                                        <i class="fas fa-info-circle">&nbsp;</i> Cetak Tagihan
                                    </button>
                                @endif
                                <button class="btn btn-warning" id="Registerpemakaian"
                                    @if (Session::get('jabatan') == 6) disabled @endif>
                                    <i class="fas fa-plus">&nbsp;</i> Input Data Pemakaian
                                </button>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <thead class="thead-light" align="center">
                            <tr>
                                <th>NAMA</th>
                                <th>KODE INSTALASI</th>
                                <th>AWAL PEMAKAIAN</th>
                                <th>AKHIR PEMAKAIAN</th>
                                <th>JUMLAH PEMAKAIAN</th>
                                <th>TOTAL </th>
                                <th>TANGGAL AKHIR</th>
                                <th>Status</th>
                                @if (auth()->user()->jabatan == 1)
                                    <th style="text-align: center;">AKSI</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usages as $usage)
                                <tr>
                                    <td>{{ $usage->customers ? $usage->customers->nama : '' }}</td>
                                    <td>{{ $usage->installation ? $usage->installation->kode_instalasi : '' }}</td>
                                    <td>{{ $usage->awal }}</td>
                                    <td>{{ $usage->akhir }}</td>
                                    <td>{{ $usage->jumlah }}</td>
                                    <td>{{ number_format($usage->nominal, 2) }}</td>
                                    <td>{{ $usage->tgl_akhir }}</td>
                                    <td>
                                        @if ($usage->status === 'PAID')
                                            <span class="badge badge-success">PAID</span>
                                        @elseif($usage->status === 'UNPAID')
                                            <span class="badge badge-warning">UNPAID</span>
                                        @endif
                                    </td>
                                    @if (auth()->user()->jabatan == 1)
                                        <td style="text-align: center; display: flex; gap: 5px; justify-content: center;">
                                            {{-- <a href="/usages/{{ $usage->id }}/edit" class="btn btn-warning btn-sm">
            <i class="fas fa-pencil-alt"></i>
        </a> --}}
                                            <a href="#" data-id="{{ $usage->id }}"
                                                class="btn-sm btn-danger mx-1 Hapus_pemakaian">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </tbody>
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
                    <div id="LayoutCetakBuktiTagihan"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="BtnCetak" class="btn btn-sm btn-info">
                        Print
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
        $(document).on('click', '#kembali', function(e) {
            e.preventDefault();
            window.location.href = '/usages';
        });

        $(document).on(' click', '#Registerpemakaian', function(e) {
            e.preventDefault();
            window.location.href = '/usages/create';
        });

        $(document).ready(function() {
            $('#TbPemakain').DataTable(); // ID From dataTable 
        });

        $(document).on('click', '#DetailCetakBuktiTagihan', function(e) {
            $.ajax({
                url: '/usages/detail_tagihan',
                type: 'get',
                success: function(result) {
                    console.log(result);
                    $('#CetakBuktiTagihan').modal('show');
                    $('#CetakBuktiTagihanLabel').html(result.label);
                    $('#LayoutCetakBuktiTagihan').html(result.cetak);
                }
            });
        });

        $(document).on('click', '#BtnCetak', function(e) {
            e.preventDefault()

            if ($('#FormCetakBuktiTagihan').serializeArray().length > 1) {
                $('#FormCetakBuktiTagihan').submit();
            } else {
                Swal.fire('Error', "Tidak ada transaksi yang dipilih.", 'error')
            }
        })
    </script>

    @if (Session::has('berhasil'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ Session::get('berhasil') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
        <script>
            // Menghilangkan notifikasi setelah 5 detik
            document.addEventListener('DOMContentLoaded', function() {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 2000); // 2000ms = 2 detik
                }
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
    </script>
@endsection
