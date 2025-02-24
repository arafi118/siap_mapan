<title>{{ $title }}</title>
<style>
    * {
        font-family: 'Arial', sans-serif;
    }
</style>
<table width="100%" align="center" style="border-bottom: 1px double #000; border-width: 4px;">
    <tr>
        {{-- <td width="70">
           <img src="../storage/app/public/logo/{{ $logo }}" height="70"
                alt="{{ $kec->id }}"> 
        </td> --}}
        <td align="center">
            <div>{{ strtoupper($nama) }}</div>
            <div>
                <b>{{ strtoupper($alamat) }}</b>
            </div>
            <div style="font-size: 10px; color: grey;">
                <i>{{ $nomor_usaha }}</i>
            </div>
            <div style="font-size: 10px; color: grey;">
                <i>{{ $info }}</i>
            </div>
            <div style="font-size: 10px; color: grey;">
                <i>{{ $email }}</i>
            </div>
        </td>
    </tr>
</table>
<table border="0"style="font-size: 12px;">
    <tr>
        <td width="5%">Nomor</td>
        <td width="50%">: ______________________</td>
        <td width="45%" align="right">{{ $alamat }}, {{ $tgl }}</td>
    </tr>
    <tr>
        <td>Lampiran</td>
        <td>: 1 Bendel</td>
    </tr>
    <tr>
        <td>Perihal</td>
        <td>: Laporan Keuangan</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td style="padding-left: 8px;">
            &nbsp; <u>Sampai Dengan {{ $sub_judul }}</u>
        </td>
    </tr>
    <tr>
        <td colspan="3" height="15"></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="2" align="left" style="padding-left: 8px;">
            <div><b>Kepada Yth.</b></div>
            <div><b>Kepala Dinas PMD </b></div>
            <div><b></b></div>
        </td>
    </tr>
    <tr>
        <td colspan="3" height="15"></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="2" style="padding-left: 8px; text-align: justify;">
            <div>Dengan Hormat,</div>
            <div>
                Bersama ini kami sampaikan Laporan Keuangan {{ $nama }} sampai dengan
                {{ $sub_judul }} sebagai berikut:
                <ol>
                    <li>Laporan Neraca</li>
                    <li>Laporan Rugi/Laba</li>
                    <li>Laporan Arus Kas</li>
                    <li>Laporan Perubahan Modal</li>
                    <li>Catatan Atas Laporan Keuangan (CALK)</li>
                </ol>
            </div>
            <div>
                Demikian laporan kami sampaikan, atas perhatiannya kami ucapkan terima kasih.
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" height="15"></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td align="center">
            <div>......</div>
            <div>......</div>
            <br>
            <br>
            <br>
            <br>
            <div>
                <b>...</b>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <div>
                Tembusan :
                <ol>
                    <li>Arsip</li>
                </ol>
            </div>
        </td>
    </tr>
</table>
