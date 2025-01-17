<title>{{ $title }}</title>
<style>
     * {
        font-family: 'Arial', sans-serif;

    }
    /* Gaya umum untuk tabel */
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px; /* Ukuran font default */
    }

    table th, table td {
        border: 0px solid #000;
        padding: 8px;
    }

    table th {
        background-color: #5c5c5c;
    }

    /* Gaya untuk warna putih */
    .row-white {
        background-color: #ffffff;
        color: #000;
    }

    /* Gaya untuk warna hitam */
    .row-black {
        background-color: #e0e0e0;
        color: #000;
    }
    .table-header {
        color: white;
    }
</style>

<table>
    <tr>
        <td colspan="7" align="center">
            <div style="font-size: 18px;">
                <b>JURNAL TRANSAKSI</b>
            </div>
            <div style="font-size: 16px;">
                <b>{{ strtoupper($sub_judul) }}</b>
            </div>
        </td>
    </tr>
</table>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <th width="5%" class="table-header">No</th>
        <th width="10%" class="table-header">Tanggal</th>
        <th width="8%" class="table-header">Ref ID</th>
        <th width="8%" class="table-header">Kd. Rek</th>
        <th width="35%" class="table-header">Keterangan</th>
        <th width="15%" class="table-header">Debit</th>
        <th width="15%" class="table-header">Kredit</th>
        <th width="5%" class="table-header">Ins</th>
    </tr>    
    @foreach ($transactions as $transaction)
        @php
            $rowClass = $loop->iteration % 2 == 0 ? 'row-black' : 'row-white';
        @endphp
        <tr class="{{ $rowClass }}">
            <td rowspan="2" align="center">{{ $loop->iteration }}</td> <!-- Cetak nomor -->
            <td rowspan="2" align="center">{{ $transaction->tgl_transaksi }}</td>
            <td rowspan="2" align="left">{{ $transaction->id }}</td>
            <td align="center">{{ $transaction->acc_debit->kode_akun }}</td>
            <td align="left">{{ $transaction->acc_debit->nama_akun }}</td>
            <td align="right">{{ number_format($transaction->total, 2, ',', '.') }}</td>
            <td align="right">0</td>
            <td rowspan="2" align="center">&nbsp;</td>
        </tr>
        <tr class="{{ $rowClass }}">
            <td align="center">{{ $transaction->acc_kredit->kode_akun }}</td>
            <td align="left">{{ $transaction->acc_kredit->nama_akun }}</td>
            <td align="right">0</td>
            <td align="right">{{ number_format($transaction->total, 2, ',', '.') }}</td>
        </tr>
    @endforeach
</table>

