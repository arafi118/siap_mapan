@extends('layouts.base')
@section('content')
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                        <div style="display: flex; align-items: center;">
                            <i class="" style="font-size: 30px; margin-right: 9px;"></i>
                            <b>Data Instalasi</b><br><br>
                        </div>
                    </div>
                    <table class="table align-items-center table-flush" id="TbIns">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 5%;">ID</th>
                                <th style="width: 15%;">Kode</th>
                                <th style="width: 25%;">Nama Pelanggan</th>
                                <th style="width: 20%;">Desa</th>
                                <th style="width: 20%;">Dusun</th>
                                <th style="width: 20%;">RT</th>
                                <th style="width: 35%;">Alamat</th>
                                <th style="width: 35%;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($installations as $ins)
                                @php
                                    dd($ins);
                                @endphp
                                <tr>
                                    <td>{{ $ins->id }}</td>
                                    <td>{{ $ins->kode_instalasi }}-{{ $ins->package->inisial }}</td>
                                    <td>{{ $ins->customer->nama }}</td>
                                    <td>{{ $ins->village->nama ?? '-' }}</td>
                                    <td>{{ $ins->village->dusun ?? '-' }}</td>
                                    <td>{{ $ins->rt ?? '00' }}</td>
                                    <td>{{ $ins->alamat }}</td>
                                    <td>{{ $ins->status }}</td>
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
            $('#TbIns').DataTable(); // ID From dataTable 
        });
    </script>

    {{-- @if (session('jsedit'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastMixin.fire({
                    text: '{{ Session::get('jsedit') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        </script>
    @endif --}}

    {{-- <script>
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
    </script> --}}
@endsection
