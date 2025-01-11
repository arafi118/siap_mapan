<title>{{ $title }}</title>
<style>
    .text-center {
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .left-align {
        text-align: left;
    }

    th {
        background-color: #000;
        color: #fff;
    }

    .header {
        font-size: 18px;
        text-align: center;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .sub-header {
        font-size: 16px;
        text-align: center;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .section-header {
        background-color: rgb(74, 74, 74);
        color: #fff;
        text-align: center;
        font-weight: bold;
    }

    .sub-section {
        background-color: rgb(167, 167, 167);
        font-weight: bold;
    }

    .row-light {
        background-color: rgb(230, 230, 230);
    }

    .row-dark {
        background-color: rgba(255, 255, 255);
    }

    .summary-row {
        font-weight: bold;
        background-color: rgb(167, 167, 167);
    }

    .right-align {
        text-align: right;
    }

</style>

<table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 13px;">
    <tr>
        <td colspan="3" align="center">
            <div style="font-size: 18px;">
                <b>NERACA</b>
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
<table>
    <tr>
        <th class="left-align" style="height: 20px;">Kode Akun</th>
        <th class="left-align" style="height: 20px;">Nama Akun</th>
        <th class="right-align" style="height: 20px;">Saldo</th>
    </tr>
    <tr>
        <td colspan="3" height="3"></td>
    </tr>

    @foreach ($akun1 as $lev1)
    <tr class="section-header">
        <td style="height: 28px;" class="text-center" colspan="3">{{ $lev1->kode_akun }}. {{ $lev1->nama_akun }}</td>
    </tr>
    @foreach ($lev1->akun2 as $lev2)
    <tr class="sub-section">
        <td>{{ $lev2->kode_akun }}</td>
        <td colspan="2">{{ $lev2->nama_akun }}</td>
    </tr>
    @foreach ($lev2->akun3 as $lev3)
    @php
    $sum_saldo = 0;
    foreach ($lev3->accounts as $account) {
    $saldo_debit = 0;
    $saldo_kredit = 0;
    foreach ($account->amount as $amount) {
    $saldo_debit += $amount->debit;
    $saldo_kredit += $amount->kredit;
    }

    $saldo = $saldo_kredit - $saldo_debit;
    if ($lev1->lev1 == '1') {
    $saldo = $saldo_debit - $saldo_kredit;
    }

    $sum_saldo += $saldo;
    }

    $row_class = $loop->iteration % 2 === 0 ? 'row-dark' : 'row-light';
    @endphp
    <tr class="{{ $row_class }}">
        <td>{{ $lev3->kode_akun }}</td>
        <td>{{ $lev3->nama_akun }}</td>
        <td class="right-align">{{ number_format($sum_saldo, 2) }}</td>
    </tr>
    @endforeach
    @endforeach
    <tr class="summary-row">
        <td colspan="2">Jumlah {{ $lev1->nama_akun }}</td>
        <td class="right-align">{{ number_format($sum_saldo, 2) }}</td>
    </tr>
    @endforeach
</table>
