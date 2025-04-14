@php
    use App\Utils\Tanggal;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Pemakaian</title>
    <style>
        body {
            font-size: 12px;
            font-family: Arial, sans-serif;
            width: 10cm;
            height: 15cm;
            margin: 1px auto;
            padding: 1px;
            text-align: center;
            position: relative;
        }

        .container {
            width: 200%;
            padding: 10px;
            border: 2px solid rgb(0, 0, 0);
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .header img {
            width: 40px;
            height: 40px;
        }

        .header,
        .footer {
            text-align: center;
            font-weight: bold;
        }

        .content {
            text-align: center;
            margin-top: 5px;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
        }

        .content th,
        .content td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
        }

        .border {
            border-top: 1px dashed black;
            border-bottom: 1px dashed black;
            margin: 5px 0;
            padding: 5px 0;
        }

        .footer {
            margin-top: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        /* Header */
        thead tr th:first-child {
            border-top-left-radius: 10px;
            text-align: center;
        }

        thead tr th:not(:first-child) {
            text-align: left;
        }

        /* Isi kolom */
        tbody tr td:first-child {
            text-align: center;
        }

        tbody tr td:not(:first-child) {
            text-align: left;
        }

        /* Pojok kiri bawah */
        tbody tr:last-child td:first-child {
            border-bottom-left-radius: 10px;
        }
    </style>

</head>

<body onload="window.print()">
    <div class="container">
        <div class="header">
            <div style="font-size: 14px"></div>
            <div></div>
        </div><br>

        <div style="position: relative;">
            <!-- Tabel utama: QR + Data Pelanggan -->
            <div style="position: relative; text-align: center;">
                <table style="width: 100%;">
                    <tr>
                        <td width="20%" align="right" style="border: none;">
                            {{-- <img src="../storage/app/public/logo/{{ $gambar }}" width="50" height="50"> --}}
                            <img src="../../assets/img/cetak1.png"
                                style="max-height: 50px; margin-right: 15px; margin-left: 10px;"
                                class="img-fluid  d-none d-lg-block">
                        </td>

                        <td width="60%" align="center" style="height: 50px; border: none;">
                            <!-- Placeholder kosong agar posisi tetap -->
                        </td>
                        <td width="20%" align="left" style="border: none;">
                            {{-- <img src="../storage/app/public/logo/{{ $gambar }}" width="50" height="50"> --}}
                            <img src="../../assets/img/cetak2.png" style="max-height: 50px; margin-left: 10px;"
                                class="img-fluid d-none d-lg-block">
                        </td>
                    </tr>
                </table>


                <!-- Judul Tengah -->
                <div style="position: absolute; top: 0; left: 50%; transform: translateX(-50%);">
                    <div style="font-size: 16px;">KARTU METER PENGGUNAAN AIR</div>
                    <div style="font-size: 13px;"><b>UNIT AIR "TIRTO MULO"</b></div>
                    <div style="font-size: 12px;">(BUMDes) BANGUN KENCANA KALURAHAN MULO</div>
                    {{-- <div style="font-size: 13px;"><b>UNIT AIR</b></div> --}}


                </div>
            </div>

            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <tr>
                    <td colspan="3" style="border: none;">
                        <div style="border-top: 3px solid rgb(88, 86, 86); margin-bottom: 5px; width: 100%;"></div>
                    </td>
                </tr>
                <tr>
                    <td rowspan="3" style="width: 70px; vertical-align: top; border: none;">
                        <div style="width: 60px;">
                            {!! $qr !!}
                        </div>
                    </td>
                    <th style="width: 18%; text-align: left; border: none;">NAMA PELANGGAN</th>
                    <th style="border: none;">: ..................................................</th>
                </tr>
                <tr>
                    <th style="text-align: left; border: none;">NO. INDUK</th>
                    <th style="border: none;">: ..................................................</th>
                </tr>
                <tr>
                    <th style="text-align: left; border: none;">ALAMAT</th>
                    <th style="border: none;">: ..................................................</th>
                </tr>
            </table>
        </div>
        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th style="text-align: center;">NO</th>
                        <th style="text-align: center;">BULAN</th>
                        <th style="text-align: center;">ANGKA METER</th>
                        <th style="text-align: center;">TTD CATER</th>
                        <th style="text-align: center;">KETERENGAN</th>


                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>JANUARI</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>FEBRUARI</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>MARET</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>APRIL</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>MEI</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>JUNI</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>JULI</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>AGUSTUS</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>SEPTEMBER</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>OKTOBER</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td>NOVEMBER</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>12</td>
                        <td>DESEMBER</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
