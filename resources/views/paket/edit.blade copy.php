@extends('layouts.base')
@php
    $blok = json_decode($tampil_settings->block, true);
    $jumlah_blok = count($blok);
    $harga = json_decode($package->harga, true);
@endphp

@section('content')
    <form action="/packages/{{ $package->id }}" method="post" id="paket">
        @csrf
        @method('PUT')

        <div class="alert alert-info d-flex align-items-center" role="alert">
            <!-- Gambar -->
            <img src="../../assets/img/air.png" style="max-height: 250px; margin-right: 20px;" class="img-fluid">
            <div>
                <h4 class="alert-heading"><b>Edit Harga Paket</b></h4>
                <hr>
                <div class="row">
                    <div class="col-4">
                        <div class="position-relative mb-2">
                            <label for="kelas" class="form-label">Kelas</label>
                            <input autocomplete="off" maxlength="16" type="text" name="kelas" id="kelas"
                                class="form-control form-control-sm" value="{{ $package->kelas }}">
                            <small class="text-danger" id="msg_kelas"></small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="position-relative mb-2">
                            <label for="abodemen" class="form-label">Beban</label>
                            <input autocomplete="off" type="text" name="abodemen" id="abodemen"
                                class="form-control form-control-sm" value="{{ number_format($package->abodemen, 2) }}">
                            <small class="text-danger" id="msg_abodemen"></small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="position-relative mb-2">
                            <label for="denda" class="form-label">Denda</label>
                            <input autocomplete="off" type="text" name="denda" id="denda"
                                class="form-control form-control-sm" value="{{ number_format($package->denda, 2) }}">
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
                                    id="block_{{ $i }}" class="form-control form-control-sm block"
                                    value="{{ number_format(isset($harga[$i]) ? $harga[$i] : '0', 2) }}">
                                <small class="text-danger" id="msg_block_{{ $i }}"></small>
                            </div>
                        </div>
                    @endfor
                </div>
                <hr>
                <div class="col-12 text-right">
                    <button class="btn btn-secondary btn-icon-split" type="submit" id="EditPaket" class="btn btn-dark"
                        style="float: right; margin-left: 10px;">
                        <span class="icon text-white-50"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                height="16" fill="currentColor" class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                <path
                                    d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                            </svg>
                        </span><span class="text" style="float: right;">Simpan Harga</span>
                    </button>
                    <a href="/packages" class="btn btn-primary btn-icon-split" style="float: right;">
                        <span class="icon text-white-50">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-sign-turn-slight-left-fill" viewBox="0 0 16 16">
                                <path
                                    d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM6.864 8.368a.25.25 0 0 1-.451-.039l-1.06-2.882a.25.25 0 0 1 .192-.333l3.026-.523a.25.25 0 0 1 .26.371l-.667 1.154.621.373A2.5 2.5 0 0 1 10 8.632V11H9V8.632a1.5 1.5 0 0 0-.728-1.286l-.607-.364-.8 1.386Z" />
                            </svg>
                        </span>
                        <span class="text">Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection

<script>
    // edit data

    $("#abodemen").maskMoney({
        allowNegative: true
    });
    $("#denda").maskMoney({
        allowNegative: true
    });
    $(".block").maskMoney({
        allowNegative: true
    });

    $(document).on('click', '#EditPaket', function(e) {
        e.preventDefault();
        $('small').html('');

        var form = $('#editpaket');
        var actionUrl = form.attr('action');

        $.ajax({
            type: 'POST',
            url: actionUrl,
            data: form.serialize(),
            success: function(result) {
                if (result.success) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: result.msg,
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(() => {
                        window.location.href = '/packages/';
                    }, 1500);
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