@php
    use App\Utils\Tanggal;
@endphp

<input type="hidden" name="transaction_id" id="transaction_id">
<input type="hidden" name="keterangan" id="keterangan">
<div class="col-md-12">
    <div class="position-relative mb-3">
        <label class="form-label" for="piutang_komisi">Utang Komisi</label>
        <select class="select2 form-control" name="piutang_komisi" id="piutang_komisi" style="width: 100%">
            <option value="">-- Pilih Utang Komisi --</option>
            @foreach ($commissionTransactions as $com)
                @php
                    $tgl_akhir = $com->Usages->tgl_akhir;
                    $bulan_tagihan = Tanggal::namaBulan($tgl_akhir) . ' ' . Tanggal::tahun($tgl_akhir);
                    $kolektor = $com->Installations->village->kolektor;

                    $komisiTerbayar = 0;
                    foreach ($com->transaction as $trx) {
                        $komisiTerbayar += $trx->total;
                    }

                    $sisaKomisi = $com->total - $komisiTerbayar;
                    if ($sisaKomisi <= 0) {
                        continue;
                    }
                @endphp
                <option value="{{ $com->id }}|{{ $com->transaction_id }}|{{ $sisaKomisi }}|{{ $kolektor }}">
                    {{ $com->Installations->customer->nama }} [{{ $com->Installations->id }}] -
                    Tagihan {{ $bulan_tagihan }} Rp. {{ number_format($sisaKomisi, 2) }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-6">
    <div class="position-relative mb-3">
        <label for="relasi">Relasi</label>
        <input type="text" class="form-control" id="relasi" name="relasi" style="height: 38px;" readonly>
    </div>
</div>
<div class="col-md-6">
    <div class="position-relative mb-3">
        <label for="nominal">Nominal Rp.</label>
        <input type="text" class="form-control" id="nominal" name="nominal" value="" style="height: 38px;">
    </div>
</div>

<script>
    var formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    $(document).ready(function() {
        $('#piutang_komisi').select2({
            theme: 'bootstrap4',
        });
    });

    $("#nominal").maskMoney({
        allowNegative: true
    });

    $('#piutang_komisi').on('change', function() {
        var selectedOption = $(this).val();
        if (selectedOption) {
            var parts = selectedOption.split('|');
            var relasi = parts[3];
            var nominal = parts[2];

            $('#relasi').val(relasi);
            $('#nominal').val(formatter.format(nominal));
            $('#transaction_id').val(parts[1]);

            var keterangan = 'Pembayaran utang komisi ' + relasi + ' (' + parts[0] + ') sejumlah Rp. ' +
                formatter.format(nominal);
            $('#keterangan').val(keterangan);
        } else {
            $('#relasi').val('');
            $('#nominal').val(formatter.format(0));
            $('#transaction_id').val('');
            $('#keterangan').val('');
        }
    });
</script>
