@extends('layouts.base')
@php
    // dd($customers);
@endphp
@section('content')
    <form action="/customers" method="post" id="HapusPenduduk">
        @csrf
        <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="table-responsive p-3">
                        <table class="table align-items-center table-flush" id="TbPelanggan">
                            <thead class="thead-light">
                                <div style="display: flex; align-items: center;">
                                    <i class="fas fa-users" style="font-size: 30px; margin-right: 13px;"></i>
                                    <b> Data Pelanggan</b>
                                </div>
                                <div>&nbsp;</div>
                                <tr>
                                    <th>NIK</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>ALAMAT</th>
                                    <th>TELPON</th>
                                    <th style="text-align: center;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td>{{ $customer->nik }}</td>
                                        <td>{{ $customer->nama }}</td>
                                        <td>{{ $customer->alamat }}</td>
                                        <td>{{ $customer->hp }}</td>
                                        <td style="text-align: center; display: flex; gap: 5px; justify-content: center;">
                                            <a href="/customers/{{ $customer->nik }}/edit" class="btn btn-warning btn-sm">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a href="#" data-id="{{ $customer->nik }}"
                                                class="btn-sm btn-danger mx-1 Hapus_pelanggan">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--Row-->

    <!-- Documentation Link -->

    <!-- Modal Logout -->

    <form action="" method="post" id="FormHapusPelanggan">
        @method('DELETE')
        @csrf
    </form>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#TbPelanggan').DataTable(); // ID From dataTable 
        });

        //hapus pelangan
        $(document).on('click', '.Hapus_pelanggan', function(e) {
            e.preventDefault();

            var hapus_id = $(this).attr('data-id'); // Ambil ID yang terkait dengan tombol hapus
            var actionUrl = '/customers/' + hapus_id; // URL endpoint untuk proses hapus

            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data akan dihapus secara permanen dari aplikasi dan tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#FormHapusPelanggan');
                    $.ajax({
                        type: form.attr('method'), // Gunakan metode HTTP DELETE
                        url: actionUrl,
                        data: form.serialize(),
                        success: function(result) {
                            if (result.success) {
                                Swal.fire({
                                    title: "Berhasil!",
                                    text: result.msg,
                                    icon: "success",
                                    confirmButtonText: "OK"
                                }).then((res) => {
                                    if (res.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: "Gagal",
                                    text: result.msg,
                                    icon: "info",
                                    confirmButtonText: "OK"
                                });
                            }
                        },
                        error: function(response) {
                            Swal.fire({
                                title: "Error",
                                text: "Terjadi kesalahan pada server. Silakan coba lagi.",
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
