<title>{{ $title }}</title>
<table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 13px;">
    <tr>
        <td colspan="3" align="center">
            <div style="font-size: 18px;">
                <b>ARUS KAS</b>
            </div>
            <div style="font-size: 16px;">
                <b>....</b>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" height="5"></td>
    </tr>

</table>
<table border="1" width="100%">
    <tr>
        <td colspan="2"align="center">Nama Akun</td>
        <td align="center" width="40%">Jumlah</td>
    </tr>

    @foreach ($arus_kas as $ak)
        <tr>
            <td align="center">{{ $ak->id }}</td>
            <td align="left">{{ $ak->nama_akun }}</td>
            <td align="center"></td>
        </tr>

        @foreach ($ak->child as $child)
            @php
                if ($child->rek_kredit) {
                    $nama_akun = $child->rek_kredit->nama_akun;

                    // 
                } else {
                    $nama_akun = $child->rek_debit->nama_akun;

                    // 
                }
            @endphp
            <tr>
                <td align="center"></td>
                <td align="left">{{ $nama_akun }}</td>
                <td align="center"></td>
            </tr>
        @endforeach
    @endforeach
</table>