@php
    use App\Utils\Tanggal;
    use App\Utils\Inventaris;
@endphp

<!-- Header Judul -->
<table class="header-table" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
    <tr>
        <td colspan="3" align="center">
            <div style="font-size: 18px; font-weight: bold;">Daftar {{ $nama }}</div>
            <div style="font-size: 16px; font-weight: bold;">{{ strtoupper($sub_judul) }}</div>
        </td>
    </tr>
    <tr>
        <td colspan="3" height="10"></td>
    </tr>
</table>
<!-- Tabel Utama -->
<table border="0" width="100%" cellspacing="0" cellpadding="0"
    style="font-size: 12px; table-layout: fixed; border-collapse: collapse; width: 100%;">
    <!-- Header -->
    <tr style="background: rgb(232, 232, 232); font-weight: bold; text-align: center;">
        <th rowspan="2" width="3%" style="border: 1px solid black; padding: 5px;">No</th>
        <th rowspan="2" width="8%" style="border: 1px solid black; padding: 5px;">Tgl Beli</th>
        <th rowspan="2" width="20%" style="border: 1px solid black; padding: 5px;">Nama Barang</th>
        <th rowspan="2" width="3%" style="border: 1px solid black; padding: 5px;">Id</th>
        <th rowspan="2" width="6%" style="border: 1px solid black; padding: 5px;">Kondisi</th>
        <th rowspan="2" width="3%" style="border: 1px solid black; padding: 5px;">Unit</th>
        <th rowspan="2" width="9%" style="border: 1px solid black; padding: 5px;">Harga Satuan</th>
        <th rowspan="2" width="9%" style="border: 1px solid black; padding: 5px;">Harga Perolehan</th>
        <th rowspan="2" width="4%" style="border: 1px solid black; padding: 5px;">Umur Eko.</th>
        <th rowspan="2" width="8%" style="border: 1px solid black; padding: 5px;">Amortisasi</th>
        <th colspan="2" width="12%" style="border: 1px solid black; padding: 5px;">Tahun Ini</th>
        <th colspan="2" width="12%" style="border: 1px solid black; padding: 5px;">s.d. Tahun Ini</th>
        <th rowspan="2" width="8%" style="border: 1px solid black; padding: 5px;">Nilai Buku</th>
    </tr>
    <tr style="background: rgb(232, 232, 232); text-align: center; font-weight: bold;">
        <th width="4%" style="border: 1px solid black; padding: 5px;">Umur</th>
        <th width="8%" style="border: 1px solid black; padding: 5px;">Biaya</th>
        <th width="4%" style="border: 1px solid black; padding: 5px;">Umur</th>
        <th width="8%" style="border: 1px solid black; padding: 5px;">Biaya</th>
    </tr>
    <!-- Baris Data -->

    @php
        $t_unit = 0;
        $t_harga = 0;
        $t_penyusutan = 0;
        $t_akum_susut = 0;
        $t_nilai_buku = 0;
    @endphp
    @foreach ($Inventory as $inv)
        @php
            $nama_barang = $inv->nama_barang;
            $warna = '0, 0, 0';
            if (!($inv->status == 'Baik') && $tgl_kondisi >= $inv->tgl_validasi) {
                $nama_barang .= ' (' . $inv->status . ' ' . Tanggal::tglIndo($inv->tgl_validasi) . ')';
                $warna = '255, 0, 0';
            }

            $satuan_susut = $inv->harsat <= 0 ? 0 : round(($inv->harsat * $inv->unit) / $inv->umur_ekonomis, 2);
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
                $nilai_buku = 0;
            } else {
                $akum_umur = $umur;
                $akum_susut = $susut;

                if ($nilai_buku < 0) {
                    $nilai_buku = 0;
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
                $nilai_buku = 0;
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

        <tr style="color: rgb({{ $warna }});">
            <td style="border: 1px solid black; padding: 5px;" align="center">{{ $loop->iteration }}</td>
            <td style="border: 1px solid black; padding: 5px;" align="center">{{ Tanggal::tglIndo($inv->tgl_beli) }}
            </td>
            <td style="border: 1px solid black; padding: 5px;">{{ $nama_barang }}</td>
            <td style="border: 1px solid black; padding: 5px;" align="center">{{ $inv->id }}</td>
            <td style="border: 1px solid black; padding: 5px;" align="center">{{ $inv->status }}</td>
            <td style="border: 1px solid black; padding: 5px;" align="center">{{ $inv->unit }}</td>
            <td style="border: 1px solid black; padding: 5px;" align="right">{{ number_format($inv->harsat, 2) }}</td>
            <td style="border: 1px solid black; padding: 5px;" align="right">
                {{ number_format($inv->harsat * $inv->unit, 2) }}</td>
            <td style="border: 1px solid black; padding: 5px;" align="center">{{ $inv->umur_ekonomis }}</td>
            <td style="border: 1px solid black; padding: 5px;" align="right">{{ number_format($satuan_susut, 2) }}
            </td>
            <td style="border: 1px solid black; padding: 5px;" align="center">{{ $umur_pakai }}</td>
            <td style="border: 1px solid black; padding: 5px;" align="right">{{ number_format($penyusutan, 2) }}</td>
            <td style="border: 1px solid black; padding: 5px;" align="center">{{ $akum_umur }}</td>
            <td style="border: 1px solid black; padding: 5px;" align="right">{{ number_format($akum_susut, 2) }}</td>
            <td style="border: 1px solid black; padding: 5px;" align="right">{{ number_format($nilai_buku, 2) }}</td>
        </tr>
    @endforeach

    <!-- Baris Jumlah -->

    <tr>
        <td colspan="15" style="padding: 0px !important">
            <table class="p" border="0" width="100%" cellspacing="0" cellpadding="0"
                style="font-size: 10px; table-layout: fixed;">
                <tr>
                    <td class="t l b" width="40%" height="15">
                        Jumlah
                    </td>
                    <td class="t l b" width="3%" align="center">{{ number_format($t_unit, 2) }}</td>
                    <td class="t l b" width="9%">&nbsp;</td>
                    <td class="t l b" width="9%" align="right">{{ number_format($t_harga, 2) }}</td>
                    <td class="t l b" width="4%">&nbsp;</td>
                    <td class="t l b" width="8%">&nbsp;</td>
                    <td class="t l b" width="12%" align="right">
                        {{ number_format($t_penyusutan, 2) }}
                    </td>
                    <td class="t l b" width="12%" align="right">
                        {{ number_format($t_akum_susut, 2) }}
                    </td>
                    <td class="t l b r" width="8%" align="right">
                        {{ number_format($t_nilai_buku, 2) }}
                    </td>
                </tr>

                {{-- <tr>
                    <td colspan="9">
                        <div style="margin-top: 16px;"></div>
                        {!! json_decode(str_replace('{tanggal}', $tanggal_kondisi, $kec->ttd->tanda_tangan_pelaporan), true) !!}
                    </td>
                </tr> --}}
            </table>
        </td>
    </tr>
</table>
