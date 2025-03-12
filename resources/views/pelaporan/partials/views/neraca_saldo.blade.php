<style>
    * {
        font-family: 'Arial', sans-serif;
    }
</style>
<title>{{ $title }}</title>
@extends('pelaporan.layouts.base')

@section('content')
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
        <tr>
            <td colspan="3" align="center">
                <div style="font-size: 18px;">
                    <b>NERACA SALDO</b>
                </div>
                <div style="font-size: 16px;">
                    <b>{{ strtoupper($sub_judul) }}</b>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="5"></td>
        </tr>
    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="5"
        style="font-size: 12px; border-collapse: collapse; border: 0.5px solid black;">
        <tr style="background: rgb(230, 230, 230); font-weight: bold;">
            <th rowspan="2" width="40%" style="border: 0.5px solid black;">Rekening</th>
            <th colspan="2" width="20%" style="border: 0.5px solid black;">Neraca Saldo</th>
            <th colspan="2" width="10%" style="border: 0.5px solid black;">Laba Rugi</th>
            <th colspan="2" width="20%" style="border: 0.5px solid black;">Neraca</th>
        </tr>
        <tr style="background: rgb(230, 230, 230); font-weight: bold;">
            <th width="15%" style="border: 0.5px solid black;">Debit</th>
            <th width="15%" style="border: 0.5px solid black;">Kredit</th>
            <th width="15%" style="border: 0.5px solid black;">Debit</th>
            <th width="15%" style="border: 0.5px solid black;">Kredit</th>
            <th width="15%" style="border: 0.5px solid black;">Debit</th>
            <th width="15%" style="border: 0.5px solid black;">Kredit</th>
        </tr>

        @php
            // Inisialisasi total
            $jumlah_saldo_debit = 0;
            $jumlah_saldo_kredit = 0;
            $jumlah_saldo_laba_rugi_debit = 0;
            $jumlah_saldo_laba_rugi_kredit = 0;
            $jumlah_saldo_neraca_debit = 0;
            $jumlah_saldo_neraca_kredit = 0;
            $saldo_pendapatan = 0;
            $saldo_beban = 0;
        @endphp

        @foreach ($accounts as $rek)
            @php
                $debit = 0;
                $kredit = 0;
                foreach ($rek->amount as $amount) {
                    $debit += $amount->debit;
                    $kredit += $amount->kredit;
                }

                // Hitung saldo debit/kredit
                $saldo_debit = 0;
                $saldo_kredit = $kredit - $debit;
                if ($rek->jenis_mutasi != 'kredit') {
                    $saldo_debit = $debit - $kredit;
                    $saldo_kredit = 0;
                }

                // Hitung saldo neraca dan laba rugi
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

                // Akumulasi pendapatan dan beban
                if ($rek->lev1 == '4') {
                    $saldo_pendapatan += $rek->jenis_mutasi == 'kredit' ? $saldo_kredit : $saldo_debit;
                }
                if ($rek->lev1 == '5') {
                    $saldo_beban += $rek->jenis_mutasi == 'kredit' ? $saldo_kredit : $saldo_debit;
                }

                // Tambahkan ke total jumlah
                $jumlah_saldo_debit += $saldo_debit;
                $jumlah_saldo_kredit += $saldo_kredit;
                $jumlah_saldo_laba_rugi_debit += $saldo_laba_rugi_debit;
                $jumlah_saldo_laba_rugi_kredit += $saldo_laba_rugi_kredit;
                $jumlah_saldo_neraca_debit += $saldo_neraca_debit;
                $jumlah_saldo_neraca_kredit += $saldo_neraca_kredit;
            @endphp
            <tr style="border: 0.5px solid black;">
                <td width="15%" align="left" style="border: 0.5px solid black; padding-left: 5px;">
                    <strong>{{ $rek->kode_akun . '. ' . $rek->nama_akun }}</strong>
                </td>
                <td width="15%" align="right" style="border: 0.5px solid black;">{{ number_format($saldo_debit, 2) }}
                </td>
                <td width="15%" align="right" style="border: 0.5px solid black;">{{ number_format($saldo_kredit, 2) }}
                </td>
                <td width="15%" align="right" style="border: 0.5px solid black;">
                    {{ number_format($saldo_laba_rugi_debit, 2) }}</td>
                <td width="15%" align="right" style="border: 0.5px solid black;">
                    {{ number_format($saldo_laba_rugi_kredit, 2) }}</td>
                <td width="15%" align="right" style="border: 0.5px solid black;">
                    {{ number_format($saldo_neraca_debit, 2) }}</td>
                <td width="15%" align="right" style="border: 0.5px solid black;">
                    {{ number_format($saldo_neraca_kredit, 2) }}</td>
            </tr>
        @endforeach

        @php
            // Hitung surplus/defisit
            $surplus_defisit = $saldo_pendapatan - $saldo_beban;
        @endphp
    </table>

    <!-- Tabel Total -->
    <table border="0" width="100%" cellspacing="0" cellpadding="5"
        style="font-size: 12px; border-collapse: collapse; border: 0.5px solid black;">
        <tr style="background: rgb(167, 167, 167); font-weight: bold;">
            <td width="40%" align="center" style="border: 0.5px solid black;">Surplus/Defisit</td>
            <td width="15%"style="border: 0.5px solid black; text-align: center;"></td>
            <td width="15%"style="border: 0.5px solid black; text-align: center;"></td>
            <td width="15%"align="right" style="border: 0.5px solid black;">
                {{ number_format($surplus_defisit, 2) }}
            </td>
            <td width="15%"style="border: 0.5px solid black; text-align: center;"></td>
            <td width="15%"style="border: 0.5px solid black; text-align: center;"></td>
            <td width="15%"align="right" style="border: 0.5px solid black;">
                {{ number_format($surplus_defisit, 2) }}
            </td>
        </tr>
        <tr style="background: rgb(242, 242, 242); font-weight: bold; border: 0.5px solid black;">
            <td width="40%" align="center" style="border: 0.5px solid black;">Jumlah</td>
            <td width="15%" align="right" style="border: 0.5px solid black;">
                {{ number_format($jumlah_saldo_debit, 2) }}</td>
            <td width="15%" align="right" style="border: 0.5px solid black;">
                {{ number_format($jumlah_saldo_kredit, 2) }}</td>
            <td width="15%" align="right" style="border: 0.5px solid black;">
                {{ number_format($jumlah_saldo_laba_rugi_debit + $surplus_defisit, 2) }}</td>
            <td width="15%" align="right" style="border: 0.5px solid black;">
                {{ number_format($jumlah_saldo_laba_rugi_kredit, 2) }}</td>
            <td width="15%" align="right" style="border: 0.5px solid black;">
                {{ number_format($jumlah_saldo_neraca_debit, 2) }}</td>
            <td width="15%" align="right" style="border: 0.5px solid black;">
                {{ number_format($jumlah_saldo_neraca_kredit + $surplus_defisit, 2) }}</td>
        </tr>
    </table>
@endsection
