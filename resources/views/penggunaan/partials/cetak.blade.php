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
            margin-top: 18px;
        }
    </style>

</head>

<body>
    <div class="container">
        @foreach ($usage as $use)
            <div class="box">
                <table border="0" width="100%">
                    <tr>
                        <td width="50" align="right">
                            <img src="assets/img/cetak1.png" style="max-height: 30px;">
                        </td>
                        <td width="100" align="center">
                            <div class="fw-bold" style="font-size: 14px;">STRUK TAGIHAN PEMAKAIAN AIR</div>
                            <div style="font-size: 9px;">BADAN USAHA MILIK DESA (BUMDes)</div>
                            <div class="fw-bold">UNIT AIR</div>
                        </td>
                        <td width="50" align="left">
                            <img src="assets/img/cetak2.png" style="max-height: 30px;">
                        </td>
                    </tr>
                    <tr>
                        <td width="25" align="left">
                            <div style="font-size: 9px;">CATER : {{ $use->usersCater->nama }}</div>
                        </td>
                        <td width="150" align="left">
                            <div style="font-size: 9px;">
                                BULAN : {{ Tanggal::namaBulan($use->tgl_pemakaian) }}
                                {{ Tanggal::tahun($use->tgl_pemakaian) }}
                            </div>
                        </td>
                        <td width="25" align="right">
                            <div style="font-size: 9px;">NO URUT : {{ $use->installation->id }}</div>
                        </td>
                    </tr>
                </table>
                <table border="1" width="100%" style="border-collapse: collapse; border: 1px solid #000;">
                    <tr>
                        <td width="20%" align="center">NAMA PELANGGAN</td>
                        <td width="13%" align="center">NO INDUK</td>
                        <td width="20%" align="center">ALAMAT</td>
                        <td width="14%" align="center">METER AWAL</td>
                        <td width="14%" align="center">METER AKHIR</td>
                        <td width="15%" align="center">PEMAKAIAN</td>
                    </tr>
                    <tr>
                        <td align="center">{{ $use->customers->nama }}</td>
                        <td align="center">{{ $use->installation->kode_instalasi }}
                            {{ substr($use->installation->package->kelas, 0, 1) }}</td>
                        <td align="center">{{ $use->installation->alamat }}</td>
                        <td align="center">{{ $use->awal }}</td>
                        <td align="center">{{ $use->akhir }}</td>
                        <td align="center">{{ $use->jumlah }}</td>
                    </tr>
                </table>
                <table border="0" width="100%" style="font-size: 9px;">
                    <tr>
                        <td colspan="5" style="font-size: 12px">RINCIAN BIAYA</td>
                    </tr>
                    <tr>
                        <td width="10%" align="left">Pemakaian Air</td>
                        <td width="2%" align="right">:</td>
                        <td width="20%" align="left">Rp. {{ number_format($use->nominal, 2) }}</td>
                        <td width="14%" align="center">&nbsp;</td>
                        <td width="14%" align="left">
                            {{ ucwords($bisnis->desa) }},
                            {{ Tanggal::tglLatin(date('Y-m-t', strtotime($use->tgl_pemakaian))) }}
                        </td>
                    </tr>
                    <tr>
                        <td width="10%" align="left">Beban Tetap</td>
                        <td width="2%" align="right">:</td>
                        <td width="20%" align="left">Rp. {{ number_format($use->installation->abodemen, 2) }}</td>
                        <td width="14%" align="center">&nbsp;</td>
                        <td width="14%" align="left">Bendahara</td>
                    </tr>
                    <tr>
                        <td width="10%" align="left">Denda</td>
                        <td width="2%" align="right">:</td>
                        <td width="20%" align="left">Rp. 0.00</td>
                        <td width="14%" align="center">&nbsp;</td>
                        <td rowspan="2" width="14%" align="left">
                            <div style="position: absolute; height: 24px; transform: translateY(-12px);">
                                <img src="../storage/app/public/ttd/{{ $jabatan->tanda_tangan }}"
                                    style="height: 50px;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="10%" align="left">Total</td>
                        <td width="2%" align="right">:</td>
                        <td width="20%" align="left">Rp.
                            {{ number_format($use->nominal + $use->installation->abodemen, 2) }}</td>
                        <td width="14%" align="center">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="10%" align="left">Terbilang</td>
                        <td width="2%" align="right">:</td>
                        <td width="14%" class="keterangan terbilang">
                            <span>{{ ucwords($keuangan->terbilang($use->nominal + $use->installation->abodemen)) }}
                                Rupiah</span>
                        </td>
                        <td width="14%" align="center">&nbsp;</td>
                        <td width="14%" align="left" style="font-weight: bold;">
                            {{ ucwords($jabatan->nama) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" height="8"></td>
                    </tr>
                    <tr>
                        <td colspan="5" align="center" style="font-size: 6px;">
                            <div>
                                SELURUH PELANGGAN AIR
                                "{{ $bisnis->nama }}" WAJIB MEMATUHI
                                SEGALA
                                KETENTUAN MANAJEMEN
                                PENGELOLAAN OLEH BUMDes BANGUN KENCANA MULO,
                            </div>
                            <div>
                                SESUAI DENGAN PERATURAN DESA MULO NOMOR 3 TAHUN 2018.
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
