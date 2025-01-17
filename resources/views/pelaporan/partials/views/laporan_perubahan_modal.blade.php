<title>{{$title}}</title>
@php
    $nomor = 1;
@endphp

<style>
    * {
        font-family: 'Arial', sans-serif;
    }
    /* Gaya umum untuk semua tabel */
    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 11px;
    }

    /* Gaya untuk tabel kedua dengan garis */
    table.with-border th, 
    table.with-border td {
        border: 1px solid black; /* Garis tabel */
        padding: 5px; /* Padding sel */
    }

    table.with-border th {
        background: rgb(232, 232, 232); /* Warna latar header */
        text-align: center;
    }

    /* Gaya tambahan untuk posisi garis */
    .l { border-left: 1px solid black; }
    .t { border-top: 1px solid black; }
    .r { border-right: 1px solid black; }
    .b { border-bottom: 1px solid black; }
</style>

<table>
    <tr>
        <td colspan="3" align="center">
            <div style="font-size: 18px;">
                <b>LAPORAN PERUBAHAN MODAL</b>
            </div>
            <div style="font-size: 16px;">
                <b>{{ strtoupper($sub_judul) }}</b>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" height="8"></td>
    </tr>
</table>
<table class="with-border"style="font-size: 12px;">
    <tr>
        <th class="l t" width="5%">No</th>
        <th class="l t" width="55%">Rekening Modal</th>
        <th class="l t" width="20%">&nbsp;</th>
    </tr>
   @php
    $total_saldo = 0; 
@endphp
@foreach ($accounts as $rek)
    @php
        $saldo_debit = 0;
        $saldo_kredit = 0;
        foreach ($rek->amount as $amount) {
            $saldo_debit += $amount->debit;
            $saldo_kredit += $amount->kredit;
        }

        $saldo = $saldo_kredit - $saldo_debit;
        $total_saldo += $saldo; 
    @endphp
    <tr>
        <td class="l t" align="center">{{ $nomor++ }}</td>
        <td class="l t">{{ $rek->nama_akun }}</td>
        <td class="l t" align="right">{{ number_format($saldo, 2) }}</td>
    </tr>
@endforeach
<tr>
    <td class="l t b" colspan="2" height="15">Total Saldo</td>
    <td class="l t b" align="right">{{ number_format($total_saldo, 2) }}</td>
</tr>
</table>
