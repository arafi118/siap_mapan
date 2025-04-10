@include('pelaporan.layouts.style')
<title>{{ $title }}</title>

<table class="header-table" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
    <tr>
        <td colspan="3" align="center">
            <div style="font-size: 18px; font-weight: bold;">Daftar Pelanggan</div>
            <div style="font-size: 16px; font-weight: bold;">{{ strtoupper($sub_judul) }}</div>
        </td>
    </tr>
    <tr>
        <td colspan="3" height="10"></td>
    </tr>
</table>
@php
    $no = 1;
@endphp

<table border="0" width="100%">
    <thead>
        <tr style="background: rgb(232, 232, 232); font-weight: bold;">
            <th width="3%" class="t l b">No</th>
            <th width="13%" class="t l b">Nama</th>
            <th width="10%" class="t l b">Nik</th>
            <th width="22%" class="t l b">Alamat</th>
            <th width="10%" class="t l b">No. Telp</th>
            <th width="10%" class="t l b">Kode Instalasi</th>
            <th width="8%" class="t l b r">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($installations as $installation)
            <tr>
                <td align="center" class="t l b">{{ $no++ }}</td>
                <td align="left" class="t l b">{{ $installation->customer->nama }}</td>
                <td align="center" class="t l b">{{ $installation->customer->nik }}</td>
                <td align="left" class="t l b">{{ $installation->customer->alamat }}</td>
                <td align="center" class="t l b">{{ $installation->customer->hp }}</td>
                <td align="center" class="t l b">{{ $installation->kode_instalasi }}</td>
                <td align="center" class="t l b r">
                    @if ($installation->status == 'R' || $installation->status == '0')
                        Permohonan
                    @elseif ($installation->status == 'I')
                        Pasang
                    @elseif ($installation->status == 'A')
                        Aktif
                    @elseif ($installation->status == 'B')
                        Blokir
                    @elseif ($installation->status == 'C')
                        Cabut
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" align="center" class="t l b r">
                    Tidak ada data pelanggan.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
