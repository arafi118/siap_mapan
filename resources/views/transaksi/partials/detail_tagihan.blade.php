@php
    use App\Utils\Tanggal;

    $total_tagihan = 0;
    $total_denda = 0;
    $total_bayar = 0;
@endphp
{{-- <div class="row mb-3">
    <div class="col-md-3">
        <label for="selectTahun" class="form-label">Pilih Tahun:</label>
        <select class="form-control form-control-sm" id="selectTahun">
            @foreach ($tahun_options as $th)
                <option value="{{ $th }}" {{ $tahun == $th ? 'selected' : '' }}>{{ $th }}</option>
            @endforeach
        </select>
    </div>q
</div> --}}


<table border="0" width="100%" cellspacing="0" cellpadding="0" class="table table-striped midle">
    <thead class="bg-dark text-white">
        <tr>
            <td height="40" align="center" width="40" style="vertical-align: middle;">No</td>
            <td align="center" width="120" style="vertical-align: middle;">Tanggal</td>
            <td align="center" width="120" style="vertical-align: middle;">
                <select class="form-control form-control-sm" id="selectTahun" style="width: 100px;">
                    @foreach ($tahun_options as $th)
                        <option value="{{ $th }}" {{ $tahun == $th ? 'selected' : '' }}>
                            {{ $th }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td align="center" style="vertical-align: middle;">Keterangan</td>
            <td align="center" width="140" style="vertical-align: middle;">Id Transaksi</td>
            <td align="center" width="140" style="vertical-align: middle;">Jumlah Bayar</td>
            <td align="center" width="80" style="vertical-align: middle;">Aksi</td>
        </tr>
    </thead>




    <tbody>

        @foreach ($transaksi as $trx)
            @php

                if ($trx->rekening_debit == $akun_kas->id) {
                    $ref = $trx->rek_debit->kode_akun;
                    $debit = $trx->total;
                } else {
                    $ref = $trx->kode_akun;
                    $debit = 0;
                }
                $tagihan = $trx->Usages->nominal ?? 0;
                $denda = $trx->denda ?? 0;

                $total_tagihan += $tagihan;
                $total_denda += $denda;
                $total_bayar += $debit;

            @endphp

            <tr>
                <td align="center">{{ $loop->iteration }}.</td>
                <td align="center">{{ Tanggal::tglIndo($trx->tgl_transaksi) }}</td>
                <td></td>
                <td>{{ $trx->keterangan }} ( {{ $trx->Usages->id }} )</td>
                <td align="center">{{ $trx->id }}</td>
                <td align="right">{{ number_format($debit, 2) }}</td>
                <td align="right">

                    <div class="d-flex align-items-center gap-1">
                        <a href="/transactions/dokumen/struk_{{ $trx->usage_id == '0' ? 'instalasi' : 'tagihan' }}/{{ $trx->transaction_id }}"
                            target="_blank" class="btn btn-info btn-sm" title="Cetak Struk">
                            <i class="fas fa-print"></i>
                        </a>
                        <button class="btn btn-danger btn-sm btn-delete mt-0" data-id="{{ $trx->id }}"
                            title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>


                </td>
            </tr>
        @endforeach

        <tr>
            <td colspan="5" align="center">
                <b>Total Transaksi</b>
            </td>

            <td align="right">
                <b>{{ number_format($total_bayar, 2) }}</b>
            </td>
            <td align="right">
                <b>&nbsp;</b>
            </td>
        </tr>

    </tbody>

</table>
<script>
    function initializeBootstrapTooltip() {
        $('[data-toggle="tooltip"]').tooltip();
    }
</script>
