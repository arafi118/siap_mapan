<style>
    * {
        font-family: 'Arial', sans-serif;
    }
</style>
<title>{{ $title }}</title>
@extends('pelaporan.layouts.base')

@section('content')
    <table class="header-table" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
        <tr>
            <td colspan="3" align="center">
                <div style="font-size: 18px; font-weight: bold;">Tagihan Pelanggan</div>
                <div style="font-size: 16px; font-weight: bold;">{{ strtoupper($sub_judul) }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="10"></td>
        </tr>
    </table>

    <table border="0" width="100%" cellspacing="0" cellpadding="0"
        style="font-size: 11px; border-collapse: collapse;">
        <tr style="background: rgb(230, 230, 230); font-weight: bold;">
            <th style="border: 1px solid black; padding: 5px;" height="20" width="3%">No</th>
            <th style="border: 1px solid black; padding: 5px;" height="20" width="10%">Nama</th>
            <th style="border: 1px solid black; padding: 5px;" width="8%">Desa</th>
            <th style="border: 1px solid black; padding: 5px;" width="10%">Kode Instalasi</th>
            <th style="border: 1px solid black; padding: 5px;" width="8%">Pemakaian</th>
            <th style="border: 1px solid black; padding: 5px;" width="8%">Tagihan</th>
            <th style="border: 1px solid black; padding: 5px;" width="9%">Status</th>
            <th style="border: 1px solid black; padding: 5px;" width="9%">Pembayaran</th>
        </tr>
        @php
            $totalPemakaian = 0;
            $totalTagih = 0;
            $totalPembayaran = 0;
            $no = 1;
        @endphp
        @foreach ($usages as $usage)
            @php
                $pemakaian = $usage->jumlah;
                $tagih = $usage->nominal;
                $pembayaran = $usage->transaction->sum('total');
                $totalPemakaian += $pemakaian;
                $totalTagih += $tagih;
                $totalPembayaran += $pembayaran;
            @endphp
            <tr>
                <td style="border: 1px solid black; padding: 5px;" align="center">{{ $no++ }}</td>
                <td style="border: 1px solid black; padding: 5px;" align="left">{{ $usage->customers->nama }}</td>
                <td style="border: 1px solid black; padding: 5px;" align="left">
                    {{ $usage->customers->village ? $usage->customers->village->nama : '' }}
                </td>
                <td style="border: 1px solid black; padding: 5px;" align="center">
                    {{ $usage->installation->kode_instalasi ?? '' }}</td>
                <td style="border: 1px solid black; padding: 5px;" align="right">{{ $pemakaian }}</td>
                <td style="border: 1px solid black; padding: 5px;" align="right">{{ number_format($tagih, 2) }}</td>
                <td style="border: 1px solid black; padding: 5px;" align="center">{{ $usage->status }}</td>
                <td style="border: 1px solid black; padding: 5px;" align="right">{{ number_format($pembayaran, 2) }}</td>
            </tr>
        @endforeach
        <tr style="font-weight: bold;">
            <td style="border: 1px solid black; padding: 5px;" colspan="4">Jumlah</td>
            <td style="border: 1px solid black; padding: 5px;" align="right">{{ $totalPemakaian }}</td>
            <td style="border: 1px solid black; padding: 5px;" align="right">{{ number_format($totalTagih, 2) }}</td>
            <td style="border: 1px solid black; padding: 5px;" align="center"></td>
            <td style="border: 1px solid black; padding: 5px;" align="right">{{ number_format($totalPembayaran, 2) }}</td>
        </tr>
    </table>
@endsection
