@php
    use App\Utils\Tanggal;
    use Carbon\Carbon;

@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
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
            border: 2px solid rgb(255, 255, 255);
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

        .content tbody td:nth-child(2) {
            padding-top: 8px;
            padding-bottom: 8px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            font-family: Arial, sans-serif;
            font-size: 13px;
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
                        <td width="20%" style="border: none; text-align: right; padding-right: 0;">
                            <img src="../../assets/img/cetak1.png" style="max-height: 60px;"
                                class="img-fluid d-none d-lg-block">
                        </td>
                        <td width="60%" align="center" style="height: 50px; border: none;">
                            <!-- Placeholder kosong agar posisi tetap -->
                        </td>
                        <td width="20%" style="border: none; text-align: left; padding-left: 0;">
                            <img src="../../assets/img/cetak2.png" style="max-height: 60px;"
                                class="img-fluid d-none d-lg-block">
                        </td>

                    </tr>
                </table>
                <div
                    style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); text-align: center; max-width: 100%;">
                    <div style="font-size: 16px;"><b>BADAN USAHA MILIK DESA</b></div>
                    <div style="font-size: 16px;"><b>UNIT AIR {{ strtoupper($bisnis->nama) }}
                        </b></div>
                    <div style="font-size: 16px;"><b>KALURAHAN MULO KAPENAWON WONOSARI</b></div>
                    <div style="font-size: 14px; word-wrap: break-word;"><i>Sekretariat: {{ $bisnis->alamat }}</i></div>
                </div>
            </div>
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <tr>
                    <td style="width: 15%; text-align: left; border: none;"></td>
                </tr>
                <tr>
                    <td colspan="3" style="border: none; padding: 0; text-align:center">
                        <div style="border-top: 3px solid rgb(88, 86, 86); margin: 0 auto 1px auto; width: 83%;"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="border: none; padding: 0; text-align:center">
                        <div style="border-top: 1px solid rgb(88, 86, 86); margin: 0 auto; width: 83%;"></div>
                    </td>
                </tr>

                <tr>
                    <td style="width: 15%; text-align: left; border: none;"></td>
                </tr>
                <tr>
                    <td
                        style="text-align: left; border: none; padding-left: 70px; padding-top: 2px; padding-bottom: 2px;">
                        No.</td>
                    <td style="border: none; padding-top: 2px; padding-bottom: 6px;">: 05/SP/IV/2024</td>
                </tr>
                <tr>
                    <td
                        style="text-align: left; border: none; padding-left: 70px; padding-top: 2px; padding-bottom: 2px;">
                        Lamp</td>
                    <td style="border: none; padding-top: 2px; padding-bottom: 6px;">: -</td>
                </tr>
                <tr>
                    <td
                        style="text-align: left; border: none; padding-left: 70px; padding-top: 2px; padding-bottom: 2px;">
                        Hal</td>
                    <td style="border: none; padding-top: 2px; padding-bottom: 6px;">: Peringatan Keterlambatan</td>
                </tr>

                <tr>
                    <td colspan="2" style="border: none; height: 10px;"></td>
                </tr>
                <td style="text-align: left; border: none; padding-left: 70px; padding-top: 2px; padding-bottom: 2px;">
                </td>
                <td style="border: none; padding-top: 2px; padding-bottom: 6px;"><b>Kepada :</b></td>
                <tr>
                    <td
                        style="text-align: left; border: none; padding-left: 70px; padding-top: 2px; padding-bottom: 2px;">
                    </td>
                    <td style="border: none; padding-top: 2px; padding-bottom: 6px;"><b>Yth, Bpk/Ibu
                            {{ $tunggakan->customer->nama }}</b></td>
                </tr>
                <tr>
                    <td
                        style="text-align: left; border: none; padding-left: 70px; padding-top: 2px; padding-bottom: 2px;">
                    </td>
                    <td style="border: none; padding-top: 2px; padding-bottom: 6px;"><b>RT..Dusun</b></td>
                </tr>

            </table>
            <div style="width: 100%; display: flex; justify-content: center;">
                <table style="width: 81%; margin-top: 5px; border-collapse: collapse; border: none;">
                    <tr>
                        <td colspan="3" style="text-align: justify; border: none;">
                            Berdasarkan data administrasi kami, hingga saat surat ini diterbitkan, Saudara belum
                            memenuhi kewajiban pembayaran langganan air untuk periode sebagai berikut:
                        </td>
                    </tr>

                </table>
            </div>

        </div>
        <div class="content">
            <div style="width: 100%; display: flex; justify-content: center;">
                <table style="width: 81%; border-collapse: collapse; text-align: center; margin-top: 5px;">
                    <thead>
                        <tr>
                            <th style="text-align: center; padding-top: 10px; padding-bottom: 10px;">NO</th>
                            <th style="text-align: center; padding-top: 10px; padding-bottom: 10px;">BULAN/TAHUN</th>
                            <th style="text-align: center; padding-top: 10px; padding-bottom: 10px;">NOMINAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($tunggakan->usage as $i => $u)
                            <tr>
                                <td style="text-align: center;">{{ $i + 1 }}</td>
                                <td style="text-align: left;">&nbsp;
                                    {{ Tanggal::namaBulan($u->tgl_akhir) }} {{ Tanggal::tahun($u->tgl_akhir) }}
                                </td>
                                <td style="text-align: right;">
                                    {{-- {{ number_format($u->nominal, 2, ',', '.') }}&nbsp; --}}
                                </td>
                            </tr>
                            @php $total += $u->nominal; @endphp
                        @endforeach
                        <tr>
                            <td colspan="2"><b>JUMLAH</b></td>
                            <td style="text-align: right;">
                                {{-- <b>{{ number_format($total, 2, ',', '.') }}&nbsp;</b> --}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="width: 100%; display: flex; justify-content: center;">
                <table style="width: 81%; margin-top: 5px; border-collapse: collapse; border: none;">
                    <tr>
                        <td colspan="3" style="padding: 4px 0; border: none;"></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: justify; border: none;">
                            Dengan ini kami sampaikan bahwa Saudara mengalami keterlambatan pembayaran
                            selama
                            {{ \Carbon\Carbon::parse($u->tgl_awal)->diffInMonths(\Carbon\Carbon::parse($u->tgl_akhir)) + 1 }}
                            bulan
                            bulan.
                            Sebagai bentuk kebijakan, kami masih memberikan waktu selama 5 (lima) hari sejak
                            diterbitkannya surat ini untuk melunasi seluruh tagihan kepada Bendahara.

                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding: 4px 0; border: none;"></td>
                    </tr>

                    <tr>
                        <td colspan="3" style="text-align: justify; border: none;">
                            Apabila hingga batas waktu yang telah ditentukan tersebut kewajiban belum diselesaikan, maka
                            kami akan mengambil tindakan tegas berupa <b><i>Pemutusan Jaringan Air</i></b> tanpa
                            pemberitahuan lebih
                            lanjut.
                        </td>
                    </tr>
                    <tr>
                        <td style="border: none;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: justify; border: none;">
                            Demikian surat ini kami sampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima
                            kasih.
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: justify; border: none;">

                        </td>
                    </tr>
                </table>
            </div>

            <div style="width: 100%; display: flex; justify-content: center;">
                <table style="width: 81%; border-collapse: collapse; margin-top: 5px; border: none;">
                    <tr>
                        <td colspan="3" style="text-align: right; border: none;">
                            {{ $bisnis->desa }}, {{ Carbon::now()->translatedFormat('d F Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="border: none;">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center" style="border: none;">Mengetahui,</td>
                    </tr>
                    <tr>
                        <td width="33%" align="center" style="border: none;">Pengawas Bumdes</td>
                        <td width="33%" style="border: none;"></td>
                        <td width="33%" style="text-align: center; border: none;">Ketua Unit Air</td>
                    </tr>
                    <tr>
                        <td style="border: none;"><br><br><br>

                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="border: none;">{{ $dir->nama ?? '' }}</td>
                        <td style="border: none;"></td>
                        <td style="text-align: center; border: none;">{{ $ket->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="border: none;">
                            <br><br><br><br><br>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</body>

</html>
