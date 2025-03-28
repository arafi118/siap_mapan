@php
    use App\Utils\Tanggal;
@endphp
<style>
    * {
        font-family: 'Arial', sans-serif;
    }
</style>
<title>{{ $title }}</title>
@extends('pelaporan.layouts.base')

@section('content')
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
        <tr>
            <th colspan="3" align="center">
                <div style="font-size: 18px; font-weight: bold;">Tagihan Pelanggan</div>
                <div style="font-size: 16px; font-weight: bold;">{{ strtoupper($sub_judul) }}</div>
            </th>
        </tr>
        <tr>
            <th colspan="3" height="10"></th>
        </tr>
    </table>

    <table border="0" width="100%" cellspacing="0" cellpadding="0"
        style="font-size: 11px; border-collapse: collapse; table-layout: fixed;">
        <tr style="background-color: rgb(230, 230, 230); font-weight: bold;">
            <th style="border: 1px solid black; padding: 5px;" width="3%" rowspan="3">No</th>
            <th style="border: 1px solid black; padding: 5px;" width="10%" rowspan="3">Nama</th>
            <th style="border: 1px solid black; padding: 5px;" width="6%" rowspan="3">No. Induk</th>
            <th style="border: 1px solid black; padding: 5px;" width="8%" colspan="{{ count($bulan_tampil) }}">Tunggakan
            </th>
            <th style="border: 1px solid black; padding: 5px;" width="5%" rowspan="3">Dibayar</th>
            <th style="border: 1px solid black; padding: 5px;" width="6%" rowspan="3">mrnunggak2</th>
        </tr>
        <tr style="background: rgb(230, 230, 230); font-weight: bold;">
            <th class="t l b" width="6%">s/d 3 Bulan Lalu</th>
            <th class="t l b" width="6%">Bulan Lalu</th>
            <th class="t l b" width="6%"style="border: 1px solid black; padding: 5px;">Bulan Ini</th>
        </tr>
        <tr style="background: rgb(230, 230, 230); font-weight: bold;">
            @foreach ($bulan_tampil as $bt)
                <th class="t l b" width="6%">
                    {{ Tanggal::namaBulan($bt . '-01') }}
                </th>
            @endforeach
        </tr>
        @php
            use Carbon\Carbon;
            $no = 1;
            $totalTagihan = 0;
            $totalTerbayar = 0;
            $totalMenunggak = 0;
            $totalDenda = 0;
            $data_desa = [];
            $totalMenunggakPerBulan = [];
            $totalDibayarKeseluruhan = 0; // Tambahkan variabel untuk total dibayar
            $cek_bulan = [];
        @endphp

        @foreach ($installations as $installation)
            @if (!in_array($installation->village, $data_desa))
                <tr>
                    <th colspan="8" style="border: 1px solid black; padding: 5px; font-weight: normal;" align="left">
                        Dusun {{ $installation->village->dusun }} Kalurahan {{ $installation->village->nama }}
                    </th>
                </tr>

                @php
                    $data_desa[] = $installation->village;
                @endphp
            @endif

            <tr>
                <th style="border: 1px solid black; padding: 5px;font-weight: normal;" align="center">{{ $no++ }}
                </th>
                <th style="border: 1px solid black; padding: 5px;font-weight: normal;" align="left">
                    {{ $installation->customer->nama }}
                </th>
                <th style="border: 1px solid black; padding: 5px;font-weight: normal;" align="center">
                    {{ $installation->kode_instalasi }}
                </th>

                @php
                    $nomor = 1;
                    $data_menunggak = [];
                    $tunggakan_tampil = [];
                    foreach ($installation->usage as $usage) {
                        $beban = $installation->abodemen;
                        $denda = intval($installation->package->denda);
                        $dibayar = $usage->transaction->sum('total');
                        $tagihan = $usage->nominal;
                        $menunggak = $beban + $denda + $tagihan;
                        if (date('m', strtotime($usage->tgl_akhir)) < date('m', strtotime($tgl_kondisi))) {
                            $menunggak = 0;
                        }

                        $toleransi = $usage->tgl_akhir;
                        if ($toleransi >= $tgl_kondisi) {
                            $menunggak = 0;
                        }

                        if ($nomor > 1) {
                            $data_menunggak[$nomor] = $menunggak + $data_menunggak[$nomor - 1];
                        } else {
                            $data_menunggak[$nomor] = $menunggak;
                        }

                        $bulan = Carbon::parse($usage->tgl_akhir)->format('Y-m');
                        if (in_array($bulan, $bulan_tampil)) {
                            $tunggakan_tampil[$bulan] = $data_menunggak[$nomor];
                        }

                        $nomor++;
                    }
                @endphp
                @foreach ($bulan_tampil as $bt)
                    @php
                        $tunggakan = 0;
                        $dibayarPerBulan = 0;
                        $bulan = Carbon::parse($bt)->format('Y-m');
                        $tunggakan = isset($tunggakan_tampil[$bt]) ? $tunggakan_tampil[$bt] : 0;
                        $dibayarPerBulan = isset($dibayar_tampil[$bt]) ? $dibayar_tampil[$bt] : 0; // Ambil data dibayar

                        if (in_array($bt, $cek_bulan)) {
                            $totalMenunggakPerBulan[$bt] += $tunggakan;
                            $totalDibayarPerBulan[$bt] += $dibayarPerBulan;
                        } else {
                            $totalMenunggakPerBulan[$bt] = $tunggakan;
                            $totalDibayarPerBulan[$bt] = $dibayarPerBulan;
                            $cek_bulan[$bt] = $bt;
                        }
                    @endphp
                    <th style="border: 1px solid black; padding: 5px; font-weight: normal" align="right">
                        {{ number_format($tunggakan, 0, ',', '.') . ',-' }}
                    </th>
                @endforeach

                <th style="border: 1px solid black; padding: 5px; font-weight: normal;" align="right">
                    {{ number_format($dibayar, 0, ',', '.') . ',-' }}
                </th>
                <th style="border: 1px solid black; padding: 5px; font-weight: normal;" align="center">
                    {{ $installation->status_tunggakan }}
                </th>
            </tr>
        @endforeach

        <tr style="font-weight: bold;">
            <th style="border: 1px solid black; padding: 5px;" colspan="3" align="left">Jumlah</th>
            @foreach ($bulan_tampil as $bt)
                @php
                    $bulan = Carbon::parse($bt)->format('Y-m');
                @endphp
                <th style="border: 1px solid black; padding: 5px;" align="right">
                    {{ isset($totalMenunggakPerBulan[$bulan]) ? number_format($totalMenunggakPerBulan[$bulan], 0, ',', '.') . ',-' : '0,-' }}
                </th>
            @endforeach

            <th style="border: 1px solid black; padding: 5px;" align="right">
            </th>
            <th style="border: 1px solid black; padding: 5px;" align="right"></th>
        </tr>

    </table>
@endsection
