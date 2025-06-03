@php
    use Carbon\Carbon;
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

    <div style="text-align: center; max-width: 100%;">
        {{-- <div style="font-size: 14px; margin-bottom: 2px;"><b>FORM INPUT CATER</b></div> --}}
        <div style="font-size: 18px; margin-bottom: 2px;"><b>FORM INPUT CATER</b>
        </div>
        {{-- <div style="font-size: 14px; margin-bottom: 5px;">KALURAHAN MULO KAPANEWON WONOSARI</div> --}}
    </div>
    <div style="border-bottom: 2px solid #1a1a1a; margin: 4px 0;"></div>
    <table style="width: 100%; margin-top: 10px; font-size: 12px; border-collapse: collapse; border: none;">
        <tr>
            <td style="border: none; padding-right: 4px; white-space: nowrap; width: 120px;">Bulan Pemakaian</td>
            <td style="border: none; padding: 0 4px; white-space: nowrap;">
                : <b>{{ Tanggal::namaBulan($bulan) }} {{ Carbon::createFromFormat('Y-m', $bulan)->format('Y') }}</b>
            </td>
        </tr>
        <tr>
            <td style="border: none; padding-right: 4px; white-space: nowrap;">Cater</td>
            <td style="border: none; padding: 0 4px; white-space: nowrap;">: <b>{{ $caterUser->nama ?? '-' }}</b></td>
        </tr>
    </table>

    <!-- TABEL DATA -->
    <table style="width: 100%; font-size: 12px; border-collapse: collapse; margin-top: 10px;">
        <thead>
            <tr>
                <th style="text-align: center; width: 5%;">No</th>
                <th style="text-align: center; width: 20%;">Nama</th>
                <th style="text-align: center; width: 15%;">Dusun</th>
                <th style="text-align: center; width: 15%;">No. Induk</th>
                <th style="text-align: center; width: 5%;">RT</th>
                <th style="text-align: center; width: 10%;">Awal</th>
                <th style="text-align: center; width: 10%;">Akhir</th>
                <th style="text-align: center; width: 20%;">Keterangan</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($installations as $inst)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $inst->customer->nama ?? '-' }}</td>
                    <td>{{ $inst->village->dusun ?? '-' }}</td>
                    <td align="center">{{ $inst->kode_instalasi }}-{{ $inst->package->inisial }}</td>
                    <td align="center">{{ $inst->rt ?? '00' }}</td>
                    <td align="center">{{ $inst->akhir ?? 0 }}</td> {{-- nilai awal sudah disiapkan dari controller --}}
                    <td></td> {{-- Data akhir bulan ini, isi sesuai kebutuhan --}}
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
