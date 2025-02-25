@php
    use App\Utils\Tanggal;
@endphp




<style>
    body {
        font-size: 12px;
        color: rgba(0, 0, 0, 0.8);
        /* width: 20cm; */
        font-family: Arial, Helvetica, sans-serif;
        font-weight: medium;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .font-roboto {
        font-family: Cochin, Georgia, Times, 'Times New Roman', serif;
    }

    .container {
        position: relative;
        width: 20cm;
        height: 10cm;
        padding: 10px;
        /*border: 1px solid rgba(0, 0, 0, 0.1);*/
    }

    .box {
        border: 2px solid #000;
        padding-top: 16px;
        padding-bottom: 12px;
        padding-right: 22px;
        padding-left: 12px;
    }

    .box-header {
        padding-left: 16px;
        padding-right: 16px;
        padding-bottom: 8px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.5);
    }

    .flex {
        display: flex;
    }

    .block {
        display: block;
    }

    .inline-block {
        display: inline-block;
    }

    .fw-bold {
        font-weight: bold;
    }

    .fs-8 {
        font-size: 8px;
    }

    .fs-10 {
        font-size: 10px;
    }

    .fs-12 {
        font-size: 12px;
    }

    .fs-14 {
        font-size: 14px;
    }

    .fs-16 {
        font-size: 16px;
    }

    .-mt-2 {
        margin-top: -2px;
    }

    .ml-4 {
        margin-left: 4px;
    }

    .align-items-center {
        align-items: center;
    }

    .justify-content-between {
        justify-content: space-between;
    }

    .box-body {
        padding-top: 0px;
        padding-left: 24px;
        padding-right: 24px;
    }

    .keterangan {
        padding: 6px;
        padding-top: 4px;
        padding-bottom: 4px;
    }

    .jajargenjang {
        background-color: rgb(204, 204, 204);
        -ms-transform: skew(-20deg);
        -webkit-transform: skew(-20deg);
        transform: skew(-20deg);
        text-align: center;
    }

    .terbilang {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }

    @media print {
        .jajargenjang {
            background-color: rgb(204, 204, 204);
            -ms-transform: skew(-20deg);
            -webkit-transform: skew(-20deg);
            transform: skew(-20deg);
            text-align: center;
        }
    }

    h4 {
        margin: 14px 0;
        width: 100%;
        text-align: center;
        border-bottom: 1px dashed #000;
        line-height: 0px;
        font-style: italic;
    }

    h4 span {
        background: rgb(204, 204, 204);
        padding: 10px;
    }

    .border-b {
        border-bottom: 1px dashed rgba(0, 0, 0, 0.4);
    }

    .text-left {
        padding-left: 6px;
        padding-right: 6px;
        padding-top: 2px;
        padding-bottom: 4px;
        text-align: left;
    }

    .fw-medium {
        font-weight: 600;
    }

    .tanggal {
        font-size: 8px;
        margin-left: 16px;
    }
</style>
<div class="container-wrapper">
    @foreach ($usages as $index => $usage)
        <div class="container">
            <div class="box">
                <table border="0" width="100%" style="border-bottom: 1px solid #000;">
                    <tr>
                        <td width="40">
                            <img src="../storage/app/public/logo/{{ $gambar }}" width="50" height="50">
                        </td>
                        <td>
                            <div class="fw-bold">{{ strtoupper($bisnis->nama) }}</div>
                            <div style="font-size: 8px;">{{ 'SK Kemenkumham RI No. ' . $bisnis->nomor_bh }}</div>
                            <div style="font-size: 8px;">{{ $bisnis->alamat . ', Telp. ' . $bisnis->telpon }}</div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; font-size: 8px;">
                                <table>
                                    <tr>
                                        <td style="font-size: 8px;">Nomor</td>
                                        <td style="font-size: 8px;">:</td>
                                        <td style="font-size: 8px;"><?php echo $usage['id_instalasi']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 8px;">Tanggal</td>
                                        <td style="font-size: 8px;">:</td>
                                        <td style="font-size: 8px;">{{ Tanggal::tglIndo($usage['tgl_akhir']) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="box-body fs-14">
                    <table width="100%">
                        <tr>
                            <td width="30%">Nama Pelanggan</td>
                            <td width="2%">:</td>
                            <td class="keterangan border-b">{{ $data_customer[$usage['customer']]->nama }}</td>
                        </tr>
                        <tr>
                            <td>Tgl Bayar</td>
                            <td>:</td>
                            <td class="keterangan border-b">{{ Tanggal::tglLatin($usage['tgl_akhir']) }}</td>
                        </tr>
                        <tr>
                            <td>No Ref</td>
                            <td>:</td>
                            <td class="keterangan border-b">{{ md5($usage['id_instalasi']) }}</td>
                        </tr>
                        <tr>
                            <td>T Awal</td>
                            <td>:</td>
                            <td class="keterangan border-b">{{ $usage['awal'] }}</td>
                        </tr>
                        <tr>
                            <td>T Akhir</td>
                            <td>:</td>
                            <td class="keterangan border-b">{{ $usage['akhir'] }}</td>
                        </tr>
                        <tr>
                            <td>Jumlah</td>
                            <td>:</td>
                            <td class="keterangan border-b">{{ $usage['jumlah'] }}</td>
                        </tr>
                        <tr>
                            <td>Total Bayar</td>
                            <td>:</td>
                            <td colspan="3" class="keterangan fw-medium terbilang jajargenjang">
                                <h4 {!! strlen($keuangan->terbilang($usage['nominal'])) > 30 ? 'style="font-size: 8px;"' : '' !!}>
                                    <span>{{ ucwords($keuangan->terbilang($usage['nominal'])) }} Rupiah</span>
                                </h4>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" class="fs-12" style="margin-top: 8px;">
                        <tr>
                            <td width="40%" align="center" rowspan="6">
                                <i>
                                    <h3 class="flex" style="padding-left: 18px;">
                                        Terbilang Rp. &nbsp; <div class="jajargenjang text-left">
                                            {{ number_format($usage['nominal'], 2) }}</div>
                                    </h3>
                                </i>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="tanggal">Dicetak pada {{ date('Y-m-d H:i:s') }}</div>
        </div>
</div>
@endforeach
