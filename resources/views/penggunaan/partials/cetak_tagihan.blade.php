@php
    use App\Utils\Tanggal;
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-size: 9px;
            font-family: Arial, sans-serif;
            width: 7.5cm;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            width: 100%;
            padding: 5px;
            border: 2px solid black;
            /* BORDER DI SEMUA SISI */
            box-sizing: border-box;
            /* Pastikan ukuran tetap sesuai */
        }

        .header img {
            width: 30px;
            height: 30px;
        }

        .header,
        .footer {
            text-align: center;
            font-weight: bold;
        }

        .content {
            text-align: left;
            margin-top: 5px;
        }

        .content table {
            width: 100%;
        }

        .border {
            border-top: 1px dashed black;
            border-bottom: 1px dashed black;
            margin: 3px 0;
            padding: 3px 0;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 5px;
            font-size: 8px;
        }

        @media print {
            body {
                width: 7.5cm;
                margin: 0;
            }

            .container {
                padding: 5px;
                border: 2px solid black;
                /* Pastikan border tetap muncul saat dicetak */
            }
        }
    </style>
</head>

<body onload="window.print()">
    @foreach ($usages as $index => $usage)
        <div class="container">
            <div class="header">
                <div style="font-size: 12px">{{ strtoupper($bisnis->nama) }}</div>
                <div>{{ 'SK Kemenkumham RI No. ' . $bisnis->nomor_bh }}</div>
                <div>{{ $bisnis->alamat }}</div>
                <div>Telp: {{ $bisnis->telpon }}</div>
            </div><br>
            <div class="border">
                STRUK PEMAKAIAN
            </div><br>

            <div class="content">
                <table>
                    <tr>
                        <td>No Ref</td>
                        <td class="text-right">{{ substr(md5($usage['id_instalasi']), 0, 8) }}</td>
                    </tr>
                    <tr>
                        <td>Nomor</td>
                        <td class="text-right">{{ $usage['id_instalasi'] }} / Pemakaian</td>
                    </tr>
                    <tr>
                        <td>Pelanggan</td>
                        <td class="text-right">{{ $data_customer[$usage['customer']]->nama }}</td>
                    </tr>
                    <tr>
                        <td>Tgl Bayar</td>
                        <td class="text-right">{{ Tanggal::tglLatin($usage['tgl_akhir']) }}</td>
                    </tr>
                </table>
                <div class="border">
                    <table>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Pemakaian Mater Air</td>
                            <td class="text-right">{{ $usage['awal'] }} - {{ $usage['akhir'] }}</td>
                        </tr>
                        <tr>
                            <td>Pemakaian Periode ini</td>
                            <td class="text-right">{{ $usage['jumlah'] }}</td>
                        </tr>
                        <tr>
                            <td>Tagihan</td>
                            <td class="text-right">Rp {{ number_format($usage['nominal'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><b>Total</b></td>
                            <td class="text-right"><b>Rp {{ number_format($usage['nominal'], 0, ',', '.') }}</b></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="footer">
                <div>Terima Kasih!</div>
                <div>Harap simpan struk ini</div>
                <div>{{ date('Y-m-d H:i') }}</div>
            </div>
        </div>
    @endforeach
</body>
