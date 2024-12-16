@extends('layouts.base')

@php
    $blok = json_decode($tampil_settings->block, true);
    $jumlah_blok = count($blok);
@endphp

@section('content')
    <!-- Row tampil data -->
    <div class="col-lg-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div style="display: flex; align-items: center;">
                <i class="fa fa-cubes" style="font-size: 30px; margin-right: 7px;"></i>
                <b>Daftar Harga Paket</b>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <div class="col-12 d-flex justify-content-end">
                        <a href="/packages/create" class="btn btn-primary btn-icon-split" id="SimpanPaket"
                            style="float: right; margin-left: 10px;">
                            <span class="icon text-white-50">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                </svg>
                            </span>
                            <span class="text" style="float: right;">Tambah Paket</span>
                        </a>
                    </div>
                    <table class="table align-items-center table-flush table-hover" id="TbPaket">
                        <thead class="thead-light">
                            <div>&nbsp;</div>
                            <tr>
                                <th>KELAS</th>
                                @for ($i = 0; $i < $jumlah_blok; $i++)
                                    <th>{{ $blok[$i]['nama'] }} .[ {{ $blok[$i]['jarak'] }} ]</th>
                                @endfor
                                <th>BEBAN</th>
                                <th>DENDA</th>
                                <th style="text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $paket)
                                @php
                                    $harga = json_decode($paket->harga, true);
                                @endphp
                                <tr>
                                    <td>{{ $paket->kelas }}</td>
                                    @for ($i = 0; $i < $jumlah_blok; $i++)
                                        <td>{{ number_format(isset($harga[$i]) ? $harga[$i] : '0', 2) }}
                                        </td>
                                    @endfor
                                    <td>{{ number_format($paket->abodemen, 2) }}
                                    </td>
                                    <td>{{ number_format($paket->denda, 2) }}
                                    </td>
                                    <td class="action-buttons">
                                        <a href="/packages/{{ $paket->id }}/edit" class="btn-sm btn-warning mx-1"><i
                                                class="fas fa-pencil-alt"></i></a>

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
        // index
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
                                    window.location.href = '/packages/';
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
        //endindex
    </script>
@endsection
