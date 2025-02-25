@php
    use App\Utils\Tanggal;

    $data_id = [];
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Bukti Tagihan Pemakaian</title>
    <style>
        body {
            font-size: 10px;
            color: rgba(0, 0, 0, 0.8);
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            width: 100%;
            overflow: auto;
            margin: auto;
        }

        .box {
            display: inline-block;
            box-sizing: border-box;
            vertical-align: top;
            width: 46%;
            height: 8cm;
            border: 2px solid #000;
            padding: 10px;
            margin-bottom: 4px;
        }

        .box-body {
            padding-top: 0px;
            padding-left: 20px;
            padding-right: 20px;
        }

        .keterangan {
            padding: 4px;
            padding-top: 4px;
            padding-bottom: 4px;
        }

        .fw-bold {
            font-weight: bold;
        }

        .border-b {
            border-bottom: 1px dashed rgba(0, 0, 0, 0.4);
        }

        .fw-medium {
            font-weight: 600;
        }

        .terbilang {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        .jajargenjang {
            background-color: rgb(204, 204, 204);
            -ms-transform: skew(-20deg);
            -webkit-transform: skew(-20deg);
            transform: skew(-20deg);
            text-align: center;
        }

        .jajargenjang2 {
            display: inline-block;
            background-color: rgb(204, 204, 204);
            -ms-transform: skew(-20deg);
            -webkit-transform: skew(-20deg);
            transform: skew(-20deg);
            text-align: center;
            padding: 2px 8px;
            white-space: nowrap;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media print {
            .jajargenjang {
                background-color: rgb(204, 204, 204);
                -ms-transform: skew(-20deg);
                -webkit-transform: skew(-20deg);
                transform: skew(-20deg);
                text-align: center;
            }
        }

        .fs-12 {
            font-size: 12px;
        }

        .text-left {
            padding-left: 6px;
            padding-right: 6px;
            padding-top: 2px;
            padding-bottom: 4px;
            text-align: left;
        }

        .tanggal {
            font-size: 8px;
            margin-left: 10px;
        }

        .flex {
            display: flex;
        }
    </style>

</head>

<body>
    <div class="container">
        @foreach ($usage as $use)
            <div class="box">
                <table border="0" width="100%" style="border-bottom: 1px solid #000;">
                    <tr>
                        <td width="40">
                            <img src="../storage/app/public/logo/{{ $gambar }}" width="50" height="50">
                        </td>
                        <td>
                            <div class="fw-bold">{{ strtoupper($bisnis->nama) }}</div>
                            <div style="font-size: 8px;">{{ 'SK Kemenkumham RI No. ' . $bisnis->nomor_bh }}</div>
                            <div style="font-size: 8px;">{{ $bisnis->alamat . ', Telp. ' . $bisnis->telpon }}</div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; font-size: 8px;">
                                <table>
                                    <tr>
                                        <td>Nomor</td>
                                        <td>:</td>
                                        <td><?php echo $use->id_instalasi; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td>:</td>
                                        <td>{{ Tanggal::tglIndo($use->tgl_akhir) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>

                <div class="box-body">
                    <table width="100%">
                        <tr>
                            <td width="30%">Nama Pelangan</td>
                            <td width="2%">:</td>
                            <td colspan="3" class="keterangan border-b">
                                {{ $use->customers->nama }}
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Tgl Bayar</td>
                            <td width="2%">:</td>
                            <td colspan="3" class="keterangan border-b">
                                {{ Tanggal::tglLatin($use->tgl_akhir) }}
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">No ref</td>
                            <td width="2%">:</td>
                            <td colspan="3" class="keterangan border-b">
                                {{ md5($use->id_instalasi) }}
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">T Awal</td>
                            <td width="2%">:</td>
                            <td colspan="3" class="keterangan border-b">
                                {{ $use->awal }}
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">T Akhir</td>
                            <td width="2%">:</td>
                            <td colspan="3" class="keterangan border-b">
                                {{ $use->akhir }}
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Jumlah</td>
                            <td width="2%">:</td>
                            <td colspan="3" class="keterangan border-b">
                                {{ $use->jumlah }}
                            </td>
                        </tr>
                        <tr>
                            <td>Total Bayar</td>
                            <td>:</td>
                            <td colspan="3" class="keterangan fw-medium terbilang jajargenjang">
                                <h4 {!! strlen($keuangan->terbilang($use->nominal)) > 30 ? 'style="font-size: 8px;"' : '' !!}>
                                    <span>{{ ucwords($keuangan->terbilang($use->nominal)) }} Rupiah</span>
                                </h4>
                            </td>
                        </tr>
                    </table>

                    <table width="100%" class="fs-12" style="margin-top: 8px;">
                        <tr>
                            <td width="40%" align="left" rowspan="6">
                                <i>
                                    <h3 class="flex" style="padding-left: 18px;">
                                        Terbilang Rp. &nbsp; <div class="jajargenjang2 text-left">
                                            {{ number_format($use->nominal, 2) }}</div>
                                    </h3>
                                </i>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        @endforeach
    </div>
</body>

</html>
