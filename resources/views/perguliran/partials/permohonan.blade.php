@extends('layouts.base')

@section('content')
<!-- Form -->
<form action="/installations/{{ $installation->id }}" method="post" id="status_P">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Bagian Informasi Customer -->
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <!-- Gambar -->
                        <img src="../../assets/img/user.png" style="max-height: 150px; margin-right: 20px;"
                            class="img-fluid">

                        <!-- Konten Teks -->
                        <div>
                            <h4 class="alert-heading"><b>Customer an. {{ $installation->customer->nama }}</b></h4>
                            <hr>
                            <p class="mb-0">
                                {{ $installation->village->nama }},
                                {{ $installation->alamat }}, [
                                {{ $installation->koordinate }}
                                ].
                            </p>
                        </div>
                    </div>

                    <!-- Tabel di Bawah Customer -->
                    <div class="mt-4">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th colspan="4">Permohonan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width: 50%; font-size: 14px; padding: 8px;">
                                        Tgl Order
                                        <span class="badge badge-success"
                                            style="width: 20%; padding: 5px;">{{ $installation->order }}</span>
                                    </td>
                                    <td style="width: 50%; font-size: 14px; padding: 8px;">
                                        Biaya istalasi
                                        <span class="badge badge-success"
                                            style="width: 20%; padding: 5px;">{{ number_format($installation->package->abodemen, 2) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; font-size: 14px; padding: 8px;">
                                        paket
                                        <span class="badge badge-success" style="width: 20%; padding: 5px;">{{($installation->package) ?
                                            $installation->package->kelas:'' }}</span>
                                    </td>
                                    <td style="width: 50%; font-size: 14px; padding: 8px;">
                                        Tarif meteran
                                        <span class="badge badge-success" style="width: 20%; padding:
                                            5px;">{{ number_format($installation->usage->jumlah, 2) }}</span>
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
        <div class="card-body">
            <div class="alert alert-light" role="alert">
                <div class="row">
                    <div class="col-md-4">
                        <div class="position-relative mb-3">
                            <label for="kode_instalasi">Kode Instalasi</label>
                            <input type="text" class="form-control date" name="kode_instalasi" id="kode_instalasi"
                                value="{{ $installation->kode_instalasi }}" disabled>
                            <small class="text-danger" id="msg_kode_instalasi"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="position-relative mb-3">
                            <label for="order">Tanggal Pasang</label>
                            <input type="text" class="form-control date" name="order" id="order"
                                value="{{ date('d/m/Y') }}">
                            <small class="text-danger" id="msg_order"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="position-relative mb-3">
                            <label for="order">Biaya Istalasi</label>
                            <input type="text" class="form-control" name="order" id="order"
                                value="{{ number_format($installation->package->abodemen - $trx, 2) }}" disabled>
                            <small class="text-danger" id="msg_order"></small>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-secondary btn-icon-split" type="submit" id="SimpanPermohonan" class="btn btn-dark"
                style="float: right;">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-right"></i>
                </span><span class="text" style="float: right;">Simpan & Pasang</span>
            </button>
            <a href="" class="btn btn-primary" style="float: right;"> Kembali</a>
            <br>
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
