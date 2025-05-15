@php
    use App\Utils\Tanggal;
@endphp
<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <style>
        * {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
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

    <!-- HEADER - letakkan di luar table -->
    <div style="text-align: center; max-width: 100%;">
        <div style="font-size: 14px; margin-bottom: 2px;"><b>DAFTAR TAGIHAN PEMAKAIAN AIR</b></div>
        <div style="font-size: 18px; margin-bottom: 2px;"><b>"{{ strtoupper($bisnis->nama) }}" BUMDes BANGUN KENCANA</b>
        </div>
        <div style="font-size: 14px; margin-bottom: 5px;">KALURAHAN MULO KAPANEWON WONOSARI</div>
    </div>
    <!-- GARIS & NOMOR -->
    <table style="width: 100%; border-collapse: collapse; text-align: left; margin-top: 10px;">

        <tr>
            <td colspan="3" style="border: none; padding: 0;">
                <div style="border-top: 2px solid rgb(70, 70, 70); width: 100%;"></div>
            </td>
        </tr>
        <tr>
            <td style="width: 15%; text-align: left; border: none;"></td>
        </tr>
        <tr>
            <td style="width: 15%; text-align: left; border: none;"></td>
        </tr>
        <tr>
            <!--<td style="text-align: left; border: none; padding-left: 50px; padding-top: 1px; padding-bottom: 1px;">-->
            <td style="text-align: left; border: none;  padding-top: 1px; padding-bottom: 1px;">
                Bulan
            </td>
            <td style="border: none; padding-top: 1px; padding-bottom: 1px;">
                : <b>{{ $bulan ?? '-' }} {{ Tanggal::Tahun($usage->tgl_akhir) }}</b>
            </td>
        </tr>
        <tr>
            <td style="text-align: left; border: none; padding-top: 1px; padding-bottom: 1px;">
                Dusun
            </td>
            <td style="border: none; padding-top: 1px; padding-bottom: 1px;">
                : <b>{{ $usages->installation->village->dusun ?? '-' }}</b>
            </td>
        </tr>
        <tr>
            <td style="text-align: left; border: none; padding-top: 1px; padding-bottom: 1px;">
                Cater
            </td>
            <td style="border: none; padding-top: 1px; padding-bottom: 1px;">
                : <b>{{ $pemakaian_cater ?? '-' }}</b>
            </td>
        </tr>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Nama</th>
                <th style="text-align: center;">No. Induk</th>
                <th style="text-align: center;">Dusun</th>
                <th style="text-align: center;">RT</th>
                <th style="text-align: center;">Awal</th>
                <th style="text-align: center;">Akhir</th>
                <th style="text-align: center;">Pemakaian</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: center;">Total</th>
            </tr>

        </thead>
        <tbody>
            @foreach ($usages as $i => $usage)
                <tr>
                    <td align="center">{{ $i + 1 }}</td>
                    <td>{{ $usage->customers->nama }}</td>
                    <td>{{ $usage->installation->kode_instalasi }}</td>
                    <td>{{ $usage->installation->village->dusun }}</td>
                    <td align="center">{{ $usage->installation->rt ?? '-' }}</td>
                    <td align="center">{{ $usage->awal }}</td>
                    <td align="center">{{ $usage->akhir }}</td>
                    <td align="center">
                        {{ $usage->jumlah }}
                    </td>
                    <td align="center">
                        {{ $usage->status }}
                    </td>
                    <td align="right"><b>{{ number_format($total, 2, ',', '.') }}</b></td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
