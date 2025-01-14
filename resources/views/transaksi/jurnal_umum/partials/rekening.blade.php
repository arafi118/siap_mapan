<div class="col-md-6">
    <div class="position-relative mb-3">
        <label for="sumber_dana">Sumber Dana</label>
        <select class="form-control select" name="sumber_dana" id="sumber_dana">
            <option value="">-- {{ $label1 }} --</option>
            @foreach ($rek1 as $r1)
                <option value="{{ $r1->id }}">
                    {{ $r1->kode_akun }}. {{ $r1->nama_akun }}
                </option>
            @endforeach
        </select>
        <small class="text-danger"></small>
    </div>
</div>
<div class="col-md-6">
    <div class="position-relative mb-3">
        <label class="form-label" for="disimpan_ke">{{ $label2 }}</label>
        <select class="form-control select" name="disimpan_ke" id="disimpan_ke">
            <option value="">-- {{ $label2 }} --</option>
            @foreach ($rek2 as $r2)
                <option value="{{ $r2->id }}">
                    {{ $r2->kode_akun }}. {{ $r2->nama_akun }}
                </option>
            @endforeach
        </select>
        <small class="text-danger" id="msg_disimpan_ke"></small>
    </div>
</div>
<script>
    //select 2
    $(document).ready(function() {
        $('.select').select2({
            theme: 'bootstrap4',
        });
    });
</script>
