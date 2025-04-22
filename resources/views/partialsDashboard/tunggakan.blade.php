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
                <div
                    style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); text-align: center; max-width: 100%;">
                    <div style="font-size: 16px;"><b>BADAN USAHA MILIK DESA</b></div>
                    <div style="font-size: 16px;"><b>UNIT AIR {{ strtoupper($bisnis->nama) }}
                        </b></div>
                    <div style="font-size: 16px;">KALURAHAN MULO KAPENAWON WONOSARI</div>
                    <div style="font-size: 14px; word-wrap: break-word;"><i>Sekretariat: {{ $bisnis->alamat }}</i></div>
                </div>
            </div>
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <tr>
                    <td style="width: 15%; text-align: left; border: none;"></td>
                </tr>
                <tr>
                    <td colspan="3" style="border: none; padding: 0;">
                        <div style="border-top: 3px solid rgb(88, 86, 86); margin-bottom: 1px; width: 100%;"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="border: none; padding: 0;">
                        <div style="border-top: 3px solid rgb(88, 86, 86); width: 100%;"></div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 15%; text-align: left; border: none;"></td>
                </tr>
                <tr>
                    <td
                        style="text-align: left; border: none; padding-left: 70px; padding-top: 2px; padding-bottom: 2px;">
                        No.</td>
                    <td style="border: none; padding-top: 2px; padding-bottom: 6px;">: 002/BUMDES/2025</td>
                </tr>

                <tr>
                    <td
                        style="text-align: left; border: none; padding-left: 70px; padding-top: 2px; padding-bottom: 2px;">
                        Hal</td>
                    <td style="border: none; padding-top: 2px; padding-bottom: 6px;">: Surat Pemutusan Jaringan
                        Sementara</td>
                </tr>

                <tr>
                    <td colspan="2" style="border: none; height: 10px;"></td>
                </tr>
                <td style="text-align: left; border: none; padding-left: 70px; padding-top: 2px; padding-bottom: 2px;">
                </td>
                <td style="border: none; padding-top: 2px; padding-bottom: 6px;"><b>Kepada</b></td>
                <tr>
                    <td
                        style="text-align: left; border: none; padding-left: 70px; padding-top: 2px; padding-bottom: 2px;">
                    </td>
                    <td style="border: none; padding-top: 2px; padding-bottom: 6px;"><b>Yth.
                            {{ $tunggakan->customer->nama }}</b></td>
                </tr>
                <tr>
                    <td
                        style="text-align: left; border: none; padding-left: 70px; padding-top: 2px; padding-bottom: 2px;">
                    </td>
                    <td style="border: none; padding-top: 2px; padding-bottom: 6px;"><b>Di tempat</b></td>
                </tr>
                <tr>
                    <td colspan="2" style="border: none; height: 10px;"></td>
                </tr>
                <tr>
                    <td colspan="3"
                        style="text-align: left; border: none; padding-left: 70px; padding-top: 2px; padding-bottom: 2px;">
                        Bersama surat ini, kami sampaikan bahwa saudara tidak melaksanakan pembayaran tagihan air sesuai
                        waktu yang <br> telah
                        ditentukan dengan rincian sebagai berikut:
                    </td>
                </tr>

            </table>
        </div>
        <div class="content">
            <div style="width: 100%; display: flex; justify-content: center;">
                <table style="width: 81%; border-collapse: collapse; text-align: center; margin-top: 5px;">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>BULAN/TAHUN</th>
                            <th>NOMINAL</th>
                            <th>KETERANGAN</th>
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
                                    {{ number_format($u->nominal, 2, ',', '.') }}&nbsp;
                                </td>
                                <td style="text-align: left;">&nbsp;{{ Tanggal::namaBulan($u->tgl_pemakaian) }}
                                    {{ Tanggal::tahun($u->tgl_pemakaian) }}
                                </td>
                            </tr>
                            @php $total += $u->nominal; @endphp
                        @endforeach
                        <tr>
                            <td colspan="2"><b>JUMLAH</b></td>
                            <td style="text-align: right;"><b>{{ number_format($total, 2, ',', '.') }}
                                </b></td>
                            <td></td>
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
                            Dengan ini, kami akan melakukan pemutusan sementara terhadap pelanggan PAB Tirto Mulo
                            sebagai berikut:
                        </td>
                    </tr>

                    <tr>
                        <td style="border: none;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td width="10%" style="text-align: left; padding: 2px 0; border: none;">Nama</td>
                        <td width="5%" style="text-align: right; padding: 2px 0; border: none;">:</td>
                        <td style="padding: 2px 0; border: none;">{{ $tunggakan->customer->nama }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: left; padding: 2px 0; border: none;">Alamat</td>
                        <td style="text-align: right; padding: 2px 0; border: none;">:</td>
                        <td style="padding: 2px 0; border: none;">{{ $tunggakan->alamat }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: left; padding: 2px 0; border: none;">No. SR</td>
                        <td style="text-align: right; padding: 2px 0; border: none;">:</td>
                        <td style="padding: 2px 0; border: none;">{{ $tunggakan->kode_instalasi }}</td>
                    </tr>

                    <tr>
                        <td style="border: none;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td colspan="3" style="text-align: justify; border: none;">
                            Penyambungan SR kembali akan dilaksanakan setealah melunasi tunggakan dan membayar
                            penyambungan kembali sebesar Rp.
                            {{ number_format($tunggakan->settings->biaya_aktivasi, 2, ',', '.') }},- dengan batas
                            toleransi 7 hari setelah pemutusan sementara. Apabila setelah 7 hari pelanggan tidak
                            memenuhi kewajiban maka akan dilaksanakan pemutusan
                            total sedangkan tunggakan akan tetap sebagai hutang
                            yang harus dibayar/ dilunasi.
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
                        <td colspan="3" align="center" style="border: none;">Mengetahui</td>
                    </tr>
                    <tr>
                        <td width="33%" align="center" style="border: none;">Direktur Bumdes</td>
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
                            <br><br><br>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</body>

</html>
