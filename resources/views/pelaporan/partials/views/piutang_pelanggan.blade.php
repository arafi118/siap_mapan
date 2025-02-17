<style>
    * {
        font-family: 'Arial', sans-serif;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 11px;
        table-layout: fixed;
    }

    th,
    td {
        border: 1px solid black;
        padding: 5px;
    }

    th {
        background-color: rgb(232, 232, 232);
        font-weight: bold;
    }

    .header-table td {
        border: none;
    }

    .p th,
    .p td {
        border: 0.1px solid rgb(0, 0, 0);
    }
</style>
<title>{{ $title }}</title>
<table class="header-table" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
    <tr>
        <td colspan="3" align="center">
            <div style="font-size: 18px;">
                <b>Piutang Pelanggan</b>
            </div>
            <div style="font-size: 16px;">
                <b>{{ strtoupper($sub_judul) }}</b>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" height="10"></td>
    </tr>
</table>
<table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
    <tr style="background: rgb(230, 230, 230); font-weight: bold;">
        <th class="t l b" height="20" width="3%">No</th>
        <th class="t l b" height="20" width="10%">Nama</th>
        <th class="t l b" width="10%">Kode Instalasi</th>
        <th class="t l b" width="8%">Periode</th>
        <th class="t l b" width="8%">Tagihan</th>
        <th class="t l b" width="9%">Terbayar</th>
        <th class="t l b" width="9%">Menunggak</th>
    </tr>
    @php
        use Carbon\Carbon;
        $no = 1;
        $totalTagihan = 0;
        $totalTerbayar = 0;
        $totalMenunggak = 0;
    @endphp

    @foreach ($installations as $installation)
        @foreach ($installation->usage as $usage)
            @php
                $terbayar = $usage->transaction->sum('total');
                $menunggak = $usage->nominal - $terbayar;

                $totalTagihan += $usage->nominal;
                $totalTerbayar += $terbayar;
                $totalMenunggak += $menunggak;
            @endphp
            <tr>
                <td class="t l b" align="center">{{ $no++ }}</td>
                <td class="t l b" align="left">{{ $installation->customer->nama }}</td>
                <td class="t l b" align="center">{{ $installation->kode_instalasi }}</td>
                <td class="t l b" align="center">{{ Carbon::parse($usage->tgl_akhir)->translatedFormat('F Y') }}</td>
                <td class="t l b" align="right">{{ number_format($usage->nominal, 2) }}</td>
                <td class="t l b" align="right">{{ number_format($terbayar, 2) }}</td>
                <td class="t l b r" align="right">{{ number_format($menunggak, 2) }}</td>
            </tr>
        @endforeach
    @endforeach

    <tr style="font-weight: bold;">
        <td class="t l b" colspan="4" align="left">Jumlah </td>
        <td class="t l b" align="right">{{ number_format($totalTagihan, 2) }}</td>
        <td class="t l b" align="right">{{ number_format($totalTerbayar, 2) }}</td>
        <td class="t l b r" align="right">{{ number_format($totalMenunggak, 2) }}</td>
    </tr>
</table>
