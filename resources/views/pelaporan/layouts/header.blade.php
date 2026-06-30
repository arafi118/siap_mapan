<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
        * {
            font-family: 'Arial', sans-serif;
        }
    </style>
</head>

<body>

    @if ($laporan == 'surat_pengantar')
        <table width="100%">
            <tr>
                <td width="70">
                    @if($logo)
                        <img src="data:image/png;base64,{{ $logo }}" height="70" alt="Logo">
                    @else
                        <div style="width:70px;height:70px;border:1px solid #ccc;display:flex;align-items:center;justify-content:center;font-size:10px;color:#999;">Logo</div>
                    @endif
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
                    @if($logo)
                        <img src="data:image/png;base64,{{ $logo }}" height="50" alt="Logo">
                    @else
                        <div style="width:50px;height:50px;border:1px solid #ccc;display:flex;align-items:center;justify-content:center;font-size:9px;color:#999;">Logo</div>
                    @endif
                </td>
                <td>
                    <div style="font-size: 12px;"><b>{{ strtoupper($nama) }}</b></div>
                    <div style="font-size: 12px;">
                        {{ strtoupper($alamat) }}
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

</body>

</html>
