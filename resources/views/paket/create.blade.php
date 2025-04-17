@extends('layouts.base')
@php
    $blok = json_decode($tampil_settings->block, true);
    $jumlah_blok = count($blok);
@endphp

@section('content')
    <form action="/packages" method="post" id="tambahpaket">
        @csrf

        <input type="hidden" name="abodemen" id="abodemen" value="{{ $tampil_settings->abodemen }}">
        <input type="hidden" name="denda" id="denda" value="{{ $tampil_settings->denda }}">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Bagian Informasi Customer -->
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <!-- Gambar -->
                            <img src="../../assets/img/air.png" style="max-height: 250px; margin-right: 20px;"
                                class="img-fluid d-none d-lg-block">
                            <div class="w-100">
                                <h4 class="alert-heading"><b>Tentukan Harga Paket</b></h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="position-relative mb-2">
                                            <label for="kelas" class="form-label">Kelas</label>
                                            <input autocomplete="off" maxlength="16" type="text" name="kelas"
                                                id="kelas" class="form-control form-control-sm">
                                            <small class="text-danger" id="msg_kelas"></small>
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
                                    <button id="kembali" class="btn btn-light btn-icon-split">
                                        <span class="icon text-white-50 d-none d-lg-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-sign-turn-slight-left-fill"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM6.864 8.368a.25.25 0 0 1-.451-.039l-1.06-2.882a.25.25 0 0 1 .192-.333l3.026-.523a.25.25 0 0 1 .26.371l-.667 1.154.621.373A2.5 2.5 0 0 1 10 8.632V11H9V8.632a1.5 1.5 0 0 0-.728-1.286l-.607-.364-.8 1.386Z" />
                                            </svg>
                                        </span>
                                        <span class="text">Kembali</span>
                                    </button>

                                    <button class="btn btn-info btn-icon-split" type="button" data-toggle="modal"
                                        data-target="#ModalTampilBlock" id="#modalCenter"
                                        style="float: right; margin-left: 10px;">
                                        <span class="icon text-white-50 d-none d-lg-block"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-sign-intersection-fill"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                            </svg>
                                        </span><span class="text" style="float: right;">Block</span>
                                    </button>

                                    <button class="btn btn-secondary btn-icon-split" type="submit" id="SimpanPaket"
                                        class="btn btn-dark" style="float: right; margin-left: 10px;">
                                        <span class="icon text-white-50 d-none d-lg-block"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-sign-intersection-fill"
                                                viewBox="0 0 16 16">
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
@endsection


@section('modal')
    {{-- modal tampil block --}}
    <div class="modal fade" id="ModalTampilBlock" tabindex="-1" role="dialog" aria-labelledby="titleblock"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleblock">Tambah Block Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('paket.block_paket')
                </div>
            </div>
        </div>
    </div>
    {{-- end modal tampil block --}}
@endsection

@section('script')
    <script>
        $(document).on('click', '#kembali', function(e) {
            e.preventDefault();
            window.location.href = '/packages';
        });
        // block paket

        $(document).on('click', '#blockinput', function(e) {
            e.preventDefault()

            var container = $('#inputFromblock')
            var row = $('<div>').addClass('row mb-3')
            var block = $('#RowBlock').html()

            row.html(block)
            container.append(row)
        })

        $('#blockinput').trigger('click')

        $(document).on('click', '#SimpanBlock', function(e) {
            e.preventDefault();
            var form = $('#Fromblock');
            var actionUrl = form.attr('action');

            var toastMixin = Swal.mixin({
                toast: true,
                icon: 'success',
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            $.ajax({
                type: 'GET',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        toastMixin.fire({
                            title: 'Pembaruhan Block Paket Berhasil'
                        });
                        // window.location.href = '/packages/';
                        setTimeout(() => window.location.reload(), 3000);
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error');
                }
            });
        });
        //endblok
    </script>
    <script>
        // create 
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
        //endcreate
    </script>
@endsection
