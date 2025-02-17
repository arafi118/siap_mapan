@extends('layouts.base')

@section('content')
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="TbDesa">
                        <thead class="thead-light">
                            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                <!-- Data Desa -->
                                <div style="display: flex; align-items: center;">
                                    <i class="fas fa-home" style="font-size: 30px; margin-right: 9px;"></i>
                                    <b>Data Desa</b>
                                </div>
                            </div>
                            <div>&nbsp;</div>
                            <tr>
                                <th>KODE</th>
                                <th>NAMA DESA</th>
                                <th>ALAMAT</th>
                                <th>TELPON</th>
                                <th style="text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($villages as $village)
                                <tr>
                                    <td>{{ $village->kode }}</td>
                                    <td>{{ $village->nama }}</td>
                                    <td style="padding: 3px; word-wrap: break-word; max-width: 200px;">
                                        {{ $village->alamat }}
                                    </td>
                                    <td>{{ $village->hp }}</td>
                                    <td style="text-align: center; display: flex; gap: 5px; justify-content: center;">
                                        <a href="/villages/{{ $village->id }}/edit" class="btn btn-warning btn-sm">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a href="#" data-id="{{ $village->id }}"
                                            class="btn btn-danger btn-sm mx-1 Hapus_desa"><i class="fas fa-trash-alt"></i>
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
    <form action="" method="post" id="FormHapusDesa">
        @method('DELETE')
        @csrf
    </form>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#TbDesa').DataTable(); // ID From dataTable 
        });
    </script>

    @if (session('jsedit'))
        <script>
            //edit
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Edit Data Berhasil',
                    text: '{{ Session::get('jsedit') }}',
                    showConfirmButton: false,
                    timer: 2000 // Notifikasi otomatis hilang setelah 2 detik
                });
            });
        </script>
    @endif

    @if (Session::has('berhasil'))
        <script>
            //tambah
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ Session::get('berhasil') }}',
                    showConfirmButton: false,
                    timer: 2000 // Notifikasi otomatis hilang setelah 2 detik
                });
            });
        </script>
    @endif
    <script>
        $(document).on('click', '.Hapus_desa', function(e) {
            e.preventDefault();

            var hapus_desa = $(this).attr('data-id'); // Ambil ID yang terkait dengan tombol hapus
            var actionUrl = '/villages/' + hapus_desa; // URL endpoint untuk proses hapus

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
                    var form = $('#FormHapusDesa')
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
                                    window.location.href = '/villages/';
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
