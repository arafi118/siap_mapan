@php
    $blok = json_decode($tampil_settings->block, true);
    $jumlah_blok = count($blok);
    $harga = json_decode($package->harga, true);
@endphp

<div class="col-md-12">

    <table class="table table-bordered table-striped">
        <thead class="thead-light text-center">
            <tr>
                <th>Nama</th>
                <th>Jarak</th>
                <th>Harga</th>
            </tr>
        </thead>

        @for ($i = 0; $i < $jumlah_blok; $i++)
            <tbody {{ 12 / $jumlah_blok }}>
                <tr>
                    <td>{{ $blok[$i]['nama'] }}</td>
                    <td>{{ $blok[$i]['jarak'] }}</td>
                    <td class="text-right">
                        <span class="badge badge-success" style="width: 20%; padding: 5px; text-align: right;">
                            Rp. {{ number_format(isset($harga[$i]) ? $harga[$i] : '0', 2) }}
                        </span>
                    </td>
                </tr>
            </tbody>
        @endfor
    </table>
</div>

<div class="col-md-6">
    <label for="abodemen">Abodemen</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control abodemen" name="abodemen" id="abodemen"
            aria-describedby="basic-addon2" readonly value="{{ number_format($tampil_settings->abodemen, 2) }}">
    </div>
</div>
<div class="col-md-6">
    <label for="denda">Denda</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control"aria-describedby="basic-addon2" readonly
            value="{{ number_format($tampil_settings->denda, 2) }}">
    </div>
</div>
@section('script')
    <script>
        $(".abodemen").maskMoney({
            allowNegative: true
        });

        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endsection