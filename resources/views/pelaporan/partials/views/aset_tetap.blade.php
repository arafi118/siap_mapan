@php
    use App\Utils\Tanggal;
    use App\Utils\Inventaris;
@endphp
<title>{{ $title }}</title>
<style>
    * {
        font-family: 'Arial', sans-serif;

    }
</style>
@extends('pelaporan.layouts.base')

@section('content')
    @foreach ($accounts as $acc)
        @if ($loop->iteration > 1)
            <div style="page-break-after: always"></div>
        @endif

        @include('pelaporan.partials.views.inventory.ati', [
            'Inventory' => $acc->inventory,
            'nama' => $acc->nama_akun,
        ])
    @endforeach
@endsection
