<title>{{ $title }}</title>
<style>
    * {
        font-family: 'Arial', sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    table th,
    table td {
        padding: 5px;
    }

    table th {
        background-color: #5c5c5c;
        color: white;
    }

    .row-white {
        background-color: #ffffff;
        color: #000;
    }

    .row-black {
        background-color: #e0e0e0;
        color: #000;
    }

    /* Hindari penggunaan terlalu banyak border */
    .borderless td,
    .borderless th {
        border: none;
    }

    /* Tambahkan untuk menghindari error saat banyak data */
    .page-break {
        page-break-before: always;
    }
</style>

@extends('pelaporan.layouts.base')

@section('content')
    <table>
        <tr>
            <td colspan="7" align="center">
                <div style="font-size: 18px;"><b>JURNAL TRANSAKSI</b></div>
                <div style="font-size: 16px;"><b>{{ strtoupper($sub_judul) }}</b></div>
            </td>
        </tr>
    </table>

    <table class="borderless" width="100%">
        <tr>
            <th width="5%">No</th>
            <th width="10%">Tanggal</th>
            <th width="8%">Ref ID</th>
            <th width="8%">Kd. Rek</th>
            <th width="35%">Keterangan</th>
            <th width="15%">Debit</th>
            <th width="15%">Kredit</th>
            <th width="5%">Ins</th>
        </tr>
        @php
            $totalDebit = 0;
            $totalKredit = 0;
            $counter = 1;
        @endphp
        @foreach ($transactions as $index => $transaction)
            @php
                $rowClass = $counter % 2 == 0 ? 'row-black' : 'row-white';
            @endphp
            <tr class="{{ $rowClass }}">
                <td>{{ $counter++ }}</td>
                <td>{{ $transaction->tgl_transaksi }}</td>
                <td>{{ $transaction->ref_id }}</td>
                <td>{{ $transaction->kode_rek }}</td>
                <td>{{ $transaction->keterangan }}</td>
                <td align="right">{{ number_format($transaction->debit, 2, ',', '.') }}</td>
                <td align="right">{{ number_format($transaction->kredit, 2, ',', '.') }}</td>
                <td>{{ $transaction->ins }}</td>
            </tr>
            @php
                $totalDebit += $transaction->debit;
                $totalKredit += $transaction->kredit;
            @endphp
        @endforeach

        <tr style="background-color: #d3d3d3;">
            <td colspan="5" align="center"><strong>Total</strong></td>
            <td align="right"><strong>{{ number_format($totalDebit, 2, ',', '.') }}</strong></td>
            <td align="right"><strong>{{ number_format($totalKredit, 2, ',', '.') }}</strong></td>
            <td></td>
        </tr>
    </table>
@endsection
