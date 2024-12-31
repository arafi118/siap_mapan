<style type="text/css">
    .style1 {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10px;
    }

    .style2 {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 8px;
    }

    .top {
        border-top: 1px solid #000000;
    }

    .bottom {
        border-bottom: 1px solid #000000;
    }

    .left {
        border-left: 1px solid #000000;
    }

    .right {
        border-right: 1px solid #000000;
    }

    .allborder {
        border: 1px solid #000000;
    }

    .style26 {
        font-family: Verdana, Arial, Helvetica, sans-serif
    }

    .style27 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 11px;
        font-weight: bold;
    }

    .center {
        text-align: center;
    }
</style>

<body onLoad="window.print()">
    <table width="100%" action="" border="0" align="center" cellpadding="1" cellspacing="1.5" class="style1">

        <tr>
            <td width="4%" rowspan="17">&nbsp;</td>
            <td width="19%">
                Kode Transaksi
                <br>
                Tanggal Transasksi
            </td>
            <td width="15%">

            </td>
            <th width="14%" class="style26">BUKTI ANGSURAN</th>
        </tr>

        <tr>
            <td width="15%">Loan ID</td>
            <td width="11%"><strong>: </strong></td>
            <td colspan="2">
                <div align="right">Angsuran ke:
                    dari</div>
            </td>
            <th class="bottom top">STATUS PINJAMAN</th>
            <th class="bottom top">POKOK</th>
            <th class="bottom top">JASA</th>
        </tr>
        <tr>
            <td>ID Nasabah </td>
            <td colspan="3">: </td>
            <td>Alokasi Pinjaman </td>
            <td align="right"></td>
            <td align="right"></td>
        </tr>
        <tr>
            <td>Nama Nasabah </td>
            <td colspan="3"><b>: {{ $pinkel->anggota->namadepan }}</b></td>
            <td>Target Pengembalian (x)</td>
            <td align="right"></td>
            <td align="right"></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td colspan="3">: {{ $pinkel->anggota->d->nama_desa }}</td>
            <td class="bottom">Realisasi Pengembalian</td>
            <td class="bottom" align="right"></td>
            <td class="bottom" align="right"></td>
        </tr>
        <tr>
            <td>Tanggal Cair </td>
            <td colspan="3">: </td>
            <th>Saldo Pinjaman</th>
            <th align="right"></th>
            <th align="right"></th>
        </tr>
        <tr>
            <td>Sistem Angsuran </td>
            <td colspan="3">:
                x
            </td>

        </tr>
        <tr>
            <td>Pokok</td>
            <td>: </td>
            <td width="10%">
                <div align="right"></div>
            </td>
            <td width="12%">&nbsp;</td>
            <th class="bottom top">TAGIHAN BULAN DEPAN</th>
            <th class="bottom top">POKOK</th>
            <th class="bottom top">JASA</th>
        </tr>
        <tr>
            <td>Jasa</td>
            <td>: </td>
            <td>
                <div align="right"></div>
            </td>
            <td>&nbsp;</td>
            <td>Tunggakan s.d. Bulan Ini</td>
            <td align="right"></td>
            <td align="right"></td>
        </tr>
        <tr>
            <td class="bottom">Denda</td>
            <td class="bottom">: </td>
            <td class="bottom">
                <div align="right"></div>
            </td>
            <td class="bottom">&nbsp;</td>
            <td class="bottom">Angsuran Bulan Depan</td>
            <td align="right" style="border-bottom:1px solid #000;">

            </td>
            <td align="right" style="border-bottom:1px solid #000;">

            </td>
        </tr>
        <tr>
            <th height="27">JUMLAH BAYAR </th>
            <td>:</td>
            <td>
                <div align="right">

                </div>
            </td>
            <td>&nbsp;</td>
            <th class="bottom">TOTAL TAGIHAN (M+1)</td>

            <th align="right" style="border-bottom:1px solid #000;">&nbsp;</th>

        </tr>

        <tr>
            <td colspan="4">Terbilang : </td>
            <td>
                <div align="center">Diterima Oleh </div>
            </td>
            <td rowspan="5">&nbsp;</td>
            <td>
                <div align="center">Penyetor,</div>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <th colspan="3" valign="middle">&nbsp;</th>
        </tr>
    </table>

    <title>Struk Angsuran Kelompok</title>
</body>
