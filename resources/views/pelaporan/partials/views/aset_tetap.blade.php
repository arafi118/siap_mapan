@php
    use App\Utils\Tanggal;
    use App\Utils\Inventaris;
@endphp
<title>{{ $title }}</title>
<table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
    <tr>
        <td colspan="3" align="center">
            <div style="font-size: 18px;">
                <b>Daftar </b>
            </div>
            <div style="font-size: 16px;">
                <b></b>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" height="5"></td>
    </tr>

</table>
<table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px; table-layout: fixed;">
    <tr style="background: rgb(232, 232, 232)">
        <th class="t l b" rowspan="2" width="3%">No</th>
        <th class="t l b" rowspan="2" width="6%">Tgl Beli</th>
        <th class="t l b" rowspan="2" width="20%">Nama Barang</th>
        <th class="t l b" rowspan="2" width="3%">Id</th>
        <th class="t l b" rowspan="2" width="5%">Kondisi</th>
        <th class="t l b" rowspan="2" width="3%">Unit</th>
        <th class="t l b" rowspan="2" width="8%">Harga Satuan</th>
        <th class="t l b" rowspan="2" width="8%">Harga Perolehan</th>
        <th class="t l b" rowspan="2" width="4%">Umur Eko.</th>
        <th class="t l b" rowspan="2" width="8%">Amortisasi</th>
        <th class="t l b" colspan="2" width="12%">Tahun Ini</th>
        <th class="t l b" colspan="2" width="12%">s.d. Tahun Ini</th>
        <th class="t l b r" rowspan="2" width="8%">Nilai Buku</th>
    </tr>
    <tr style="background: rgb(232, 232, 232)">
        <th class="t l b" width="4%">Umur</th>
        <th class="t l b" width="8%">Biaya</th>
        <th class="t l b" width="4%">Umur</th>
        <th class="t l b r" width="8%">Biaya</th>
    </tr>
    <tr>
        <td colspan="15" style="padding: 0px !important">
            <table class="p" border="0" width="100%" cellspacing="0" cellpadding="0"
                style="font-size: 10px; table-layout: fixed;">
                <tr>
                    <td class="t l b" width="37%" height="15">
                        Jumlah
                    </td>
                    <td class="t l b" width="3%" align="center"> </td>
                    <td class="t l b" width="8%">&nbsp;</td>
                    <td class="t l b" width="8%" align="right"> </td>
                    <td class="t l b" width="4%">&nbsp;</td>
                    <td class="t l b" width="8%">&nbsp;</td>
                    <td class="t l b" width="12%" align="right">
                        
                    </td>
                    <td class="t l b" width="12%" align="right">
                        
                    </td>
                    <td class="t l b r" width="8%" align="right">
                      
                    </td>
                </tr>
                <tr>
                    <td colspan="9">
                        <div style="margin-top: 16px;"></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
