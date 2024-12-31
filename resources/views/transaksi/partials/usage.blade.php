@php
    use App\Utils\Tanggal;
@endphp

@foreach ($usages as $usage)
    @php
        $nomor = $loop->iteration;

        $blok = json_decode($trx_settings->block, true);
        $jumlah_blok = count($blok);

        /**
         * [
         *      0 => [
         *         "nama":"block 1",
         *         "jarak":"0-10"
         *      ]
         * ]
         */

        $harga = 0;
        $daftar_harga = json_decode($installations->package->harga, true);
        // dd($blok, $daftar_harga);

        foreach ($blok as $b => $val) {
            $meter = str_replace(' ', '', $val['jarak']);
            $meter = str_replace('M3', '', $meter);
            $meter = explode('-', $meter); //[0, 10]

            if ($meter[0] <= $usage->jumlah && $meter[1] <= $usage->jumlah) {
                $harga = $daftar_harga[$b];
                break;
            }
        }
    @endphp
    <div class="card">
        <div class="card-header" id="Judul-{{ $nomor }}">
            <h5 class="mb-0 alert alert-light bg-white" data-toggle="collapse" data-target="#Body-{{ $nomor }}"
                aria-expanded="true" aria-controls="Body-{{ $nomor }}">
                Tagihan Bulan {{ Tanggal::namaBulan($usage->tgl_akhir) }}
            </h5>
        </div>

        <div id="Body-{{ $nomor }}" class="collapse" aria-labelledby="Judul-{{ $nomor }}"
            data-parent="#accordion">
            <div class="card-body">
                <form action="/transactions" method="post" id="FormTagihan-{{ $nomor }}">
                    @csrf
                    <input type="hidden" name="clay" id="clay" value="TagihanBulanan">
                    <input type="hidden" name="id_trx" id="id_trx" value="{{ $installations->id }}">
                    <input type="hidden" name="id_usage" id="id_usage" value="{{ $usage->id }}">

                    <div class="row">
                        <div class="col-lg-9">
                            <div class="alert alert-light" role="alert">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="tgl_transaksi">Tanggal Transaksi</label>
                                            <input type="text" class="form-control date" name="tgl_transaksi"
                                                value=" {{ date('d/m/Y') }}" id="tgl_transaksi">
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="kode_instalasi">Kode Instalasi</label>
                                            <input type="text" class="form-control" id="kode_instalasi"
                                                value="{{ $usage->kode_instalasi }}" name="kode_instalasi" readonly>
                                            <small class="text-danger" id="msg_kode_instalasi"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label for="keterangan">Keterangan</label>
                                            <input type="text" class="form-control" id="keterangan"
                                                value="Pembayaran Tagihan Bulanan {{ Tanggal::tglLatin($usage->tgl_akhir) }}"
                                                name="keterangan">
                                            <small class="text-danger" id="msg_keterangan"></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="tagihan">Tagihan</label>
                                            <input type="text" class="form-control" name="tagihan" id="tagihan"
                                                value="{{ number_format($harga, 2) }}"readonly>
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="pembayaran">Pembayaran</label>
                                            <input type="text" class="form-control total" name="pembayaran"
                                                id="pembayaran">
                                            <small class="text-danger" id="msg_pembayaran"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="total">Total</label>
                                            <input type="text" class="form-control total" name="total"
                                                id="total" readonly>
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-warning btn-icon-split" type="button"
                                    data-bs-target="#DetailTRX" data-bs-toggle="modal">
                                    <span class="icon text-white-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-sign-intersection-fill"
                                            viewBox="0 0 576 512">
                                            <path
                                                d="M112 48a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm40 304l0 128c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-223.1L59.4 304.5c-9.1 15.1-28.8 20-43.9 10.9s-20-28.8-10.9-43.9l58.3-97c17.4-28.9 48.6-46.6 82.3-46.6l29.7 0c33.7 0 64.9 17.7 82.3 46.6l44.9 74.7c-16.1 17.6-28.6 38.5-36.6 61.5c-1.9-1.8-3.5-3.9-4.9-6.3L232 256.9 232 480c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-128-16 0zM432 224a144 144 0 1 1 0 288 144 144 0 1 1 0-288zm0 240a24 24 0 1 0 0-48 24 24 0 1 0 0 48zm0-192c-8.8 0-16 7.2-16 16l0 80c0 8.8 7.2 16 16 16s16-7.2 16-16l0-80c0-8.8-7.2-16-16-16z" />
                                        </svg>
                                    </span>
                                    <span class="text" style="float: right;">Detail Tagihan</span>
                                </button>

                                <button class="btn btn-secondary btn-icon-split SimpanTagihan" type="submit"
                                    data-form="#FormTagihan-{{ $nomor }}"
                                    style="float: right; margin-left: 10px;">
                                    <span class="icon text-white-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-sign-intersection-fill"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                        </svg>
                                    </span>
                                    <span class="text" style="float: right;">Simpan Pembayaran</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card">
                                <div
                                    class="card-header py-4 bg-primary d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-light">Pemakaian Air</h6>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info" role="alert">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="position-relative mb-3">
                                                    <label for="awal">Awal</label>
                                                    <input type="text" class="form-control awal" id="awal"
                                                        value="{{ $usage->awal }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="position-relative mb-3">
                                                    <label for="akhir">Akhir</label>
                                                    <input type="text" class="form-control akhir" id="akhir"
                                                        value="{{ $usage->akhir }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="position-relative mb-3">
                                                    <label for="selisih">Pemakaian Periode ini</label>
                                                    <input type="text" class="form-control selisih" id="selisih"
                                                        value="{{ $usage->jumlah }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><br>

    <!-- Modal -->
    <div class="modal fade" id="DetailTRX" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <!-- Detail Tagihan  -->
                                <div class="alert alert-success d-flex align-items-center" role="alert">
                                    <!-- Gambar -->
                                    <img src="../../assets/img/user.png"
                                        style="max-height: 150px; margin-right: 20px;" class="img-fluid">
                                    <div>
                                        <h4 class="alert-heading"><b>Customer an.
                                                {{ $installations->customer->nama }}</b></h4>
                                        <hr>
                                        <p class="mb-0">
                                            Pembayaran Tagihan Bulanan {{ Tanggal::tglLatin($usage->tgl_akhir) }}
                                        </p>
                                    </div>
                                </div>
                                <!-- Form Detail Tagihan  -->
                                <div class="mt-4">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-light">
                                            <tr>
                                                <th colspan="4">Detail Tagihan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                                    <span style="float: left;">Tgl Aktif</span>
                                                    <span class="badge badge-success"
                                                        style="float: right; width: 40%; padding: 5px; text-align: center;">
                                                        {{ $installations->aktif }}
                                                    </span>
                                                </td>
                                                <td
                                                    style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                                    <span style="float: left;">Status</span>
                                                    @if ($installations->status)
                                                        <span class="badge badge-success"
                                                            style="float: right; width: 40%; padding: 5px; text-align: center;">
                                                            Aktif
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                                    <span style="float: left;">Paket</span>
                                                    <span class="badge badge-success"
                                                        style="float: right; width: 40%; padding: 5px; text-align: center;">
                                                        {{ $installations->package->kelas }}
                                                    </span>
                                                </td>
                                                <td
                                                    style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                                    <span style="float: left;">Denda</span>
                                                    <span class="badge badge-success"
                                                        style="float: right; width: 40%; padding: 5px; text-align: center;">
                                                        {{ number_format($installations->package->denda, 2) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @for ($i = 0; $i < $jumlah_blok; $i++)
                                                <tr {{ 12 / $jumlah_blok }}>
                                                    <td
                                                        style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                                        <span style="float: left;">Jarak</span>
                                                        <span class="badge badge-success"
                                                            style="float: right; width: 40%; padding: 5px; text-align: center;">
                                                            {{ $blok[$i]['jarak'] }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                                        <span style="float: left;">Harga</span>
                                                        <span class="badge badge-success"
                                                            style="float: right; width: 40%; padding: 5px; text-align: center;">
                                                            Rp.
                                                            {{ number_format(isset($daftar_harga[$i]) ? $daftar_harga[$i] : '0', 2) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close Detail</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    //angka 00,000,00
    $("#tagihan").maskMoney({
        allowNegative: true
    });

    $(".total").maskMoney({
        allowNegative: true
    });

    $(".awal").maskMoney({
        allowNegative: true
    });

    $(".akhir").maskMoney({
        allowNegative: true
    });

    $(".selisih").maskMoney({
        allowNegative: true
    });

    //tanggal
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
