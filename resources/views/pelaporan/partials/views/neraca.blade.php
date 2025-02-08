<title>{{ $title }}</title>
<style>
    * {
        font-family: 'Arial', sans-serif;
    }

    .text-center {
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
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

<table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
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
        <th class="left-align" style="height: 20px;">&nbsp;Kode</th>
        <th class="left-align" style="height: 20px;">Nama Akun</th>
        <th class="right-align" style="height: 20px;">Saldo &nbsp;</th>
    </tr>
    <tr>
        <td colspan="3" height="3"></td>
    </tr>

    @php
        $jumlah_liabilitas_equitas = 0;
    @endphp
    @foreach ($akun1 as $lev1)
        @php
            $saldo_akun = 0;
        @endphp
        <tr class="section-header">
            <td style="height: 28px;" class="text-center" colspan="3">{{ $lev1->kode_akun }}. {{ $lev1->nama_akun }}
            </td>
        </tr>

        @foreach ($lev1->akun2 as $lev2)
            <tr class="sub-section">
                <td>&nbsp; {{ $lev2->kode_akun }}</td>
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

                        if ($account->kode_akun == '3.2.02.01') {
                            $saldo = $surplus;
                        }

                        $sum_saldo += $saldo;
                    }

                    $saldo_akun += $sum_saldo;
                    if ($lev1->lev1 > 1) {
                        $jumlah_liabilitas_equitas += $sum_saldo;
                    }
                    $row_class = $loop->iteration % 2 === 0 ? 'row-dark' : 'row-light';
                @endphp
                <tr class="{{ $row_class }}">
                    <td>&nbsp; {{ $lev3->kode_akun }}</td>
                    <td>{{ $lev3->nama_akun }}</td>
                    <td class="right-align">{{ number_format($sum_saldo, 2) }}&nbsp;</td>
                </tr>
            @endforeach
        @endforeach

        <tr class="summary-row">
            <td colspan="2">&nbsp; Jumlah {{ $lev1->nama_akun }}</td>
            <td class="right-align">{{ number_format($saldo_akun, 2) }}&nbsp;</td>
        </tr>
    @endforeach

    <tr>
        <td colspan="3" style="padding: 0px !important;">
            <table class="p" border="0" width="100%" cellspacing="0" cellpadding="0"
                style="font-size: 12px;">
                <tr style="background: rgb(187, 187, 187); font-weight: bold;">
                    <td height="15" width="80%" align="left">
                        <b>&nbsp; Jumlah Liabilitas + Ekuitas </b>
                    </td>
                    <td align="right" width="20%">{{ number_format($jumlah_liabilitas_equitas, 2) }}&nbsp; </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
