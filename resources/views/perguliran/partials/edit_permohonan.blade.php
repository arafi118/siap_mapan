@extends('layouts.base')
@php
    $status = $settings->swit_tombol ?? null;
@endphp
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Bagian Informasi Customer -->

                    <div class="alert alert-info" role="alert">
                        <div class="row">
                            <div class="col-md-2 mb-2">
                                <div class="col-md-3 text-center">
                                    <div class="d-inline-block border border-2 rounded bg-light shadow-sm"
                                        style="width: 120px; height: 120px; padding: 10px; display: flex; align-items: center; justify-content: left;">
                                        {!! $qr !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10 mb-2">
                                <h4 class="alert-heading">
                                    <b>Nama Pelanggan: {{ $installations->customer->nama }}</b>
                                </h4>
                                <hr>
                                <p class="mb-0">
                                    Desa {{ $installations->village->nama }},
                                    {{ $installations->alamat }}, [Koordinate: {{ $installations->koordinate }}].
                                </p>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="4">Permohonan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <div class="row">
                                    <div class="col-md-8 mb-2">
                                        <select class="select2 form-control" name="caters" id="caters">
                                            <option value=""></option>
                                            @foreach ($caters as $cater)
                                                <option value="{{ $cater->id }}">{{ $cater->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="text" name="tanggal" id="tanggal" class="form-control date"
                                            value="{{ date('d/m/Y') }}">
                                    </div>
                                </div>
                                <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                    <span style="float: left;">Paket Instalasi</span>
                                    <span class="badge badge-success"
                                        style="float: right; width: 30%; padding: 5px; text-align: center;">
                                        {{ $installations->package->kelas }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                    <span style="float: left;">No. Induk</span>
                                    <span class="badge badge-success"
                                        style="float: right; width: 30%; padding: 5px; text-align: center;">
                                        {{ $installations->kode_instalasi }}
                                        {{ substr($installations->package->kelas, 0, 1) }}
                                    </span>
                                </td>
                                <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                    <span style="float: left;">Abodemen</span>
                                    <span class="badge badge-success"
                                        style="float: right; width: 30%; padding: 5px; text-align: center;">
                                        {{ number_format($installations->abodemen, 2) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                    <span style="float: left;">Desa</span>
                                    <span class="badge badge-success"
                                        style="float: right; width: 30%; padding: 5px; text-align: center;">
                                        {{ $installations->village->nama }}
                                    </span>
                                </td>
                                <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                    <span style="float: left;">Status Instalasi</span>
                                    @if ($installations->status === 'R')
                                        <span class="badge badge-success"
                                            style="float: right; width: 30%; padding: 5px; text-align: center;">
                                            PAID
                                        </span>
                                    @elseif($installations->status === '0')
                                        <span class="badge badge-warning"
                                            style="float: right; width: 30%; padding: 5px; text-align: center;">
                                            UNPAID
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <form action="/installations/{{ $installations->id }}" method="post" id="FormEditPermohonan">
                        @csrf
                        @method('PUT')
                        <input type="text" name="status" id="status" value="EditData" hidden>
                        <div class="row">
                            <div class="card-body">
                                <div class="alert alert-light" role="alert">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="order">Tanggal Order</label>
                                                <input type="text" class="form-control date" name="order"
                                                    id="order" aria-describedby="order" placeholder="order"
                                                    value="{{ date('d/m/Y') }}">
                                                <small class="text-danger" id="msg_order"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="alamat">Alamat</label>
                                                <input type="text" class="form-control" id="alamat" name="alamat"
                                                    aria-describedby="alamat" placeholder="Alamat"
                                                    value="{{ $installations->alamat }}">
                                                <small class="text-danger" id="msg_alamat"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label for="koordinate">Koordinate</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control"
                                                    placeholder="Masukkan Link Koordinate" aria-describedby="koordinate"
                                                    name="koordinate" id="koordinate"
                                                    value="{{ $installations->koordinate }}">
                                                <div class="input-group-append">
                                                    {{-- https://www.google.com/maps/place/-7.462512371777572,%20110.1149253906747 --}}
                                                    <span class="input-group-text" id="basic-addon2">
                                                        <a href="https://maps.google.com/" target="_blank"
                                                            style="color: white; text-decoration: none;">Google Maps</a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-relative mb-3">
                                                <label for="biaya_instalasi">Nominal</label>
                                                <input type="text" class="form-control" name="biaya_instalasi"
                                                    id="biaya_instalasi" aria-describedby="biaya_instalasi"
                                                    placeholder="biaya_instalasi"value="{{ number_format($installations->biaya_instalasi, 2) }}"
                                                    disabled>
                                                <small class="text-danger" id="msg_biaya_instalasi"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="formEditjenis_paket">
                                    </div>
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

                                    <button class="btn btn-secondary btn-icon-split" type="submit" id="SimpanEdit"
                                        class="btn btn-dark" style="float: right; margin-left: 10px;">
                                        <span class="icon text-white-50 d-none d-lg-block"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-sign-intersection-fill"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                            </svg>
                                        </span><span class="text" style="float: right;">Simpan Perubahan</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).on('click', '#kembali', function(e) {
            e.preventDefault();
            window.location.href = '/installations?status=R';
        });

        $("#abodemen").maskMoney({
            allowNegative: true
        });

        $("#total").maskMoney({
            allowNegative: true
        });

        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
            });
        });

        jQuery.datetimepicker.setLocale('de');
        $('.date').datetimepicker({
            i18n: {
                de: {
                    months: [
                        'Januar', 'Februar', 'März', 'April',
                        'Mai', 'Juni', 'Juli', 'August',
                        'September', 'Oktober', 'November', 'Dezember',
                    ],
                    dayOfWeek: [
                        "So.", "Mo", "Di", "Mi",
                        "Do", "Fr", "Sa.",
                    ]
                }
            },
            timepicker: false,
            format: 'd/m/Y'
        });

        $(document).on('click', '#SimpanEdit', function(e) {
            e.preventDefault();
            $('small').html('');

            var form = $('#FormEditPermohonan');
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {

                    if (result.success) {
                        toastMixin.fire({
                            text: result.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        setTimeout(() => {
                            window.location.href = '/installations?status=P';
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
@endsection
