<title>{{ $title }}</title>
<style>
    * {
        font-family: 'Arial', sans-serif;

    }

    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 11px;
        table-layout: fixed;
    }

    th,
    td {
        border: 1px solid black;
        /* Garis untuk tabel utama */
        padding: 5px;
    }

    th {
        background-color: rgb(232, 232, 232);
        font-weight: bold;
    }

    .header-table td {
        border: none;
        /* Tidak ada garis untuk tabel header */
    }

    .p th,
    .p td {
        border: 0.1px solid rgb(0, 0, 0);
        /* Garis tipis untuk tabel jumlah */
    }
</style>
<table class="header-table" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
    <tr>
        <td colspan="3" align="center">
            <div style="font-size: 18px;">
                <b>Daftar Pelanggan</b>
            </div>
            <div style="font-size: 16px;">
                <b>{{ strtoupper($sub_judul) }}</b>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" height="10"></td>
    </tr>
</table>
@php
    $no = 1;
@endphp
<table border="0" width="80%" cellspacing="0" cellpadding="0" style="font-size: 12px; table-layout: fixed;">
    <tr style="background: rgb(232, 232, 232);">
        <th width="3%">No</th>
        <th width="13%">Nama</th>
        <th width="10%">Nik</th>
        <th width="22%">Alamat</th>
        <th width="10%">No. Telp</th>
        <th width="10%">Kode Instalasi</th>
        <th width="8%">Status</th>
    </tr>
    @foreach ($installations as $installation)
        @foreach ($installation->usage as $usage)
            <tr>
                <td align="center">{{ $no++ }}</td>
                <td align="left">{{ $installation->customer->nama }}</td>
                <td align="center">{{ $installation->customer->nik }}</td>
                <td align="left">{{ $installation->customer->alamat }}</td>
                <td align="center">{{ $installation->customer->hp }}</td>
                <td align="center">{{ $installation->kode_instalasi }}</td>
                @if ($installation->status == 'R' || $installation->status == '0')
                    <td align="center">Permohonan</td>
                @elseif ($installation->status == 'I')
                    <td align="center">Pasang</td>
                @elseif ($installation->status == 'A')
                    <td align="center">Aktif</td>
                @elseif ($installation->status == 'B')
                    <td align="center">Blokir</td>
                @elseif ($installation->status == 'C')
                    <td align="center">Cabut</td>
                @endif
            </tr>
        @endforeach
    @endforeach
</table>
