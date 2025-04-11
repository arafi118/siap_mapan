@php
    use App\Utils\Tanggal;
@endphp

@include('pelaporan.layouts.style')
<title>{{ $title }}</title>

<table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
    <tr>
        <td colspan="3" align="center">
            <div style="font-size: 18px; font-weight: bold;">Tagihan Pelanggan
                {{ $cater->nama }}
            </div>
            <div style="font-size: 16px; font-weight: bold;">{{ strtoupper($sub_judul) }}</div>
        </td>
    </tr>

    <tr>
        <td colspan="3" height="10"></td>
    </tr>
</table>

<table border="0" width="100%">
    <thead>
        <tr style="background-color: rgb(230, 230, 230); font-weight: bold;">
            <th width="3%" class="t l b" rowspan="3">No</th>
            <th width="10%" class="t l b" rowspan="3">Nama</th>
            <th width="6%" class="t l b" rowspan="3">No. Induk</th>
            <th width="8%" class="t l b" colspan="{{ count($bulan_tampil) }}">Tunggakan</th>
            <th width="5%" class="t l b" rowspan="3">Dibayar</th>
            <th width="6%" class="t l b r" rowspan="3">Keterangan</th>
        </tr>
        <tr style="background: rgb(230, 230, 230); font-weight: bold;">
            <th class="t l b" width="6%">s/d 3 Bulan Lalu</th>
            <th class="t l b" width="6%">Bulan Lalu</th>
            <th class="t l b" width="6%">Bulan Ini</th>
        </tr>
        <tr style="background: rgb(230, 230, 230); font-weight: bold;">
            @foreach ($bulan_tampil as $bt)
                <th class="t l b" width="6%">
                    {{ Tanggal::namaBulan($bt . '-01') }}
                </th>
            @endforeach
        </tr>
    </thead>

    <tbody>
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
                    <td class="t l b r" colspan="8" align="left">
                        Dusun {{ $installation->village->dusun }} Kalurahan {{ $installation->village->nama }}
                    </td>
                </tr>

                @php
                    $data_desa[] = $installation->village;
                @endphp
            @endif

            <tr>
                <td class="t l b" align="center">
                    {{ $no++ }}
                </td>
                <td class="t l b" align="left">
                    {{ $installation->customer->nama }}
                </td>
                <td class="t l b" align="center">
                    {{ $installation->kode_instalasi }}
                </td>

                @php
                    $nomor = 1;
                    $data_menunggak = [];
                    $tunggakan_tampil = [];
                    foreach ($installation->usage as $usage) {
                        $beban = $installation->abodemen;
                        $denda =
                            $installation->status_tunggakan !== 'lancar' ? intval($installation->package->denda) : 0;
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
                    <td class="t l b" align="right">
                        {{ number_format($tunggakan, 0, ',', '.') . ',-' }}
                    </td>
                @endforeach

                <td class="t l b" align="right">
                    {{ number_format($dibayar, 0, ',', '.') . ',-' }}
                </td>
                <td class="t l b r" align="center">
                    {{ $installation->status_tunggakan }}
                </td>
            </tr>
        @endforeach

        <tr style="font-weight: bold;">
            <td class="t l b" colspan="3" align="left">Jumlah</td>
            @foreach ($bulan_tampil as $bt)
                @php
                    $bulan = Carbon::parse($bt)->format('Y-m');
                @endphp
                <td class="t l b" align="right">
                    {{ isset($totalMenunggakPerBulan[$bulan]) ? number_format($totalMenunggakPerBulan[$bulan], 0, ',', '.') . ',-' : '0,-' }}
                </td>
            @endforeach

            <td class="t l b" align="right"></td>
            <td class="t l b r" align="right"></td>
        </tr>
    </tbody>
</table>
