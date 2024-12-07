@extends('layouts.base')

@php
    $blok = json_decode($tampil_settings->block, true);
    $jumlah_blok = count($blok);
@endphp

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert" id="success-alert">
            <li class="	fas fa-check-circle"></li>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('success') }}
        </div>
    @endif

    <!-- Row -->
    <div class="col-lg-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div style="display: flex; align-items: center;">
                <i class="fa fa-cubes" style="font-size: 30px; margin-right: 7px;"></i>
                <b>Daftar Harga Paket</b>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="TbPaket">
                        <thead class="thead-light">
                            <div>&nbsp;</div>
                            <tr>
                                <th>KELAS</th>
                                <th>HARGA</th>
                                <th>BEBAN</th>
                                <th>DENDA</th>
                                <th style="text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $paket)
                                <tr>
                                    <td>{{ $paket->kelas }}</td>
                                    <td>{{ $paket->harga }}</td>
                                    <td>{{ $paket->abodemen }}</td>
                                    <td>{{ $paket->denda }}</td>
                                    <td style="text-align: center;">
                                        <a href="/packages/{{ $paket->id }}/edit" class="btn-sm btn-warning"><i
                                                class=" fas fa-pencil-alt"></i></a>
                                        <a href="#" data-id="{{ $paket->id }}"
                                            class="btn-sm btn-danger mx-1 Hapus_paket"><i class="fas fa-trash-alt"></i>
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
    <form action="" method="post" id="FormHapus">
        @method('DELETE')
        @csrf
    </form>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#TbPaket').DataTable(); // ID From dataTable 
        });

        $(document).on('click', '.Hapus_paket', function(e) {
            e.preventDefault();

            var hapus_paket = $(this).attr('data-id'); // Ambil ID yang terkait dengan tombol hapus
            var actionUrl = '/packages/' + hapus_paket; // URL endpoint untuk proses hapus

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
                    var form = $('#FormHapus')
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
                                    window.location.href = '/package/';
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
