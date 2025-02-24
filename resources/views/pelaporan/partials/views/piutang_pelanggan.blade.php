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
            <td colspan="3" align="center">
                <div style="font-size: 18px; font-weight: bold;">Piutang Pelanggan</div>
                <div style="font-size: 16px; font-weight: bold;">{{ strtoupper($sub_judul) }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="10"></td>
        </tr>
    </table>

    <table border="0" width="100%" cellspacing="0" cellpadding="0"
        style="font-size: 11px; border-collapse: collapse; table-layout: fixed;">
        <tr style="background-color: rgb(230, 230, 230); font-weight: bold;">
            <th style="border: 1px solid black; padding: 5px;" width="3%">No</th>
            <th style="border: 1px solid black; padding: 5px;" width="10%">Nama</th>
            <th style="border: 1px solid black; padding: 5px;" width="10%">Kode Instalasi</th>
            <th style="border: 1px solid black; padding: 5px;" width="8%">Periode</th>
            <th style="border: 1px solid black; padding: 5px;" width="8%">Tagihan</th>
            <th style="border: 1px solid black; padding: 5px;" width="9%">Terbayar</th>
            <th style="border: 1px solid black; padding: 5px;" width="9%">Menunggak</th>
        </tr>

        @php
            use Carbon\Carbon;
            $no = 1;
            $totalTagihan = 0;
            $totalTerbayar = 0;
            $totalMenunggak = 0;
        @endphp

        @foreach ($installations as $installation)
            @foreach ($installation->usage as $usage)
                @php
                    $terbayar = $usage->transaction->sum('total');
                    $menunggak = $usage->nominal - $terbayar;

                    $totalTagihan += $usage->nominal;
                    $totalTerbayar += $terbayar;
                    $totalMenunggak += $menunggak;
                @endphp
                <tr>
                    <td style="border: 1px solid black; padding: 5px;" align="center">{{ $no++ }}</td>
                    <td style="border: 1px solid black; padding: 5px;" align="left">{{ $installation->customer->nama }}
                    </td>
                    <td style="border: 1px solid black; padding: 5px;" align="center">{{ $installation->kode_instalasi }}
                    </td>
                    <td style="border: 1px solid black; padding: 5px;" align="center">
                        {{ Carbon::parse($usage->tgl_akhir)->translatedFormat('F Y') }}
                    </td>
                    <td style="border: 1px solid black; padding: 5px;" align="right">
                        {{ number_format($usage->nominal, 2) }}
                    </td>
                    <td style="border: 1px solid black; padding: 5px;" align="right">
                        {{ number_format($terbayar, 2) }}
                    </td>
                    <td style="border: 1px solid black; padding: 5px;" align="right">
                        {{ number_format($menunggak, 2) }}
                    </td>
                </tr>
            @endforeach
        @endforeach

        <tr style="font-weight: bold;">
            <td style="border: 1px solid black; padding: 5px;" colspan="4" align="left">Jumlah</td>
            <td style="border: 1px solid black; padding: 5px;" align="right">{{ number_format($totalTagihan, 2) }}</td>
            <td style="border: 1px solid black; padding: 5px;" align="right">{{ number_format($totalTerbayar, 2) }}</td>
            <td style="border: 1px solid black; padding: 5px;" align="right">{{ number_format($totalMenunggak, 2) }}</td>
        </tr>
    </table>
@endsection
