<title>{{ $title }}</title>

<style>
    * {
        font-family: 'Arial', sans-serif;

    }
</style>
@extends('pelaporan.layouts.base')

@section('content')
    <table class="header-table" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
        <tr>
            <td colspan="3" align="center">
                <div style="font-size: 18px; font-weight: bold;">Daftar Pelanggan</div>
                <div style="font-size: 16px; font-weight: bold;">{{ strtoupper($sub_judul) }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="10"></td>
        </tr>
    </table>
    @php
        $no = 1;
    @endphp
    <table border="0" width="100%" cellspacing="0" cellpadding="0"
        style="font-size: 12px; table-layout: fixed; border-collapse: collapse;">
        <tr style="background: rgb(232, 232, 232); font-weight: bold;">
            <th width="3%" style="border: 1px solid black; padding: 5px;">No</th>
            <th width="13%" style="border: 1px solid black; padding: 5px;">Nama</th>
            <th width="10%" style="border: 1px solid black; padding: 5px;">Nik</th>
            <th width="22%" style="border: 1px solid black; padding: 5px;">Alamat</th>
            <th width="10%" style="border: 1px solid black; padding: 5px;">No. Telp</th>
            <th width="10%" style="border: 1px solid black; padding: 5px;">Kode Instalasi</th>
            <th width="8%" style="border: 1px solid black; padding: 5px;">Status</th>
        </tr>
        @foreach ($installations as $installation)
            <tr>
                <td align="center" style="border: 1px solid black; padding: 5px;">{{ $no++ }}</td>
                <td align="left" style="border: 1px solid black; padding: 5px;">{{ $installation->customer->nama }}</td>
                <td align="center" style="border: 1px solid black; padding: 5px;">{{ $installation->customer->nik }}</td>
                <td align="left" style="border: 1px solid black; padding: 5px;">{{ $installation->customer->alamat }}</td>
                <td align="center" style="border: 1px solid black; padding: 5px;">{{ $installation->customer->hp }}</td>
                <td align="center" style="border: 1px solid black; padding: 5px;">{{ $installation->kode_instalasi }}</td>
                <td align="center" style="border: 1px solid black; padding: 5px;">
                    @if ($installation->status == 'R' || $installation->status == '0')
                        Permohonan
                    @elseif ($installation->status == 'I')
                        Pasang
                    @elseif ($installation->status == 'A')
                        Aktif
                    @elseif ($installation->status == 'B')
                        Blokir
                    @elseif ($installation->status == 'C')
                        Cabut
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
@endsection
