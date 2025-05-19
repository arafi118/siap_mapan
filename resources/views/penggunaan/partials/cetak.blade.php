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
    <title>Struk Tagihan Pemakaian Air</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            padding: 32px;
            font-size: 8px;
            color: rgba(0, 0, 0, 0.8);
            font-family: Arial, Helvetica, sans-serif;
        }

        .box {
            width: 100%;
            border: 1px solid #000;
            padding: 4px;
            margin-bottom: .8cm;
            height: 7cm;
        }

        .tb-padding tr td {
            padding: 2px 4px;
        }

        .tb-padding-sm tr td {
            padding: 1px 2px;
        }
    </style>

</head>

<body>
    <div class="container">
        @foreach ($usage as $use)
            <div class="box">
                <table border="0" width="100%">
                    <tr>
                        <td width="6%">
                            <div style="font-size: 9px;">
                                CATER
                            </div>
                            <div style="font-size: 9px;">NO URUT</div>
                            <div style="font-size: 9px;">
                                BULAN
                            </div>
                        </td>
                        <td width="22%">
                            <div style="font-size: 9px;">
                                : {{ strtoupper($use->usersCater->nama) }}
                            </div>
                            <div style="font-size: 9px;">: {{ $use->installation->id }}</div>
                            <div style="font-size: 9px;">
                                : {{ Tanggal::namaBulan($use->tgl_pemakaian) }}
                                {{ Tanggal::tahun($use->tgl_pemakaian) }}
                            </div>
                        </td>
                        <td width="5%" align="right">
                            <img src="assets/img/cetak1.png" style="max-height: 40px;">
                        </td>
                        <td width="30%" align="center">
                            <div style="font-size: 12px; font-weight: bold;">STRUK TAGIHAN PEMAKAIAN AIR</div>
                            <div style="font-size: 12px; font-weight: bold;">BADAN USAHA MILIK DESA (BUMDes)</div>
                            <div style="font-size: 12px; font-weight: bold;">UNIT AIR</div>
                        </td>
                        <td width="5%" align="left">
                            <img src="assets/img/cetak2.png" style="max-height: 40px;">
                        </td>
                        <td width="15%">&nbsp;</td>
                    </tr>
                </table>

                <table class="tb-padding" border="1" width="100%"
                    style="border-collapse: collapse; border: 1px solid #000; margin-top: 12px; font-size: 11px;">
                    <tr>
                        <td width="20%" align="center">NAMA PELANGGAN</td>
                        <td width="13%" align="center">NO INDUK</td>
                        <td width="24%" align="center">ALAMAT</td>
                        <td width="12%" align="center">METER AWAL</td>
                        <td width="12%" align="center">METER AKHIR</td>
                        <td width="11%" align="center">PEMAKAIAN</td>
                    </tr>
                    <tr>
                        <td align="center">{{ strtoupper($use->customers->nama) }}</td>
                        <td align="center">{{ $use->installation->kode_instalasi }}
                            {{ substr($use->installation->package->kelas, 0, 1) }}</td>
                        <td align="center">{{ $use->installation->alamat }}</td>
                        <td align="center">{{ $use->awal }}</td>
                        <td align="center">{{ $use->akhir }}</td>
                        <td align="center">{{ $use->jumlah }}</td>
                    </tr>
                </table>

                <table class="tb-padding-sm" border="0" width="100%" style="font-size: 11px;">
                    <tr>
                        <td colspan="5" style="font-size: 12px; margin-top: 12px; padding-left: 24px;">
                            <u>RINCIAN BIAYA</u>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%" align="left" style="padding-left: 24px;">Pemakaian Air</td>
                        <td width="2%" align="right">:</td>
                        <td width="20%" align="left">Rp. {{ number_format($use->nominal, 2) }}</td>
                        <td width="2%" align="center">&nbsp;</td>
                        <td width="12%" align="left">
                            {{ ucwords($bisnis->desa) }},
                            {{ Tanggal::tglLatin(date('Y-m-t', strtotime($use->tgl_pemakaian))) }}
                        </td>
                    </tr>
                    <tr>
                        <td width="15%" align="left" style="padding-left: 24px;">Beban Tetap</td>
                        <td width="2%" align="right">:</td>
                        <td width="20%" align="left">Rp. {{ number_format($use->installation->abodemen, 2) }}</td>
                        <td width="2%" align="center">&nbsp;</td>
                        <td width="12%" align="left">Bendahara</td>
                    </tr>
                    <tr>
                        <td width="15%" align="left" style="padding-left: 24px;">Denda</td>
                        <td width="2%" align="right">:</td>
                        <td width="20%" align="left">Rp. 0.00</td>
                        <td width="2%" align="center">&nbsp;</td>
                        <td rowspan="2" width="14%" align="left">
                            <div style="position: absolute; height: 24px; transform: translateY(-12px);">
                                <img src="../storage/app/public/ttd/{{ $jabatan->tanda_tangan }}"
                                    style="height: 50px;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%" align="left" style="padding-left: 24px;">Total</td>
                        <td width="2%" align="right">:</td>
                        <td width="20%" align="left">
                            <b>Rp. {{ number_format($use->nominal + $use->installation->abodemen, 2) }}</b>
                        </td>
                        <td width="2%" align="center">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="15%" align="left" style="padding-left: 24px;">Terbilang</td>
                        <td width="2%" align="right">:</td>
                        <td width="35%" class="keterangan terbilang">
                            <i>{{ ucwords($keuangan->terbilang($use->nominal + $use->installation->abodemen)) }}
                                Rupiah</i>
                        </td>
                        <td width="2%" align="center">&nbsp;</td>
                        <td width="12%" align="left" style="font-weight: bold;">
                            {{ ucwords($jabatan->nama) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" height="3"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border: 1px solid #000; font-size: 7px;">
                            <div style="padding: 2px">
                                Pembayaran Via Transfer:
                                <div style="text-align: center;font-weight: bold;">
                                    <div>BRI No Rekening:</div>
                                    <div style="font-size: 11px;">0153-01-001906-56-9</div>
                                    <div>a/n. BUMDES BANGUN KENCANA MULO</div>
                                </div>
                            </div>
                        </td>
                        <td colspan="3" align="center" style="font-size: 8px;">
                            <div>
                                SELURUH PELANGGAN AIR
                                "{{ $bisnis->nama }}" WAJIB MEMATUHI
                                SEGALA
                                KETENTUAN MANAJEMEN
                                PENGELOLAAN OLEH
                            </div>
                            <div>
                                BUMDes BANGUN KENCANA MULO, SESUAI DENGAN PERATURAN DESA MULO NOMOR 3 TAHUN 2018.
                            </div>
                            <div>
                                KELUHAN PELANGGAN HUBUNGI WA
                                0882-1673-8479 (ISWANTO)
                                0878-0484-5880 (NURUL)
                            </div>
                            <div>
                                NB: TERLAMBAT 2 BULAN AKAN DITERBITKAN SURAT PERINGATAN,
                                TERLAMBAT 3 BULAN
                                AKAN DITERBITKAN
                                SURAT PEMUTUSAN SEMENTARA
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        @endforeach
    </div>
</body>

</html>
