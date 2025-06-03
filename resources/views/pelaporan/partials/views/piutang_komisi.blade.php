@php
    use App\Utils\Tanggal;
@endphp

@include('pelaporan.layouts.style')
<title>{{ $title }} {{ $sub_judul }}</title>

<table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
    <tr>
        <td colspan="3" align="center">
            <div style="font-size: 18px; font-weight: bold;">
                DAFTAR PIUTANG KOMISI SPS
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
            <th width="4%" height="32" class="t l b">No</th>
            <th width="25%" class="t l b">Nama Pelanggan</th>
            <th width="11%" class="t l b">No. Induk</th>
            <th width="12%" class="t l b">Bulan Tagihan</th>
            <th width="11%" class="t l b">Jumlah</th>
            <th width="15%" class="t l b">Kolektor</th>
            <th width="11%" class="t l b">Komisi</th>
            <th width="11%" class="t l b r">Dibayar</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalTagihan = 0;
            $totalKomisi = 0;
            $totalDibayar = 0;
        @endphp
        @foreach ($commissionTransactions as $com)
            @php
                $installation = $com->Installations;
                $kolektor = $installation->village->kolektor;
                $customer = $installation->customer;
                $usage = $com->Usages;
                $abodemen = $pengaturan->abodemen;

                $dendaPemakaianLalu = 0;
                foreach ($installation->transaction as $trx_denda) {
                    if ($trx_denda->tgl_transaksi < $usage->tgl_akhir) {
                        $dendaPemakaianLalu = $trx_denda->total;
                    }
                }

                $komisiTerbayar = 0;
                foreach ($com->transaction as $trx) {
                    if ($trx->tgl_transaksi <= $tgl_kondisi) {
                        $komisiTerbayar += $trx->total;
                    }
                }

                $totalTagihan += $usage->nominal + $dendaPemakaianLalu + $abodemen;
                $totalKomisi += $com->total;
                $totalDibayar += $komisiTerbayar;
            @endphp

            <tr>
                <td class="t l b" align="center">{{ $loop->iteration }}</td>
                <td class="t l b">{{ $customer->nama }}</td>
                <td class="t l b">{{ $installation->kode_instalasi }}</td>
                <td class="t l b">{{ Tanggal::namaBulan($usage->tgl_akhir) }} {{ Tanggal::tahun($usage->tgl_akhir) }}
                </td>
                <td class="t l b" align="right">
                    {{ number_format($usage->nominal + $dendaPemakaianLalu + $abodemen, 2) }}
                </td>
                <td class="t l b">{{ $kolektor }}</td>
                <td class="t l b" align="right">{{ number_format($com->total, 2) }}</td>
                <td class="t l b r" align="right">{{ number_format($komisiTerbayar, 2) }}</td>
            </tr>
        @endforeach

        <tr>
            <td class="t l b" colspan="4" height="25">Jumlah</td>
            <td class="t l b" align="right">
                {{ number_format($totalTagihan, 2) }}
            </td>
            <td class="t l b">&nbsp;</td>
            <td class="t l b" align="right">
                {{ number_format($totalKomisi, 2) }}
            </td>
            <td class="t l b r" align="right">
                {{ number_format($totalDibayar, 2) }}
            </td>
        </tr>
    </tbody>
</table>
