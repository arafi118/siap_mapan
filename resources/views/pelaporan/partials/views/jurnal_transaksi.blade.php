@php
    use App\Utils\Tanggal;
@endphp

@include('pelaporan.layouts.style')
<title>{{ $title }}</title>

<table>
    <tr>
        <td colspan="7" align="center">
            <div style="font-size: 18px;"><b>JURNAL TRANSAKSI</b></div>
            <div style="font-size: 16px;"><b>{{ strtoupper($sub_judul) }}</b></div>
        </td>
    </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
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
    </thead>

    <tbody>
        @php
            $totalDebit = 0;
            $totalKredit = 0;
        @endphp
        @foreach ($transactions as $transaction)
            @php
                $rowClass = $transaction['nomor'] % 2 == 0 ? 'row-black' : 'row-white';
            @endphp
            <tr class="{{ $rowClass }}">
                <td>{{ $transaction['nomor'] }}</td>
                <td>{{ Tanggal::tglIndo($transaction['tgl_transaksi']) }}</td>
                <td>{{ $transaction['id'] }}</td>

                <td>{{ $transaction['kode_akun'] }}</td>
                <td>{{ $transaction['nama_akun'] }}</td>
                <td align="right">{{ number_format($transaction['jumlah'], 2, ',', '.') }}</td>
                <td align="right">{{ number_format(0, 2, ',', '.') }}</td>

                <td>{{ $transaction['ins'] }}</td>
            </tr>

            @foreach ($transaction['trx_kredit'] as $trx_kredit)
                <tr class="{{ $rowClass }}">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>

                    <td>{{ $trx_kredit['kode_akun'] }}</td>
                    <td>{{ $trx_kredit['nama_akun'] }}</td>
                    <td align="right">{{ number_format(0, 2, ',', '.') }}</td>
                    <td align="right">{{ number_format($trx_kredit['jumlah'], 2, ',', '.') }}</td>

                    <td>&nbsp;</td>
                </tr>
            @endforeach

            @php
                $totalDebit += $transaction['jumlah'];
                $totalKredit += $transaction['jumlah'];
            @endphp
        @endforeach

        <tr style="background-color: #d3d3d3;">
            <td colspan="5" align="center"><strong>Total</strong></td>
            <td align="right"><strong>{{ number_format($totalDebit, 2, ',', '.') }}</strong></td>
            <td align="right"><strong>{{ number_format($totalKredit, 2, ',', '.') }}</strong></td>
            <td></td>
        </tr>
    </tbody>
</table>
