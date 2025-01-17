@php
    use App\Utils\Tanggal;
    use App\Utils\Inventaris;
@endphp
<title>{{ $title }}</title>
<style>
     * {
        font-family: 'Arial', sans-serif;

    }
    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
        table-layout: fixed;
    }
    th, td {
        border: 1px solid black; /* Garis untuk tabel utama */
        padding: 5px;
        text-align: center;
    }
    th {
        background-color: rgb(232, 232, 232);
        font-weight: bold;
    }
    .header-table td {
        border: none; /* Tidak ada garis untuk tabel header */
    }
    .p th, .p td {
        border: 0.1px solid rgb(0, 0, 0); /* Garis tipis untuk tabel jumlah */
    }
</style>

<!-- Header Judul -->
<table class="header-table" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
    <tr>
        <td colspan="3" align="center">
            <div style="font-size: 18px;">
                <b>Daftar Tanah</b>
            </div>
            <div style="font-size: 16px;">
                <b>{{ strtoupper($sub_judul) }}</b>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" height="3"></td>
    </tr>
</table>
<!-- Tabel Utama -->
<table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px; table-layout: fixed;">
    <!-- Header -->
    <tr style="background: rgb(232, 232, 232);">
        <th rowspan="2" width="3%">No</th>
        <th rowspan="2" width="6%">Tgl Beli</th>
        <th rowspan="2" width="20%">Nama Barang</th>
        <th rowspan="2" width="3%">Id</th>
        <th rowspan="2" width="5%">Kondisi</th>
        <th rowspan="2" width="3%">Unit</th>
        <th rowspan="2" width="8%">Harga Satuan</th>
        <th rowspan="2" width="8%">Harga Perolehan</th>
        <th rowspan="2" width="4%">Umur Eko.</th>
        <th rowspan="2" width="8%">Amortisasi</th>
        <th colspan="2" width="12%">Tahun Ini</th>
        <th colspan="2" width="12%">s.d. Tahun Ini</th>
        <th rowspan="2" width="8%">Nilai Buku</th>
    </tr>
    <tr style="background: rgb(232, 232, 232);">
        <th width="4%">Umur</th>
        <th width="8%">Biaya</th>
        <th width="4%">Umur</th>
        <th style="border: 1px solid black;" width="8%">Biaya</th>
    </tr>

    <!-- Baris Data -->
    <tr>
        <td>1</td>
        <td>01-01-2023</td>
        <td>Nama Barang Contoh</td>
        <td>123</td>
        <td>Baik</td>
        <td>5</td>
        <td>10,000</td>
        <td>50,000</td>
        <td>5</td>
        <td>2,000</td>
        <td>1</td>
        <td>2,000</td>
        <td>5</td>
        <td>10,000</td>
        <td>40,000</td>
    </tr>

    <!-- Baris Jumlah -->
    <tr>
        <td colspan="15" style="padding: 0px !important;">
            <table class="p" border="1" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px; table-layout: fixed; border-collapse: collapse;">
                <tr>
                    <td colspan="5" width="37%" align="left" height="15" style="text-align: left; padding-left: 5px;">
                        Jumlah Daftar ___(Hapus, Hilang, Jual) s.d. Tahun __
                    </td>
                    <td width="3%" align="right">5</td>
                    <td width="8%" align="right">10,000</td>
                    <td width="8%" align="right">50,000</td>
                    <td width="4%" align="right">5</td>
                    <td width="8%" align="right">2,000</td>
                    <td width="12%" align="right">10,000</td>
                    <td width="12%" align="right">50,000</td>
                    <td width="8%" align="right">40,000</td>
                </tr>
                <tr>
                    <td colspan="5" height="15" align="left" style="text-align: left; padding-left: 5px;">
                        Jumlah
                    </td>
                    <td width="3%" align="right">5</td>
                    <td width="8%" align="right">10,000</td>
                    <td width="8%" align="right">50,000</td>
                    <td width="4%" align="right">5</td>
                    <td width="8%" align="right">2,000</td>
                    <td width="12%" align="right">10,000</td>
                    <td width="12%" align="right">50,000</td>
                    <td width="8%" align="right">40,000</td>
                </tr>
            </table>
            
        </td>
    </tr>
</table>



        


