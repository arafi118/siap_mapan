@php
    use App\Utils\Tanggal;
@endphp
<style>
    * {
        font-family: 'Arial', sans-serif;
    }

    html {
        margin-left: 40px;
        margin-right: 40px;
    }
</style>

<title>{{ $title }}</title>

<table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
    <tr>
        <td colspan="3" align="center">
            <div style="font-size: 18px;">
                <b>LAPORAN PENGGUNAAN DANA (E-BUDGETING)</b>
            </div>
            <div style="font-size: 16px;">
                <b style="text-transform: uppercase;">Triwulan Tahun Anggaran {{ $thn }}</b>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" height="5"></td>
    </tr>
</table>


<table border="1" width="100%" cellspacing="0" cellpadding="5"
    style="font-size: 12px; border-collapse: collapse; border: 1px solid black;">
    <tr style="background: rgb(232, 232, 232); font-weight: bold; font-size: 12px; border: 1px solid black;">
        <th rowspan="2" width="20%" style="border: 1px solid black;">Rekening</th>
        <th rowspan="2" width="10%" style="border: 1px solid black;">Komulatif Bulan Lalu</th>
        @foreach ($bulan_tampil as $bt)
            <th colspan="2" class="t l b" width="16%" height="16">
                {{ Tanggal::namaBulan(date('Y') . '-' . $bt . '-01') }}
            </th>
        @endforeach
        <th rowspan="2" width="10%" style="border: 1px solid black;">Total</th>
    </tr>
    <tr style="background: rgb(232, 232, 232); font-weight: bold; font-size: 12px; border: 1px solid black;">
        <th width="6%" style="border: 1px solid black;">Rencana</th>
        <th width="6%" style="border: 1px solid black;">Realisasi</th>
        <th width="6%" style="border: 1px solid black;">Rencana</th>
        <th width="6%" style="border: 1px solid black;">Realisasi</th>
        <th width="6%" style="border: 1px solid black;">Rencana</th>
        <th width="6%" style="border: 1px solid black;">Realisasi</th>
    </tr>

    @foreach ($e_budgeting as $eb)
        @if ($eb['is_header'])
            <tr style="background: rgb(200, 200, 200); font-weight: bold; border: 1px solid black;">
                <td colspan="9" align="left" style="border: 1px solid black;">
                    <b>{{ $eb['nama'] }}</b>
                </td>
            </tr>
        @else
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;">{{ $eb['nama'] }}</td>
                <td align="right" style="border: 1px solid black;">
                    {{ number_format($eb['komulatif'], 2) }}</td>
                <td align="right" style="border: 1px solid black;">
                    {{ number_format($eb['rencana1'], 2) }}</td>
                <td align="right" style="border: 1px solid black;">
                    {{ number_format($eb['realisasi1'], 2) }}</td>
                <td align="right" style="border: 1px solid black;">
                    {{ number_format($eb['rencana2'], 2) }}</td>
                <td align="right" style="border: 1px solid black;">
                    {{ number_format($eb['realisasi2'], 2) }}</td>
                <td align="right" style="border: 1px solid black;">
                    {{ number_format($eb['rencana3'], 2) }}</td>
                <td align="right" style="border: 1px solid black;">
                    {{ number_format($eb['realisasi3'], 2) }}</td>
                <td align="right" style="border: 1px solid black;">
                    {{ number_format($eb['total'], 2) }}
                </td>
            </tr>
        @endif
    @endforeach
</table>
