@extends('layouts.base')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="/transactions" method="post" id="FormTransaksi">
                @csrf
                <input type="hidden" name="clay" id="clay" value="JurnalUmum">
                <div class="row">
                    @php
                        use App\Utils\Tanggal;
                    @endphp

                    <input type="hidden" name="jenis_transaksi" id="jenis_transaksi" value="2">
                    <input type="hidden" name="disimpan_ke" id="disimpan_ke" value="{{ $akunFeeKolektor->id }}">
                    <input type="hidden" name="transaction_id" id="transaction_id">
                    <input type="hidden" name="keterangan" id="keterangan">
                    <div class="col-md-4">
                        <div class="position-relative mb-3">
                            <label for="tgl_transaksi">Tanggal Transaksi</label>
                            <input type="text" class="form-control date" name="tgl_transaksi" id="tgl_transaksi"
                                style="height: 38px;" value="{{ date('d/m/Y') }}">
                            <small class="text-danger" id="msg_tgl_transaksi"></small>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="position-relative mb-3">
                            <label class="form-label" for="piutang_komisi">Utang Komisi</label>
                            <select class="select2 form-control" name="piutang_komisi" id="piutang_komisi"
                                style="width: 100%">
                                <option value="">-- Pilih Utang Komisi --</option>
                                @foreach ($commissionTransactions as $com)
                                    @php
                                        $tgl_akhir = $com->Usages->tgl_akhir;
                                        $bulan_tagihan =
                                            Tanggal::namaBulan($tgl_akhir) . ' ' . Tanggal::tahun($tgl_akhir);
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
                                    <option
                                        value="{{ $com->id }}|{{ $com->transaction_id }}|{{ $sisaKomisi }}|{{ $kolektor }}|{{ $com->tgl_transaksi }}">
                                        {{ $com->Installations->customer->nama }} [{{ $com->Installations->id }}] -
                                        Tagihan {{ $bulan_tagihan }} Rp. {{ number_format($sisaKomisi, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="position-relative mb-3">
                            <label for="relasi">Relasi</label>
                            <input type="text" class="form-control" id="relasi" name="relasi" style="height: 38px;"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="position-relative mb-3">
                            <label for="nominal">Nominal Rp.</label>
                            <input type="text" class="form-control" id="nominal" name="nominal" value=""
                                style="height: 38px;">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="position-relative mb-3">
                            <label class="form-label" for="sumber_dana">Pilih Pembayaran</label>
                            <select class="select2 form-control" name="sumber_dana" id="sumber_dana" style="width: 100%">
                                <option value="">-- Pilih Pembayaran --</option>
                                @foreach ($akunKas as $akun)
                                    <option value="{{ $akun->id }}">
                                        {{ $akun->kode_akun }}. {{ $akun->nama_akun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-end">
                        <button class="btn btn-secondary btn-icon-split" type="button" id="SimpanTransaksi">
                            <span class="icon text-white-50">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                </svg>
                            </span>
                            <span class="text" style="float: right;">Simpan Transaksi</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var formatter = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });

        jQuery.datetimepicker.setLocale('de');
        $('.date').datetimepicker({
            i18n: {
                de: {
                    months: [
                        'Januari', 'Februari', 'Maret', 'April',
                        'Mei', 'Juni', 'Juli', 'Agustus',
                        'September', 'Oktober', 'November', 'Desember',
                    ],
                    days: [
                        'Minggu', 'Senin', 'Selasa', 'Rabu',
                        'Kamis', 'Jumat', 'Sabtu',
                    ],
                    dayOfWeekShort: [
                        "Min", "Sen", "Sel", "Rab",
                        "Kam", "Jum", "Sab",
                    ],
                    dayOfWeek: [
                        "Minggu", "Senin", "Selasa", "Rabu",
                        "Kamis", "Jumat", "Sabtu",
                    ],
                    monthsShort: [
                        "Jan", "Feb", "Mar", "Apr",
                        "Mei", "Jun", "Jul", "Agu",
                        "Sep", "Okt", "Nov", "Des",
                    ],
                    daysShort: [
                        "Ming.", "Sen", "Sel", "Rab",
                        "Kam", "Jum", "Sab",
                    ],
                    daysMin: [
                        "Ming.", "Sen", "Sel", "Rab",
                        "Kam", "Jum", "Sab",
                    ]
                }
            },
            timepicker: false,
            format: 'd/m/Y'
        });

        $(document).ready(function() {
            $('select').select2({
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

        $(document).on('click', '#SimpanTransaksi', function(e) {
            e.preventDefault()
            $('small').html('')

            var piutang = $('#piutang_komisi').val();
            var parts = piutang.split('|');

            var tgl_transaksi = $('#tgl_transaksi').val();
            var tgl_tagihan = parts[4];

            var [day, month, year] = tgl_transaksi.split('/');
            tgl_transaksi = new Date(`${year}-${month}-${day}`);
            tgl_tagihan = new Date(tgl_tagihan);

            if (tgl_transaksi > tgl_tagihan) {
                var form = $('#FormTransaksi')
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(result) {
                        if (result.success) {
                            Swal.fire('Berhasil', result.msg, 'success').then(() => {
                                window.location.reload();
                            })
                        } else {
                            Swal.fire('Error', result.msg, 'error')
                        }
                    },
                    error: function(result) {
                        const respons = result.responseJSON;

                        Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error')
                        $.map(respons, function(res, key) {
                            $('#' + key).parent('.input-group.input-group-static').addClass(
                                'is-invalid')
                            $('#msg_' + key).html(res)
                        })
                    }
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Tanggal transaksi tidak boleh sebelum tanggal utang komisi',
                })
            }
        })
    </script>
@endsection
