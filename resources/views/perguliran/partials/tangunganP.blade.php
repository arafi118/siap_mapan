@extends('layouts.base')

@section('content')
    <!-- Form -->
    <form action="/installations/{{ $installation->id }}" method="post" id="Form_status_P">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Bagian Informasi Customer -->
                        <div class="alert alert-warning d-flex align-items-center" role="alert">
                            <!-- Gambar -->
                            <img src="../../assets/img/user.png" style="max-height: 150px; margin-right: 20px;"
                                class="img-fluid">

                            <!-- Konten Teks -->
                            <div>
                                <div>
                                    <h4 class="alert-heading">Customer an. <b>{{ $installation->customer->nama }}</b> masih
                                        memiliki pinjaman dengan status
                                        <b>
                                            @if ($installation->status === '0')
                                                Permohonan ( P )
                                            @endif
                                        </b>
                                    </h4>
                                    <hr>
                                    <p class="mb-0">
                                        desa.{{ $installation->village->nama }},
                                        {{ $installation->alamat }},
                                        koordinate [ {{ $installation->koordinate }}
                                        ].
                                    </p>
                                </div>
                            </div>

                        </div>
                        <!-- Tabel di Bawah Customer -->
                        <div class="mt-4">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th colspan="2">Deatil Pemberitahuan Permohonan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                            <span style="float: left;">Tgl Order</span>
                                            <span class="badge badge-warning"
                                                style="float: right; width: 20%; padding: 5px; text-align: center;">
                                                {{ $installation->order }}
                                            </span>
                                        </td>
                                        <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                            <span style="float: left;">Abodemen</span>
                                            <span class="badge badge-warning"
                                                style="float: right; width: 20%; padding: 5px; text-align: center;">
                                                {{ number_format($installation->abodemen, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                            <span style="float: left;">Paket Instalasi</span>
                                            <span class="badge badge-warning"
                                                style="float: right; width: 20%; padding: 5px; text-align: center;">
                                                {{ $installation->package->kelas }}
                                            </span>
                                        </td>
                                        <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                            <span style="float: left;">Status Instalasi</span>
                                            @if ($installation->status === '0')
                                                <span class="badge badge-warning"
                                                    style="float: right; width: 20%; padding: 5px; text-align: center;">
                                                    UNPAID
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-secondary btn-icon-split" type="submit" id="Simpan_status_P"
                                style="float: right; margin-left: 10px;">
                                <span class="icon text-white-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                    </svg>
                                </span>
                                <span class="text" style="float: right;">Cek Detail</span>
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
    </script>
@endsection
