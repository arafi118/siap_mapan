<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        .no-border td {
            border: none;
            padding: 2px 4px;
        }
    </style>
</head>

<body>

    <h3 align="center">{{ $title }}</h3>

    <table class="no-border">
        <tr>
            <td>Bulan</td>
            <td>:</td>
            <td><b>{{ $bulan ?? '-' }}</b></td>
        </tr>
        <tr>
            <td>Dusun</td>
            <td>:</td>
            <td><b>{{ $dusun ?? '-' }}</b></td>
        </tr>
        <tr>
            <td>Cater</td>
            <td>:</td>
            <td><b>{{ $cater ?? '-' }}</b></td>
        </tr>
    </table>

    <br>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No. Induk</th>
                <th>Dusun</th>
                <th>RT</th>
                <th>Awal</th>
                <th>Akhir</th>
                <th>Pemakaian</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usages as $i => $usage)
                @php
                    preg_match('/Rt-(\d+)/i', $usage->installation->alamat ?? '', $match);
                    $rt = $match[1] ?? '-';
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $usage->customers->nama }}</td>
                    <td>{{ $usage->installation->kode_instalasi }}</td>
                    <td>{{ $usage->installation->village->dusun }}</td>
                    <td>{{ $rt }}</td>
                    <td>{{ $usage->awal }}</td>
                    <td>{{ $usage->akhir }}</td>
                    <td>{{ $usage->jumlah }}</td>
                    <td align="right">{{ number_format($usage->nominal, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
