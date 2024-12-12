@php
    $blok = json_decode($tampil_settings->block, true);
    $jumlah_blok = count($blok);
@endphp

<div class="row mb-3 d-none" id="RowBlock">
    <div class="col-md-6">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" name="nama[]" placeholder="Nama Blok">
    </div>
    <div class="col-md-6">
        <label for="jarak">Volume</label>
        <input type="text" class="form-control" name="jarak[]" placeholder="0 - 10 M3">
    </div>
</div>

<form action="/packages/block_paket" method="POST" id="Fromblock">
    @csrf

    <div class="container mt-4">
        <div id="inputFromblock">
            @for ($i = 0; $i < $jumlah_blok; $i++)
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama[]" value="{{ $blok[$i]['nama'] }}">
                    </div>
                    <div class="col-md-6">
                        <label for="jarak">Volume</label>
                        <input type="text" class="form-control" name="jarak[]" value="{{ $blok[$i]['jarak'] }}">
                    </div>
                </div>
            @endfor
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button class="btn btn-info btn-icon-split" type="button" id="blockinput" class="btn btn-dark">
            <span class="icon text-white-50"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                    <path
                        d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                </svg>
            </span><span class="text" style="float: right;">Block</span>
        </button>
        <button class="btn btn-dark btn-icon-split" type="button" id="SimpanBlock" class="btn btn-dark">
            <span class="text" style="float: right;">Simpan Perubahan</span>
        </button>
    </div>
</form>
