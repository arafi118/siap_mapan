<style>
    * {
        font-family: 'Arial', sans-serif;
    }
</style>
<title>{{ $title }}</title>
<table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
    <tr>
        <td colspan="3" align="center">
            <div style="font-size: 18px;">
                <b>NERACA</b>
            </div>
            <div style="font-size: 16px;">
                <b>.......</b>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" height="5"></td>
    </tr>
</table>
<table border="0" width="100%" cellspacing="0" cellpadding="5" style="font-size: 12px; border-collapse: collapse; border: 0.5px solid black;">
    <tr style="background: rgb(230, 230, 230); font-weight: bold; border: 0.5px solid black;">
        <th rowspan="2" width="20%" style="border: 0.5px solid black;">Rekening</th>
        <th colspan="2" width="30%" style="border: 0.5px solid black;">Neraca Saldo</th>
        <th colspan="2" width="10%"style="border: 0.5px solid black;">Laba Rugi</th>
        <th colspan="2" width="30%"style="border: 0.5px solid black;">Neraca</th>
    </tr>
    <tr style="background: rgb(230, 230, 230); font-weight: bold; border: 0.5px solid black;">
        <th width="15%"style="border: 0.5px solid black;">Debit</th>
        <th width="15%"style="border: 0.5px solid black;">Kredit</th>
        <th width="15%"style="border: 0.5px solid black;">Debit</th>
        <th width="15%"style="border: 0.5px solid black;">Kredit</th>
        <th width="15%"style="border: 0.5px solid black;">Debit</th>
        <th width="15%"style="border: 0.5px solid black;">Kredit</th>
    </tr>
 @foreach ($accounts as $rek)
    @php
    $debit = 0;
    $kredit = 0;
    foreach ($rek->amount as $amount) {
        $debit += $amount->debit;
        $kredit += $amount->kredit;
    }

    $saldo_debit = 0;
    $saldo_kredit = $kredit - $debit;
    if ($rek->jenis_mutasi != 'kredit') {
        $saldo_debit = $debit - $kredit;
        $saldo_kredit = 0;
    }

    $saldo_neraca_debit = 0;
    $saldo_neraca_kredit = 0;
    if ($rek->lev1 <= '3') {
        $saldo_neraca_debit = $saldo_debit;
        $saldo_neraca_kredit = $saldo_kredit;
    } 
    
    $saldo_laba_rugi_debit = 0;
    $saldo_laba_rugi_kredit = 0;
    if ($rek->lev1 >= '4') {
        $saldo_laba_rugi_debit = $saldo_debit;
        $saldo_laba_rugi_kredit = $saldo_kredit;
    }
    
    @endphp
    <tr style="border: 0.5px solid black;">
        <td width="15%" align="left" style="border: 0.5px solid black; padding-left: 5px;">{{ $rek->kode_akun . '. ' . $rek->nama_akun }}</td>
        <td width="15%" align="right" style="border: 0.5px solid black;">{{ number_format($saldo_debit, 2) }}</td>
        <td width="15%" align="right" style="border: 0.5px solid black;">{{ number_format($saldo_kredit, 2) }}</td>
        <td width="15%" align="right" style="border: 0.5px solid black;">{{ number_format($saldo_laba_rugi_debit, 2) }}</td>
        <td width="15%" align="right" style="border: 0.5px solid black;">{{ number_format($saldo_laba_rugi_kredit, 2) }}</td>
        <td width="15%" align="right" style="border: 0.5px solid black;">{{ number_format($saldo_neraca_debit, 2) }}</td>
        <td width="15%" align="right" style="border: 0.5px solid black;">{{ number_format($saldo_neraca_kredit, 2) }}</td>
    </tr>
@endforeach
    <tr style="border: 0.5px solid black;">
        <td colspan="7" style="padding: 0px;">
            <table border="0" width="100%" cellspacing="0" cellpadding="5" style="font-size: 12px; border-collapse: collapse; border: 0.5px solid black;">
                <tr style="background: rgb(167, 167, 167); font-weight: bold;">
                    <td width="20%" align="center" style="border: 0.5px solid black;">Surplus/Defisit</td>
                    <td width="15%"style="border: 0.5px solid black; text-align: center;"></td>
                    <td width="15%"style="border: 0.5px solid black; text-align: center;"></td>
                    <td width="15%"align="right" style="border: 0.5px solid black;"></td>
                    <td width="15%"style="border: 0.5px solid black; text-align: center;"></td>
                    <td width="15%"style="border: 0.5px solid black; text-align: center;"></td>
                    <td width="15%"align="right" style="border: 0.5px solid black;"></td>
                </tr>
                <tr style="background: rgb(242, 242, 242); font-weight: bold; border: 0.5px solid black;">
                    <td width="15%"align="center" style="border: 0.5px solid black;">Jumlah</td>
                    <td width="15%"align="right" style="border: 0.5px solid black;">3</td>
                    <td width="15%"align="right" style="border: 0.5px solid black;">5</td>
                    <td width="15%"align="right" style="border: 0.5px solid black;">2</td>
                    <td width="15%"align="right" style="border: 0.5px solid black;">d</td>
                    <td width="15%"align="right" style="border: 0.5px solid black;">3</td>
                    <td width="15%"align="right" style="border: 0.5px solid black;">d</td>
                </tr>
            </table>
        </td>
    </tr>
</table>


