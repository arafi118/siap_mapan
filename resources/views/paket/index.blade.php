@extends('layouts.base')

@php
    $blok = json_decode($tampil_settings->block, true);
    $jumlah_blok = count($blok);
@endphp

@section('content')
    <form action="/packages" method="post" id="tambahpaket">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Bagian Informasi Customer -->
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <!-- Gambar -->
                            <img src="../../assets/img/air.png" style="max-height: 250px; margin-right: 20px;"
                                class="img-fluid">
                            <div class="w-100">
                                <h4 class="alert-heading"><b>Tentukan Harga Paket</b></h4>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="position-relative mb-2">
                                            <label for="kelas" class="form-label">Kelas</label>
                                            <input autocomplete="off" maxlength="16" type="text" name="kelas"
                                                id="kelas" class="form-control form-control-sm">
                                            <small class="text-danger" id="msg_kelas"></small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="position-relative mb-2">
                                            <label for="abodemen" class="form-label">Abodemen</label>
                                            <input autocomplete="off" type="text" name="abodemen" id="abodemen"
                                                class="form-control form-control-sm"
                                                value="{{ number_format($tampil_settings->abodemen, 2) }}">
                                            <small class="text-danger" id="msg_abodemen"></small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="position-relative mb-2">
                                            <label for="denda" class="form-label">Denda</label>
                                            <input autocomplete="off" type="text" name="denda" id="denda"
                                                class="form-control form-control-sm"
                                                value="{{ number_format($tampil_settings->denda, 2) }}">
                                            <small class="text-danger" id="msg_denda"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @for ($i = 0; $i < $jumlah_blok; $i++)
                                        <div class="col-{{ 12 / $jumlah_blok }}">
                                            <div class="position-relative mb-2">
                                                <label for="block_1" class="form-label">{{ $blok[$i]['nama'] }} .
                                                    [ {{ $blok[$i]['jarak'] }} ]
                                                </label>
                                                <input autocomplete="off" maxlength="16" type="text" name="blok[]"
                                                    id="block_{{ $i }}"
                                                    class="form-control form-control-sm block">
                                                <small class="text-danger" id="msg_block_{{ $i }}"></small>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                                <hr>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#ModelNewblock" id="BTNNewblock">
                                        Launch demo modal
                                    </button>
                                    <button class="btn btn-secondary btn-icon-split" type="submit" id="SimpanPaket"
                                        class="btn btn-dark" style="float: right; margin-left: 10px;">
                                        <span class="icon text-white-50"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="16" height="16" fill="currentColor"
                                                class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                            </svg>
                                        </span><span class="text" style="float: right;">Simpan Harga</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

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
    <script>
        // create 
        $("#abodemen").maskMoney({
            allowNegative: true
        });
        $("#denda").maskMoney({
            allowNegative: true
        });
        $(".block").maskMoney({
            allowNegative: true
        });

        $(document).on('click', '#SimpanPaket', function(e) {
            e.preventDefault();
            $('small').html('');

            var form = $('#tambahpaket');
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            title: result.msg,
                            text: "Tambahkan Paket Baru?",
                            icon: "success",
                            showDenyButton: true,
                            confirmButtonText: "Tambahkan",
                            denyButtonText: `Tidak`
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload()
                            } else {
                                window.location.href = '/packages/';
                            }
                        });
                    }
                },
                error: function(result) {
                    const response = result.responseJSON;

                    Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error');

                    if (response && typeof response === 'object') {
                        $.each(response, function(key, message) {
                            $('#' + key)
                                .closest('.input-group.input-group-static')
                                .addClass('is-invalid');

                            $('#msg_' + key).html(message);
                        });
                    }
                }
            });
        });
    </script>
@endsection
