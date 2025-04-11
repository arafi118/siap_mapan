<style>
    * {
        font-family: 'Arial', sans-serif;
    }
</style>

@if ($laporan == 'surat_pengantar')
    <table width="100%">
        <tr>
            <td width="70">
                <img src="{{ asset('storage/logo/' . $logo) }}" height="70" alt="{{ $logo }}">
            </td>
            <td align="center">
                <div><b>{{ strtoupper($nama) }}</b></div>
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
@else
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td width="50">
                <img src="{{ asset('storage/logo/' . $logo) }}" height="50" alt="{{ $logo }}">
            </td>
            <td>
                <div style="font-size: 12px;">{{ strtoupper($nama) }}</div>
                <div style="font-size: 12px;">
                    <b>{{ strtoupper($alamat) }}</b>
                </div>
                <div style="font-size: 8px; color: grey;">
                    <i>{{ $nomor_usaha }}</i>
                </div>
                <div style="font-size: 8px; color: grey;">
                    <i>{{ $info }}</i>
                </div>
            </td>
        </tr>
    </table>
@endif
