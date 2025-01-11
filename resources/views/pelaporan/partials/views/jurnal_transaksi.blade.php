@php
use App\Utils\Tanggal;
@endphp

<title>{{ $title }}</title>

<!-- Header Judul -->
<table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 13px;">
    <tr>
        <td colspan="7" align="center">
            <div style="font-size: 18px;">
                <b>JURNAL TRANSAKSI</b>
            </div>
            <div style="font-size: 16px;">
                <b>....</b>
            </div>
        </td>
    </tr>
</table>

<!-- Tabel Utama -->
<table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 13px;">
    <tr>
        <td colspan="7" height="5"></td>
    </tr>
    <!-- Header Tabel -->
    <tr style="background: rgb(73, 73, 73); font-weight: bold; color: #fff;">
        <td height="20" align="center" width="4%">No</td>
        <td align="center" width="10%">Tanggal</td>
        <td align="center" width="8%">Ref ID.</td>
        <td align="center" width="8%">Kd. Rek</td>
        <td align="center" width="35%">Keterangan</td>
        <td align="center" width="15%">Debit</td>
        <td align="center" width="15%">Kredit</td>
        <td align="center" width="5%">Ins</td>
    </tr>

    <!-- Baris Data -->
    <tr>
        <td height="15" align="center"></td>
        <td align="center">AA</td>
        <td align="center">AA</td>
        <td align="center">AA</td>
        <td align="center">AA</td>
        <td align="center">AA</td>
        <td align="center">&nbsp;</td>
        <td align="center">AA</td>
    </tr>

    <tr>
        <td height="15" align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">BB</td>
        <td align="center">BB</td>
        <td align="center">BB</td>
        <td align="center">&nbsp;</td>
        <td align="center">aaaaa</td>
        <td align="center">BB</td>
    </tr>

    <tr>
        <td height="15" align="center">&nbsp;</td>
        <td align="center">CC</td>
        <td align="center">CC</td>
        <td align="center">CC</td>
        <td align="center">CC</td>
        <td align="center">CC</td>
        <td align="center">&nbsp;CC</td>
        <td align="center">CC</td>
    </tr>

    <tr>
        <td height="15" align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">DD</td>
        <td align="center">DD</td>
        <td align="center">DD</td>
        <td align="center">&nbsp;</td>
        <td align="center">DD</td>
        <td align="center">DD</td>
    </tr>

    <!-- Total Transaksi -->
    <tr>
        <td colspan="8" style="padding: 0px !important;">
            <table class="p" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 13px;">
                <tr style="background: rgb(233, 233, 233); font-weight: bold; color: #000;">
                    <td height="15" align="center">
                        <b>Total Transaksi</b>
                    </td>
                    <td align="center" width="15%">EE</td>
                    <td align="center" width="15%">EE</td>
                    <td align="center" width="5%">&nbsp;</td>
                </tr>
            </table>

            <div style="margin-top: 16px;"></div>
        </td>
    </tr>
</table>
