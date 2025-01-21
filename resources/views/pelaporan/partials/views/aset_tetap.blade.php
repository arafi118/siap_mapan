@php
    use App\Utils\Tanggal;
    use App\Utils\Inventaris;
@endphp
<title>{{ $title }}</title>
<style>
     * {
        font-family: 'Arial', sans-serif;

    }
    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
        table-layout: fixed;
    }
    th, td {
        border: 1px solid black; /* Garis untuk tabel utama */
        padding: 5px;
        text-align: center;
    }
    th {
        background-color: rgb(232, 232, 232);
        font-weight: bold;
    }
    .header-table td {
        border: none; /* Tidak ada garis untuk tabel header */
    }
    .p th, .p td {
        border: 0.1px solid rgb(0, 0, 0); /* Garis tipis untuk tabel jumlah */
    }
</style>

@foreach ($accounts as $acc)
    @if ($loop->iteration > 1)
        <div style="page-break-after: always"></div>
    @endif

    @include('pelaporan.partials.views.inventory.ati', ['Inventory' => $acc->inventory, 'nama' => $acc->nama_akun])
@endforeach



        


