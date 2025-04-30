@php
    use App\Utils\Tanggal;
    $totalNominal = $usages->sum('nominal');
@endphp

<!-- Dropdown filter bulan -->
<select id="filter-bulan" class="form-select form-select-sm"
    style="width: 150px; display: inline-block; margin-bottom: 10px; background-color: #f9f9f9; color: #757575; border: 1px solid #ccc;">
    <option value="">-- Pilih Bulan --</option>
    @for ($i = 1; $i <= 12; $i++)
        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
            {{ Tanggal::namaBulan(date('Y') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT) . '-01') }}
        </option>
    @endfor
</select>


<form action="/usages/cetak" method="post" id="FormCetakBuktiTagihan" target="_blank">
    @csrf
    <table border="0" width="100%" cellspacing="0" cellpadding="0" class="table table-striped midle">
        <thead class="bg-dark text-white">
            <tr>
                <td align="center" width="40">
                    <div class="form-check text-center ps-0 mb-0">
                        <input class="form-check-input" type="checkbox" value="true" id="checked" name="checked">
                    </div>
                </td>
                <td align="center" width="100">Nama</td>
                <td align="center" width="100">Cater</td>
                <td align="center" width="100">No. Induk</td>
                <td align="center" width="100">Meter Awal</td>
                <td align="center" width="100">Meter Akhir</td>
                <td align="center" width="100">Pemakaian</td>
                <td align="center" width="100">Tagihan</td>
                <td align="center" width="100">Tanggal Akhir Bayar</td>
            </tr>
        </thead>

        <tbody>
            @foreach ($usages as $use)
                <tr>
                    <td align="center">
                        <div class="form-check text-center ps-0 mb-0">
                            <input class="form-check-input" type="checkbox" value="{{ $use->id }}"
                                id="{{ $use->id }}" name="cetak[]" data-input="checked"
                                data-bulan="{{ date('m', strtotime($use->tgl_akhir)) }}">
                        </div>
                    </td>
                    <td align="left">{{ $use->customers->nama }}</td>
                    <td align="left">{{ $use->usersCater->nama }}</td>
                    <td align="left">{{ $use->installation->kode_instalasi }}
                        {{ substr($use->installation->package->kelas, 0, 1) }}</td>
                    <td align="right">{{ $use->awal }}</td>
                    <td align="right">{{ $use->akhir }}</td>
                    <td align="right">{{ $use->jumlah }}</td>
                    <td align="right">{{ number_format($use->nominal, 2) }}</td>
                    <td align="center">{{ $use->tgl_akhir }}</td>
                </tr>
            @endforeach
            <tr>
                <td align="center" colspan="6"><b>Jumlah Tagihan Pemakaian</b></td>
                <td align="right">{{ number_format($totalNominal, 2) }}</td>
                <td align="center">&nbsp;</td>
            </tr>
        </tbody>
    </table>
</form>

<script>
    $(document).ready(function() {
        // Filter baris berdasarkan bulan akhir
        $('#filter-bulan').on('change', function() {
            var selectedMonth = $(this).val();
            $('[data-input=checked]').each(function() {
                var row = $(this).closest('tr');
                var bulan = $(this).data('bulan');
                if (!selectedMonth || bulan == selectedMonth) {
                    row.show();
                } else {
                    row.hide();
                    $(this).prop('checked', false); // Uncheck jika disembunyikan
                }
            });
        });

        // Centang semua baris yang terlihat saat checkbox utama diklik
        $('#checked').on('click', function() {
            var status = $(this).is(':checked');
            $('[data-input=checked]:visible').prop('checked', status);
        });
    });
</script>
