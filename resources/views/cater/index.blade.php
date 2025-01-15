@extends('layouts.base')

@section('content')
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="TbCater">
                        <thead class="thead-light">
                            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                <!-- Data Desa -->
                                <div style="display: flex; align-items: center;">
                                    <i class="far fa-clipboard" style="font-size: 30px; margin-right: 9px;"></i>
                                    <b>Data Cater</b>
                                </div>
                                {{-- <div style="display: flex; justify-content: flex-end;">
                                    <a href="/caters/create" class="btn btn-primary" id="RegisterCater"
                                        style="display: inline-block; width: 130px; height: 30px; text-align: center; line-height: 18px; font-size: 12px;">
                                        <i class="fas fa-plus"></i> Register Cater
                                    </a>
                                </div> --}}
                            </div>
                            <div>&nbsp;</div>
                            <tr>
                                <th>NAMA</th>
                                <th>ALAMAT</th>
                                <th>TELPON</th>
                                {{-- <th>JENIS KELAMIN</th> --}}
                                <th>JABATAN</th>
                                <th>USERNAME</th>
                                <th>PASSWORD</th>
                                <th style="text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($caters as $cater)
                                <tr>
                                    <td>{{ $cater->nama }}</td>
                                    <td>{{ $cater->alamat }}</td>
                                    <td>{{ $cater->telpon }}</td>
                                    {{-- <td>{{ $cater->jenis_kelamin }}</td> --}}
                                    <td>{{ $cater->position->nama_jabatan }}</td>
                                    <td>{{ $cater->username }}</td>
                                    <td>{{ $cater->password }}</td>
                                    <td style="text-align: center; display: flex; gap: 5px; justify-content: center;">
                                        <a href="/caters/{{ $cater->id }}/edit" class="btn btn-warning btn-sm">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a href="#" data-id="{{ $cater->id }}"
                                            class="btn-sm btn-danger mx-1 Hapus_cater"><i class="fas fa-trash-alt"></i>
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
    <form action="" method="post" id="FormHapusCater">
        @method('DELETE')
        @csrf
    </form>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#TbCater').DataTable(); // ID From dataTable 
        });
    </script>

    @if (session('jsedit'))
        <script>
            //edit
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ Session::get('jsedit') }}',
                    showConfirmButton: false,
                    timer: 2000 // Notifikasi otomatis hilang setelah 2 detik
                });
            });
        </script>
    @endif
    <script>
        //hapus
        $(document).on('click', '.Hapus_cater', function(e) {
            e.preventDefault();

            var hapus_cater = $(this).attr('data-id'); // Ambil ID yang terkait dengan tombol hapus
            var actionUrl = '/caters/' + hapus_cater; // URL endpoint untuk proses hapus

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
                    var form = $('#FormHapusCater')
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
                                    window.location.href = '/caters/';
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
