@include('pelaporan.layouts.style')
<title>{{ $title }}</title>

<table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
    <tr>
        <td colspan="3" align="center">
            <div style="font-size: 18px;">
                <b>NERACA TUTUP BUKU</b>
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
    <thead>
        <tr style="background: #000; color: #fff;">
            <td width="10%">Kode</td>
            <td width="70%">Nama Akun</td>
            <td align="right" width="20%">Saldo</td>
        </tr>
        <tr>
            <td colspan="3" height="3"></td>
        </tr>
    </thead>

    <tbody>
        @php
            $jumlah_liabilitas_equitas = 0;
        @endphp
        @foreach ($akun1 as $lev1)
            @php
                $saldo_akun = 0;
            @endphp
            <tr style="background: rgb(74, 74, 74); color: #fff;">
                <td style="height: 28px;" class="text-center" colspan="3">{{ $lev1->kode_akun }}.
                    {{ $lev1->nama_akun }}
                </td>
            </tr>

            @foreach ($lev1->akun2 as $lev2)
                <tr style="background: rgb(167, 167, 167); font-weight: bold;">
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

                            $sum_saldo += $saldo;
                        }

                        $saldo_akun += $sum_saldo;
                        if ($lev1->lev1 > 1) {
                            $jumlah_liabilitas_equitas += $sum_saldo;
                        }
                        $row_class = $loop->iteration % 2 === 0 ? 'row-black' : 'row-white';
                    @endphp
                    <tr class="{{ $row_class }}">
                        <td>&nbsp; {{ $lev3->kode_akun }}</td>
                        <td>{{ $lev3->nama_akun }}</td>
                        <td class="right-align">{{ number_format($sum_saldo, 2) }}&nbsp;</td>
                    </tr>
                @endforeach
            @endforeach

            <tr style="background: rgb(167, 167, 167); font-weight: bold;">
                <td colspan="2">&nbsp; Jumlah {{ $lev1->nama_akun }}</td>
                <td class="right-align">{{ number_format($saldo_akun, 2) }}&nbsp;</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="3" style="padding: 0px !important;">
                <table class="p" border="0" width="100%" cellspacing="0" cellpadding="0"
                    style="font-size: 12px;">
                    <tr style="background: rgb(167, 167, 167); font-weight: bold;">
                        <td height="15" width="80%" align="left">
                            <b>&nbsp; Jumlah Liabilitas + Ekuitas </b>
                        </td>
                        <td align="right" width="20%">{{ number_format($jumlah_liabilitas_equitas, 2) }}&nbsp;
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
