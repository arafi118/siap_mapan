@php
    use App\Utils\Tanggal;
    \Carbon\Carbon::setLocale('id');

@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>{{ $title ?? 'Form Input Cater' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
        }

        .header .title-small {
            font-size: 14px;
            margin-bottom: 2px;
            font-weight: bold;
        }

        .header .title-big {
            font-size: 18px;
            margin-bottom: 2px;
            font-weight: bold;
        }

        .header .subtitle {
            font-size: 14px;
            margin-bottom: 5px;
        }

        hr {
            border: none;
            border-bottom: 2px solid #1a1a1a;
            margin: 4px 0 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.info td {
            padding: 2px 6px;
            border: none;
            white-space: nowrap;
        }

        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
            vertical-align: middle;
        }

        table.data th {
            background-color: #f0f0f0;
        }

        td.text-left {
            text-align: left;
        }
    </style>
</head>

@php
    $installationsByDusun = $installations->groupBy(fn($inst) => $inst->village->dusun ?? '-');
@endphp

@foreach ($installationsByDusun as $dusun => $instGroup)

    <body>

        <div class="header">
            <div class="title-small">FORM INPUT CATER</div>
            <div class="title-big">"{{ strtoupper($bisnis->nama) }}" BUMDes BANGUN KENCANA</div>
            <div class="subtitle">KALURAHAN MULO KAPANEWON WONOSARI</div>
        </div>
        <hr>

        <table class="info" style="width:100%; border-collapse: collapse;">
            <tr>
                <td style="width:130px;">Bulan Pemakaian</td>
                @php
                    \Carbon\Carbon::setLocale('id');
                @endphp
                <td>: <b>{{ \Carbon\Carbon::createFromFormat('Y-m', $bulan)->translatedFormat('F Y') }}</b></td>
                <td style="width:130px; text-align:right;"></td>
                <td style="text-align:left;"></b></td>
            </tr>
            <tr>
                <td>Cater</td>
                <td>: <b>{{ $caterUser->nama ?? '-' }}</b></td>
                <td style="width:250px; text-align:right;">Dusun</td>
                <td style="text-align:left;">: <b>{{ $dusun }}</b></td>
            </tr>
        </table>


        <table class="data" style="width:100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="width:5%; border: 1px solid #000;">No</th>
                    <th style="width:25%; border: 1px solid #000;">Nama</th>
                    <th style="width:20%; border: 1px solid #000;">No. Induk</th>
                    <th style="width:5%; border: 1px solid #000;">RT</th>
                    <th style="width:10%; border: 1px solid #000;">Awal</th>
                    <th style="width:10%; border: 1px solid #000;">Akhir</th>
                    <th style="width:25%; border: 1px solid #000;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($instGroup as $inst)
                    <tr>
                        <td style="border: 1px solid #000; text-align:center;">{{ $loop->iteration }}</td>
                        <td style="border: 1px solid #000; text-align:left;">{{ $inst->customer->nama ?? '-' }}</td>
                        <td style="border: 1px solid #000;">{{ $inst->kode_instalasi }}-{{ $inst->package->inisial }}
                        </td>
                        <td style="border: 1px solid #000; text-align:center;">{{ $inst->rt ?? '00' }}</td>
                        <td style="border: 1px solid #000; text-align:center;">{{ $inst->akhir ?? 0 }}</td>
                        <td style="border: 1px solid #000; text-align:center;"></td> {{-- akhir bulan ini --}}
                        <td style="border: 1px solid #000; text-align:center;"></td> {{-- keterangan --}}
                    </tr>
                @endforeach
            </tbody>
        </table>

    </body>
@endforeach


</html>
