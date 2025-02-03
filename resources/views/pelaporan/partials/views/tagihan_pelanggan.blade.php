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
                <b>Tagihan Pelanggan</b>
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
        <th class="t l b" width="8%">Desa</th>
        <th class="t l b" width="10%">Kode Instalasi</th>
        <th class="t l b" width="8%">Pemakaian</th>
        <th class="t l b" width="8%">Tagih</th>
        <th class="t l b" width="9%">Status</th>
        <th class="t l b" width="9%">Pembayaran</th>
    </tr>
    @php
        $totalPemakaian = 0;
        $totalTagih = 0;
        $totalPembayaran = 0;
        $no = 1;
    @endphp
    @foreach ($usages as $usage)
        @php
            $pemakaian = $usage->jumlah;
            $tagih = $usage->nominal;
            $pembayaran = $usage->transaction->sum('total');
            $totalPemakaian += $pemakaian;
            $totalTagih += $tagih;
            $totalPembayaran += $pembayaran;
        @endphp
        <tr>
            <td class="t l b" align="center">{{ $no++ }}</td>
            <td class="t l b" align="left">{{ $usage->customers->nama }}</td>
            <td class="t l b" align="left">{{ $usage->customers->village ? $usage->customers->village->nama : '' }}
            </td>
            <td class="t l b" align="center">{{ $usage->installation->kode_instalasi }}</td>
            <td class="t l b" align="center">{{ $pemakaian }}</td>
            <td class="t l b" align="right">{{ number_format($tagih, 2) }}</td>
            <td class="t l b" align="center">{{ $usage->status }}</td>
            <td class="t l b r" align="right">{{ number_format($pembayaran, 2) }}</td>
        </tr>
    @endforeach
    <tr style="font-weight: bold;">
        <td class="t l b" colspan="4">Jumlah</td>
        <td class="t l b" align="center">{{ $totalPemakaian }}</td>
        <td class="t l b" align="right">{{ number_format($totalTagih, 2) }}</td>
        <td class="t l b" align="center"></td>
        <td class="t l b r" align="right">{{ number_format($totalPembayaran, 2) }}</td>
    </tr>
</table>
