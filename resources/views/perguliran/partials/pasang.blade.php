@extends('layouts.base')
@section('content')
    <!-- Form -->
    <form action="/installations/{{ $installation->id }}" method="post" id="Form_status_I">
        @csrf
        @method('PUT')
        <input type="text" name="status" id="status" value="{{ $installation->status }}" hidden>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Bagian Informasi Customer -->
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <table style="width: 100%;">
                                <tr>
                                    {{-- Kolom kiri: QR Code --}}
                                    <td style="width: 120px; text-align: left; vertical-align: top;">
                                        {!! $qr !!}
                                    </td>

                                    {{-- Kolom kanan: informasi customer --}}
                                    <td style="vertical-align: top;">
                                        <h4 class="alert-heading">
                                            <b>Nama Pelanggan. {{ $installation->customer->nama }}</b>
                                        </h4>
                                        <hr>
                                        <p class="mb-0">
                                            desa.{{ $installation->village->nama }},
                                            {{ $installation->alamat }}, [koordinate {{ $installation->koordinate }}].
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Tabel di Bawah Customer -->
                        <div class="mt-4">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th colspan="4">Detail Installation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                            <span style="float: left;">No. Induk</span>
                                            <span class="badge badge-info"
                                                style="float: right; width: 30%; padding: 5px; text-align: center;">
                                                {{ $installation->kode_instalasi }} {{ substr( $installation->package->kelas,0,1) }}
                                            </span>
                                        </td>
                                        <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                            <span style="float: left;">Abodemen</span>
                                            <span class="badge badge-info"
                                                style="float: right; width: 30%; padding: 5px; text-align: center;">
                                                {{ number_format($installation->abodemen, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                            <span style="float: left;">Tgl Order</span>
                                            <span class="badge badge-info"
                                                style="float: right; width: 30%; padding: 5px; text-align: center;">
                                                {{ $installation->order }}
                                            </span>
                                        </td>
                                        <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                            <span style="float: left;">Paket Instalasi</span>
                                            <span class="badge badge-info"
                                                style="float: right; width: 30%; padding: 5px; text-align: center;">
                                                {{ $installation->package->kelas }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                            <span style="float: left;">Tgl Pasang</span>
                                            <span class="badge badge-info"
                                                style="float: right; width: 30%; padding: 5px; text-align: center;">
                                                {{ $installation->pasang }}
                                            </span>
                                        </td>
                                        <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                            <span style="float: left;">Status Instalasi</span>
                                            @if ($installation->status == 'I')
                                                <span class="badge badge-info"
                                                    style="float: right; width: 30%; padding: 5px; text-align: center;">
                                                    PASANG
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

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="alert alert-light" role="alert">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="aktif">Tanggal Aktivasi</label>
                                        <input type="text" class="form-control date" name="aktif" id="aktif"
                                            value="{{ date('d/m/Y') }}">
                                        <small class="text-info" id="msg_aktif"></small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="kode_instalasi">Biaya Pemasangan baru</label>
                                        <input type="text" class="form-control date" name="kode_instalasi"
                                            id="kode_instalasi"
                                            value="{{ number_format($tampil_settings->pasang_baru, 2) }}" disabled>
                                        <small class="text-info" id="msg_kode_instalasi"></small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="biaya_instalasi">Status Pembayaran</label>
                                        @if (number_format($trx, 2) == number_format($installation->biaya_instalasi, 2))
                                            <input type="text" class="form-control" value="PAID" disabled>
                                            <small class="text-info" id="msg_biaya_instalasi"></small>
                                        @else
                                            <input type="text" class="form-control" value="UNPAID" disabled>
                                            <small class="text-info" id="msg_biaya_instalasi"></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" id="cetakBrcode" class="btn btn-danger btn-icon-split" target="_blank">
                                <span class="icon text-white-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-receipt" viewBox="0 0 16 16">
                                        <path
                                            d="M1.92.5a.5.5 0 0 0-.5.5v14a.5.5 0 0 0 .76.429L3 14.5l1.32.929a.5.5 0 0 0 .56 0L6.2 14.5l1.32.929a.5.5 0 0 0 .56 0L9.4 14.5l1.32.929a.5.5 0 0 0 .56 0L12.6 14.5l1.32.929a.5.5 0 0 0 .76-.429V1a.5.5 0 0 0-.5-.5H1.92z" />
                                        <path
                                            d="M2.5 3.5a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                                    </svg>
                                </span>
                                <span class="text">Cetak</span>
                            </button>
                            <tr>
                                <td>&nbsp;&nbsp;</td>
                            </tr>
                            <button id="kembali" class="btn btn-light btn-icon-split">
                                <span class="icon text-white-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-sign-turn-slight-left-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM6.864 8.368a.25.25 0 0 1-.451-.039l-1.06-2.882a.25.25 0 0 1 .192-.333l3.026-.523a.25.25 0 0 1 .26.371l-.667 1.154.621.373A2.5 2.5 0 0 1 10 8.632V11H9V8.632a1.5 1.5 0 0 0-.728-1.286l-.607-.364-.8 1.386Z" />
                                    </svg>
                                </span>
                                <span class="text">Kembali</span>
                            </button>
                            <button class="btn btn-secondary btn-icon-split" type="submit" id="Simpan_status_I"
                                style="float: right; margin-left: 10px;">
                                <span class="icon text-white-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                    </svg>
                                </span>
                                <span class="text" style="float: right;">Aktifkan Sekarang</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script>
        $(document).on('click', '#kembali', function(e) {
            e.preventDefault();
            window.location.href = '/installations?status=I';
        });

        $("#total").maskMoney({
            allowNegative: true
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

        $(document).on('click', '#Simpan_status_I', function(e) {
            e.preventDefault();
            $('small').html('');

            var form = $('#Form_status_I');
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            title: result.msg,
                            icon: "success",
                            draggable: true
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.href = '/installations/' + result.aktif.id;
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
