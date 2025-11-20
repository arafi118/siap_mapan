@php
    use App\Utils\Tanggal;
    $blok = json_decode($trx_settings->block, true);
    $jumlah_blok = count($blok);
    $harga = 0;
    $daftar_harga = json_decode($installations->package->harga, true);
@endphp

@if ($usages->isEmpty())
    <div class="card-body">
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading"><b>Pemberitahuan !</b></h4>
            <div class="alert alert-info d-flex justify-content-center align-items-center text-center" role="alert">
                <div>
                    <h4 class="alert-heading">
                        Customer an. <b>{{ $installations->customer->nama }}</b> - kode instalasi
                        <b>{{ $installations->kode_instalasi }}</b> <br> Tidak ada data <b>tagihan</b> untuk
                        ditampilkan.
                    </h4>
                </div>
            </div>
            <hr>
            <div class="col-12 d-flex justify-content-end">
                <a href="/usages" class="btn btn-danger">Cek Pemakaian</a>
            </div>
        </div>
    </div>
@else
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 mb-3 sidebar-pelanggan-wrapper">
                    <div class="card border-0 w-100 sidebar-pelanggan-sticky">

                        <div class="card-body pt-4">
                            <div class="d-flex justify-content-between align-items-start mb-0 pt-2">
                                <div>
                                    <h4 class="mb-1 font-weight-bold">
                                        {{ $installations->kode_instalasi ?? '-' }}-{{ $installations->package->inisial ?? '-' }}
                                    </h4>
                                    <span class="badge badge-success">Aktif</span>
                                </div>
                            </div>
                            <hr class="mb-0 p-0">
                            <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                                <div>
                                    <h6 class="mb-1 font-weight-bold">Informasi Pelanggan</h6>
                                    <p class="mb-0 text-muted small">aktif tanggal {{ $installations->aktif }}</p>
                                </div>
                                <div class="text-center">
                                    <div class="d-inline-block p-1 border rounded bg-light shadow-sm qr-wrapper">
                                        {!! $qr !!}
                                    </div>
                                </div>
                            </div>

                            <div id="accordionPelanggan" class="accordion">
                                <div class="card mb-1 border-0">
                                    <div class="card-header p-0 bg-secondary" id="headingUmum">
                                        <h5 class="mb-0">
                                            <button
                                                class="btn btn-link d-flex align-items-center justify-content-center w-100 text-center p-2"
                                                data-toggle="collapse" data-target="#collapseUmum" aria-expanded="true"
                                                aria-controls="collapseUmum"
                                                style="font-weight: 600; color: #0d47a1; text-decoration: none;">
                                                <span class="font-weight-bold text-white">Informasi Umum</span>
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseUmum" class="collapse show" aria-labelledby="headingUmum"
                                        data-parent="#accordionPelanggan">
                                        <div class="card-body py-2">
                                            <ul class="list-unstyled mb-0 small"
                                                style="font-family: 'Courier New', monospace;">
                                                <li class="mb-1 d-flex">
                                                    <span class="label flex-shrink-0"
                                                        style="min-width: 50px; font-weight: 600;">Nama</span>
                                                    <span class="mx-1">:</span>
                                                    <span
                                                        class="flex-grow-1">{{ $installations->customer->nama ?? '-' }}</span>
                                                </li>
                                                <li class="mb-1 d-flex">
                                                    <span class="label flex-shrink-0"
                                                        style="min-width: 50px; font-weight: 600;">Desa</span>
                                                    <span class="mx-1">:</span>
                                                    <span
                                                        class="flex-grow-1">{{ $installations->village->nama ?? '-' }}</span>
                                                </li>
                                                <li class="mb-1 d-flex">
                                                    <span class="label flex-shrink-0"
                                                        style="min-width: 50px; font-weight: 600;">Dusun</span>
                                                    <span class="mx-1">:</span>
                                                    <span
                                                        class="flex-grow-1">{{ $installations->village->dusun ?? '-' }}</span>
                                                </li>
                                                <li class="mb-1 d-flex">
                                                    <span class="label flex-shrink-0"
                                                        style="min-width: 50px; font-weight: 600;">RT</span>
                                                    <span class="mx-1">:</span>
                                                    <span class="flex-grow-1">{{ $installations->rt ?? '00' }}</span>
                                                </li>
                                                <li class="mb-1 d-flex">
                                                    <span class="label flex-shrink-0"
                                                        style="min-width: 50px; font-weight: 600;">Cater</span>
                                                    <span class="mx-1">:</span>
                                                    <span
                                                        class="flex-grow-1">{{ $installations->users->nama ?? '-' }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-1 border-0">
                                    <div class="card-header p-0 bg-secondary" id="headingPaket">
                                        <h5 class="mb-0">
                                            <button
                                                class="btn btn-link d-flex align-items-center justify-content-center w-100 text-center p-2 collapsed"
                                                data-toggle="collapse" data-target="#collapsePaket"
                                                aria-expanded="false" aria-controls="collapsePaket"
                                                style="font-weight: 600; color: #0d47a1; text-decoration: none;">
                                                <span class="font-weight-bold text-white">Harga Paket Perkubik</span>
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapsePaket" class="collapse" aria-labelledby="headingPaket"
                                        data-parent="#accordionPelanggan">
                                        <div class="card-body py-2">
                                            <ul class="list-unstyled mb-0 small"
                                                style="font-family: 'Courier New', monospace;">
                                                <li class="mb-1 d-flex">
                                                    <span class="label flex-shrink-0"
                                                        style="min-width: 50px; font-weight: 600;">Kelas</span>
                                                    <span class="mx-1">:</span>
                                                    <span
                                                        class="flex-grow-1">{{ $installations->package->kelas }}</span>
                                                </li>
                                                <li class="mb-1 d-flex">
                                                    <span class="label flex-shrink-0"
                                                        style="min-width: 50px; font-weight: 600;">Denda</span>
                                                    <span class="mx-1">:</span>
                                                    <span class="flex-grow-1">
                                                        Rp. {{ number_format($trx_settings->denda, 2) }}
                                                    </span>
                                                </li>
                                                <li class="mb-1">
                                                    <span class="d-block text-center"
                                                        style="font-weight: 600; font-size: 0.8rem;">
                                                        Harga
                                                    </span>
                                                </li>
                                                <li class="mb-1">
                                                    <ul class="pl-3 mb-0">
                                                        @for ($i = 0; $i < $jumlah_blok; $i++)
                                                            <li class="mb-1">
                                                                <div style="font-weight: 600;">
                                                                    {{ $blok[$i]['jarak'] }}
                                                                </div>
                                                                <div style="padding-left: 10px;">
                                                                    Rp.{{ number_format(isset($daftar_harga[$i]) ? $daftar_harga[$i] : 0, 2) }}
                                                                </div>
                                                            </li>
                                                        @endfor
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8" id="accordion">
                    @foreach ($usages as $index => $usage)
                        @php
                            $blok = json_decode($trx_settings->block, true);
                            $jumlah_blok = count($blok);
                            $harga = 0;
                            $daftar_harga = json_decode($installations->package->harga, true);
                            $dendaPemakaian = 0;
                            if (date('Y-m-d') >= $usage->tgl_akhir) {
                                $dendaPemakaian = $installations->package->denda;
                            }
                            $tgl_akhhir_lalu = date('Y-m', strtotime('-0 month', strtotime($usage->tgl_akhir)));
                            $isUnpaid = false;
                            if (isset($usages[$index - 1])) {
                                $isUnpaid = $usages[$index - 1]->status == 'UNPAID' ? true : false;
                            }
                            $dendaPemakaianLalu = 0;
                            foreach ($installations->transaction as $trx_denda) {
                                if (
                                    $trx_denda->tgl_transaksi < $usage->tgl_akhir &&
                                    date('Y-m', strtotime($trx_denda->tgl_transaksi)) == $tgl_akhhir_lalu
                                ) {
                                    $dendaPemakaianLalu = $trx_denda->total;
                                }
                            }
                        @endphp

                        <div class="card">
                            <div class="card-header" id="Judul-{{ $usage->id }}">
                                <h5 class="mb-0 alert alert-light bg-white" data-toggle="collapse"
                                    data-target="#Body-{{ $usage->id }}" aria-expanded="true"
                                    aria-controls="Body-{{ $usage->id }}">
                                    Tagihan Bulan
                                    {{ Tanggal::namaBulan($usage->tgl_akhir) }}
                                    {{ Tanggal::Tahun($usage->tgl_akhir) }}
                                </h5>
                            </div>
                            <div id="Body-{{ $usage->id }}" class="collapse"
                                aria-labelledby="Judul-{{ $usage->id }}" data-parent="#accordion">
                                <div class="card-body pt-0">
                                    <form action="/transactions" method="post"
                                        id="FormTagihan-{{ $usage->id }}">
                                        @csrf
                                        <input type="hidden" name="clay" id="clay" value="TagihanBulanan">
                                        <input type="hidden" name="id_instal" id="id_instal-{{ $usage->id }}"
                                            value="{{ $installations->id }}">
                                        <input type="hidden" name="id_usage" id="id_usage-{{ $usage->id }}"
                                            value="{{ $usage->id }}">
                                        <input type="hidden" name="tgl_akhir" id="tgl-akhir-{{ $usage->id }}"
                                            value="{{ $usage->tgl_akhir }}">
                                        <input type="hidden" name="denda" id="denda-{{ $usage->id }}"
                                            value="{{ $installations->package->denda }}">

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="alert alert-light" role="alert">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="position-relative mb-1">
                                                                <label for="tgl_transaksi-{{ $usage->id }}">Tanggal
                                                                    Transaksi</label>
                                                                <input type="text"
                                                                    class="form-control date tgl_transaksi"
                                                                    data-id="{{ $usage->id }}"
                                                                    name="tgl_transaksi" value="{{ date('d/m/Y') }}"
                                                                    id="tgl_transaksi-{{ $usage->id }}">
                                                                <small class="text-danger"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="position-relative mb-1">
                                                                <label for="kode_instalasi-{{ $usage->id }}">Kode
                                                                    Instalasi</label>
                                                                <input type="text" class="form-control"
                                                                    id="kode_instalasi-{{ $usage->id }}"
                                                                    value="{{ $installations->kode_instalasi }}"
                                                                    name="kode_instalasi" readonly>
                                                                <small class="text-danger"
                                                                    id="msg_kode_instalasi"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="position-relative mb-1">
                                                                <label for="awal">Meter Awal</label>
                                                                <input type="text" class="form-control awal"
                                                                    id="awal-{{ $usage->id }}"
                                                                    value="{{ $usage->awal }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="position-relative mb-1">
                                                                <label for="akhir">Meter Akhir</label>
                                                                <input type="text" class="form-control akhir"
                                                                    id="akhir-{{ $usage->id }}"
                                                                    value="{{ $usage->akhir }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="position-relative mb-1">
                                                                <label for="selisih">Pemakaian</label>
                                                                <input type="text" class="form-control selisih"
                                                                    id="selisih-{{ $usage->id }}"
                                                                    value="{{ $usage->jumlah }}" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="position-relative mb-1">
                                                            <label for="keterangan-{{ $usage->id }}">Keterangan</label>
                                                            <input type="text" class="form-control"
                                                                id="keterangan-{{ $usage->id }}"
                                                                value="Pembayaran Tagihan Bulanan Atas Nama {{ $installations->customer->nama }}"
                                                                name="keterangan">
                                                            <small class="text-danger" id="msg_keterangan"></small>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="position-relative mb-1">
                                                                <label
                                                                    for="tagihan-{{ $usage->id }}">Tagihan</label>
                                                                <input type="text"
                                                                    class="form-control tagihan mt-1" name="tagihan"
                                                                    id="tagihan"
                                                                    value="{{ number_format($usage->nominal, 2) }}"
                                                                    readonly>
                                                                <small class="text-danger"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="position-relative mb-1">
                                                                <label
                                                                    for="abodemen-bulanan-{{ $usage->id }}">Abodemen</label>
                                                                <input type="text" class="form-control abodemen"
                                                                    name="abodemen"
                                                                    id="abodemen-bulanan-{{ $usage->id }}" readonly
                                                                    placeholder="0.00"
                                                                    value="{{ number_format($trx_settings->abodemen, 2) }}">
                                                                <small class="text-danger"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="position-relative mb-1">
                                                                <label
                                                                    for="denda-bulanan-{{ $usage->id }}">Denda</label>
                                                                <input type="text" class="form-control denda"
                                                                    name="denda"
                                                                    id="denda-bulanan-{{ $usage->id }}" readonly
                                                                    placeholder="0.00"
                                                                    value="{{ number_format($dendaPemakaianLalu, 2) }}">
                                                                <small class="text-danger"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="position-relative mb-1">
                                                                <label
                                                                    for="pembayaran-{{ $usage->id }}">Pembayaran</label>
                                                                <input type="text"
                                                                    class="form-control total perhitungan"
                                                                    name="pembayaran"
                                                                    id="pembayaran-{{ $usage->id }}"
                                                                    data-id="{{ $usage->id }}"
                                                                    value="{{ number_format($usage->nominal + $trx_settings->abodemen + $dendaPemakaianLalu, 2) }}"
                                                                    {!! $trx_settings->swit_tombol_trx == '1' ? 'readonly' : '' !!}>
                                                                <small class="text-danger"
                                                                    id="msg_pembayaran"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 d-none">
                                                            <div class="position-relative mb-1">
                                                                <label for="total-{{ $usage->id }}">Total</label>
                                                                <input type="text" class="form-control total"
                                                                    name="total" id="total-{{ $usage->id }}"
                                                                    readonly placeholder="0.00">
                                                                <small class="text-danger"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-lg-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="position-relative mb-3">
                                                                <label for="awal">Meter Awal</label>
                                                                <input type="text" class="form-control awal"
                                                                    id="awal-{{ $usage->id }}"
                                                                    value="{{ $usage->awal }}" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="position-relative mb-3">
                                                                <label for="akhir">Meter Akhir</label>
                                                                <input type="text" class="form-control akhir"
                                                                    id="akhir-{{ $usage->id }}"
                                                                    value="{{ $usage->akhir }}" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="position-relative mb-3">
                                                                <label for="selisih">Pemakaian</label>
                                                                <input type="text" class="form-control selisih"
                                                                    id="selisih-{{ $usage->id }}"
                                                                    value="{{ $usage->jumlah }}" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                            <div class="col-12 d-flex justify-content-end mt-1">
                                                <button class="btn btn-sm btn-secondary btn-icon-split SimpanTagihan"
                                                    type="submit" data-form="#FormTagihan-{{ $usage->id }}">
                                                    <span class="icon text-white-50">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                                            <path
                                                                d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                                        </svg>
                                                    </span>
                                                    <span class="text" style="float: right;">Simpan
                                                        Pembayaran</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <br>
@endif

<script>
    $(".tagihan").maskMoney({
        allowNegative: true
    });

    $(".total").maskMoney({
        allowNegative: true
    });
    $(".denda").maskMoney({
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
