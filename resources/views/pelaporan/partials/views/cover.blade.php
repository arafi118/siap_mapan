<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{{ $title }}</title>
<style>
    * {
        font-family: 'Arial', sans-serif;

    }

    html {
        margin: 75.59px;
        margin-left: 94.48px;
    }

    body {
        width: 100%;
        height: fit-content;
        border: 1px solid #000;
        position: relative;
    }

    header {
        position: relative;
        top: 60px;
        text-align: center;
    }

    footer {
        position: absolute;
        bottom: 0px;
        width: 100%;
        border-top: 1px solid #000;
    }

    img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>
<body>

    <header>
        <h1 style="margin: 0px;">{{ strtoupper($judul) }}</h1>
        <div style="margin: 0px; font-size: 24px;">{{ strtoupper($sub_judul) }}</div>
    </header>

    <main>
        {{-- <img src="../storage/app/public/logo/{{ $logo }}" width="290" alt="{{ $logo }}"> --}}
    </main>

    <footer>
        <table width="100%" style="border: 0.1 solid black;">
            <tr style="border: 0.1 solid black;">
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
                    <div style="font-size: 10px; color: grey; margin-top: 10px;">
                        <i>Tahun {{ $tahun }}</i>
                    </div>
                </td>
            </tr>
        </table>
    </footer>
</body>
