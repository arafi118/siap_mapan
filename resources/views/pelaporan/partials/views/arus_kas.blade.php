@php
    use App\Utils\Keuangan;
    $keuangan = new Keuangan();
@endphp

<style>
    * {
        font-family: 'Arial', sans-serif;
    }

    .bg-red {
        background-color: rgb(235, 235, 235);
    }

    .bg-white {
        background-color: rgb(197, 197, 197);
    }
</style>

<title>{{ $title }}</title>
@extends('pelaporan.layouts.base')

@section('content')
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
        <tr>
            <td colspan="3" align="center">
                <div style="font-size: 18px;">
                    <b>ARUS KAS</b>
                </div>
                <div style="font-size: 16px;">
                    <b>{{ strtoupper($sub_judul) }}</b>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="3"></td>
        </tr>
    </table>

    <table border="0" width="90%" align="center" cellspacing="0" cellpadding="5"
        style="font-size: 12px; border-collapse: collapse;">
        <tr style="background: rgb(200, 200, 200); font-weight: bold; text-align: center;">
            <th colspan="2">Nama Akun</th>
            <th width="30%">Jumlah</th>
        </tr>
        <tr>
            <td colspan="3" height="0.1"></td>
        </tr>

        @php
            function toRoman($num)
            {
                $map = [
                    'M' => 1000,
                    'CM' => 900,
                    'D' => 500,
                    'CD' => 400,
                    'C' => 100,
                    'XC' => 90,
                    'L' => 50,
                    'XL' => 40,
                    'X' => 10,
                    'IX' => 9,
                    'V' => 5,
                    'IV' => 4,
                    'I' => 1,
                ];
                $result = '';
                foreach ($map as $roman => $value) {
                    while ($num >= $value) {
                        $result .= $roman;
                        $num -= $value;
                    }
                }
                return $result;
            }

            $nomor = 1;
        @endphp

        @foreach ($arus_kas as $ak)
            <tr style="background: rgb(148, 148, 148);">
                <td align="center">{{ toRoman($nomor) }}</td>
                <td width="70%" align="left">{{ $ak->nama_akun }}</td>
                <td align="center"></td>
            </tr>

            @if (!$loop->last)
                <tr>
                    <td colspan="3" style="height: 0.1;"></td>
                </tr>
            @endif

            @php
                $total_subtotal = 0;
            @endphp

            @foreach ($ak->child as $child)
                @php
                    $akun_level_3 = $child->rek_debit;
                    if ($child->rek_kredit) {
                        $akun_level_3 = $child->rek_kredit;
                    }
                @endphp

                @if ($akun_level_3)
                    @php
                        $jumlah_saldo = 0;
                        foreach ($akun_level_3->accounts as $account) {
                            $transactions = $account->rek_debit;
                            if ($child->rek_kredit) {
                                $transactions = $account->rek_kredit;
                            }

                            foreach ($transactions as $transaction) {
                                $jumlah_saldo += $transaction->total;
                            }
                        }
                    @endphp

                    <tr class="{{ $loop->iteration % 2 == 1 ? 'bg-red' : 'bg-white' }}">
                        <td align="center"></td>
                        <td align="left" style="padding-left: 20px;">{{ $akun_level_3->nama_akun }}</td>
                        <td align="right">
                            {{ $jumlah_saldo < 0 ? '(' . number_format(abs($jumlah_saldo), 2) . ')' : number_format($jumlah_saldo, 2) }}
                        </td>
                    </tr>

                    @php
                        $total_subtotal += $jumlah_saldo;
                    @endphp
                @endif
            @endforeach

            @if (!in_array($nomor, ['1', '3', '6', '9']))
                <tr style="background: rgb(148, 148, 148); font-weight: bold;">
                    <td></td>
                    <td align="left">Jumlah {{ $ak->nama_akun }}</td>
                    <td align="right">
                        {{ $total_subtotal < 0 ? '(' . number_format(abs($total_subtotal), 2) . ')' : number_format($total_subtotal, 2) }}
                    </td>
                </tr>
                {{-- <tr>
                    <td colspan="3" style="padding: 0px !important;">
                        <table class="p" border="0" width="100%" cellspacing="0" cellpadding="0"
                            style="font-size: 11px;">
                            <tr style="background: rgb(128, 128, 128)">
                                <td width="5%" align="center">&nbsp;</td>
                                <td width="80%">Kenaikan (Penurunan) Kas</td>
                                <td width="15%" align="right"></td>
                            </tr>
                            <tr style="background: rgb(128, 128, 128)">
                                <td align="center">&nbsp;</td>
                                <td>SALDO AKHIR KAS SETARA KAS</td>
                                <td align="right"></td>
                            </tr>
                        </table>
                        <div style="margin-top: 16px;"></div>
                    </td>
                </tr> --}}
            @endif
            @php
                $nomor++;
            @endphp
        @endforeach

    </table>
@endsection
