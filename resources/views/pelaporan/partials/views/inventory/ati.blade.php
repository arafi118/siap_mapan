@php
    use App\Utils\Tanggal;
    use App\Utils\Inventaris;
@endphp
<!-- Header Judul -->
<table class="header-table" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
    <tr>
        <td colspan="3" align="center">
            <div style="font-size: 18px;">
                <b>Daftar {{ $nama }}</b>
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
<table border="0"width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px; table-layout: fixed;">
    <!-- Header -->
    <tr style="background: rgb(232, 232, 232);">
        <th rowspan="2" width="3%" style="border: 0.5px solid black;">No</th>
        <th rowspan="2" width="7%" style="border: 0.5px solid black;">Tgl Beli
        </th>
        <th rowspan="2" width="10%" style="border: 0.5px solid black;">Nama
            Barang</th>
        <th rowspan="2" width="3%" style="border: 0.5px solid black;">Id</th>
        <th rowspan="2" width="5%" style="border: 0.5px solid black;">Kondisi
        </th>
        <th rowspan="2" width="4%" style="border: 0.5px solid black;">Unit</th>
        <th rowspan="2" width="8%" style="border: 0.5px solid black;">Harga
            Satuan</th>
        <th rowspan="2" width="8%" style="border: 0.5px solid black;">Harga
            Perolehan</th>
        <th rowspan="2" width="4%" style="border: 0.5px solid black;">Umur Eko.
        </th>
        <th rowspan="2" width="8%" style="border: 0.5px solid black;">
            Amortisasi</th>
        <th colspan="2" width="12%" style="border: 0.5px solid black;">Tahun Ini
        </th>
        <th colspan="2" width="12%" style="border: 0.5px solid black;">s.d.
            Tahun Ini</th>
        <th rowspan="2" width="8%" style="border: 0.5px solid black;">Nilai
            Buku</th>
    </tr>

    <tr style="background: rgb(232, 232, 232);">
        <th width="4%">Umur</th>
        <th width="8%">Biaya</th>
        <th width="4%">Umur</th>
        <th style="border: 1px solid black;" width="8%">Biaya</th>
    </tr>

    <!-- Baris Data -->
    @php
        $t_unit = 0;
        $t_harga = 0;
        $t_penyusutan = 0;
        $t_akum_susut = 0;
        $t_nilai_buku = 0;

        $j_unit = 0;
        $j_harga = 0;
        $j_penyusutan = 0;
        $j_akum_susut = 0;
        $j_nilai_buku = 0;

        $no = 1;
    @endphp
    @foreach ($Inventory as $inv)
        @php
            $nama_barang = $inv->nama_barang;
            $warna = '0, 0, 0';
            if (!($inv->status == 'Baik') && $tgl_kondisi >= $inv->tgl_validasi) {
                $nama_barang .= ' (' . $inv->status . ' ' . Tanggal::tglIndo($inv->tgl_validasi) . ')';
                $warna = '255, 0, 0';
            }
        @endphp
        <tr style="color: rgb({{ $warna }})">
            @php
                $satuan_susut =
                    $inv->harsat > 0 && $inv->umur_ekonomis > 0
                        ? round(($inv->harsat * $inv->unit) / $inv->umur_ekonomis, 2)
                        : 0;
                $pakai_lalu = Inventaris::bulan($inv->tgl_beli, $tahun - 1 . '-12-31');
                $nilai_buku = Inventaris::nilaiBuku($tgl_kondisi, $inv);

                if (!($inv->status == 'Baik') && $tgl_kondisi >= $inv->tgl_validasi) {
                    $umur = Inventaris::bulan($inv->tgl_beli, $inv->tgl_validasi);
                } else {
                    $umur = Inventaris::bulan($inv->tgl_beli, $tgl_kondisi);
                }

                $_satuan_susut = $satuan_susut;
                if ($umur >= $inv->umur_ekonomis) {
                    $harga = $inv->harsat * $inv->unit;
                    $_susut = $satuan_susut * ($inv->umur_ekonomis - 1);
                    $satuan_susut = $harga - $_susut - 1;
                }

                $susut = $satuan_susut * $umur;
                if ($umur >= $inv->umur_ekonomis && $inv->harsat * $inv->unit > 0) {
                    $akum_umur = $inv->umur_ekonomis;
                    $_akum_susut = $inv->harsat * $inv->unit;
                    $akum_susut = $_akum_susut - 1;
                    $nilai_buku = 1;
                } else {
                    $akum_umur = $umur;
                    $akum_susut = $susut;

                    if ($nilai_buku < 0) {
                        $nilai_buku = 1;
                    }
                }

                $umur_pakai = $akum_umur - $pakai_lalu;
                $penyusutan = $satuan_susut * $umur_pakai;

                if (
                    ($inv->status == 'Hilang' and $tgl_kondisi >= $inv->tgl_validasi) ||
                    ($inv->status == 'Dijual' && $tgl_kondisi >= $inv->tgl_validasi) ||
                    ($inv->status == 'Hapus' && $tgl_kondisi >= $inv->tgl_validasi)
                ) {
                    $akum_susut = $inv->harsat * $inv->unit;
                    $nilai_buku = 0;
                    $penyusutan = 0;
                    $umur_pakai = 0;
                }

                if ($inv->status == 'Rusak' and $tgl_kondisi >= $inv->tgl_validasi) {
                    $akum_susut = $inv->harsat * $inv->unit - 1;
                    $nilai_buku = 1;
                    $penyusutan = 0;
                    $umur_pakai = 0;
                }

                if ($umur_pakai >= 0 && $inv->harsat * $inv->unit > 0) {
                    $penyusutan = $penyusutan;
                } else {
                    $umur_pakai = 0;
                    $penyusutan = 0;
                }

                if ($akum_umur == $inv->umur_ekonomis && $umur_pakai > '0') {
                    $penyusutan = $_satuan_susut * ($umur_pakai - 1) + $satuan_susut;
                }

                $t_unit += $inv->unit;
                $t_harga += $inv->harsat * $inv->unit;
                $t_penyusutan += $penyusutan;
                $t_akum_susut += $akum_susut;
                $t_nilai_buku += $nilai_buku;

                $tahun_validasi = substr($inv->tgl_validasi, 0, 4);
            @endphp

            @if ($nilai_buku == 0 && $tahun_validasi < $tahun)
                @php
                    $j_unit += $inv->unit;
                    $j_harga += $inv->harsat * $inv->unit;
                    $j_penyusutan += $penyusutan;
                    $j_akum_susut += $akum_susut;
                    $j_nilai_buku += $nilai_buku;
                @endphp
            @else
                <td class="t l b" align="center">{{ $no++ }}</td>
                <td class="t l b" align="center">{{ Tanggal::tglIndo($inv->tgl_beli) }}</td>
                <td class="t l b">{{ $nama_barang }}</td>
                <td class="t l b" align="center">{{ $inv->id }}</td>
                <td class="t l b" align="center">{{ $inv->status }}</td>
                <td class="t l b" align="center">{{ $inv->unit }}</td>
                <td class="t l b" align="right">{{ number_format($inv->harsat, 2) }}</td>
                <td class="t l b" align="right">{{ number_format($inv->harsat * $inv->unit, 2) }}</td>
                <td class="t l b" align="center">{{ $inv->umur_ekonomis }}</td>
                <td class="t l b" align="right">{{ number_format($_satuan_susut, 2) }}</td>
                <td class="t l b" align="center">{{ $umur_pakai }}</td>
                <td class="t l b" align="right">{{ number_format($penyusutan, 2) }}</td>
                <td class="t l b" align="center">{{ $akum_umur }}</td>
                <td class="t l b" align="right">{{ number_format($akum_susut, 2) }}</td>
                <td class="t l b r" align="right">{{ number_format($nilai_buku, 2) }}</td>
            @endif
        </tr>
    @endforeach
    <!-- Baris Jumlah -->
    <tr>
        <td class="t l b" height="15" colspan="5">
            Jumlah Daftar {{ $nama }} (Hapus, Hilang, Jual) s.d. Tahun {{ $tahun - 1 }}
        </td>
        <td class="t l b" align="center">{{ $j_unit }}</td>
        <td class="t l b">&nbsp;</td>
        <td class="t l b" align="right">{{ number_format($j_harga, 2) }}</td>
        <td class="t l b">&nbsp;</td>
        <td class="t l b">&nbsp;</td>
        <td class="t l b" align="right" colspan="2">{{ number_format($j_penyusutan, 2) }}</td>
        <td class="t l b" align="right" colspan="2">{{ number_format($j_akum_susut, 2) }}</td>
        <td class="t l b r" align="right">{{ number_format($j_nilai_buku, 2) }}</td>
    </tr>
    <tr style="background: rgb(167, 167, 167); font-weight: bold;">
    <tr style="background: rgb(242, 242, 242); font-weight: bold; border: 0.5px solid black;">

    <tr>
        <td colspan="15" style="padding: 0px !important">
            <table class="p" border="0" width="100%" cellspacing="0" cellpadding="0"
                style="font-size: 11px; table-layout: fixed;">
                <tr>
                    <td class="t l b" width="28%" height="15">
                        Jumlah
                    </td>
                    <td class="t l b" width="4%" align="center">{{ $t_unit }}</td>
                    <td class="t l b" width="8%">&nbsp;</td>
                    <td class="t l b" width="8%" align="right">{{ number_format($t_harga, 2) }}</td>
                    <td class="t l b" width="4%">&nbsp;</td>
                    <td class="t l b" width="8%">&nbsp;</td>
                    <td class="t l b" width="12%" align="right">{{ number_format($t_penyusutan, 2) }}
                    </td>
                    <td class="t l b" width="12%" align="right">{{ number_format($t_akum_susut, 2) }}
                    </td>
                    <td class="t l b r" width="8%" align="right">{{ number_format($t_nilai_buku, 2) }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
