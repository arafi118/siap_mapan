@extends('layouts.base')

@section('content')
@if (session('success'))
<div id="success-alert" class="alert alert-success alert-dismissible fade show text-center" role="alert">
    <li class="	fas fa-check-circle"></li>
    {{ session('success') }}
</div>
@endif
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="TbDusun">
                    <thead class="thead-light">
                        <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                            <!-- Data Desa -->
                            <div style="display: flex; align-items: center;">
                                <i class="fas fa-home" style="font-size: 30px; margin-right: 9px;"></i>
                                <b>Data Dusun</b>
                            </div>
                            <div style="display: flex; justify-content: flex-end;">
                                <a href="/hamlets/create" class="btn btn-primary" id="RegisterDusun"
                                    style="display: inline-block; width: 130px; height: 30px; text-align: center; line-height: 18px; font-size: 12px;">
                                    <i class="fas fa-plus"></i> Register Dusun
                                </a>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <tr>
                            <th>DESA</th>
                            <th>DUSUN</th>
                            <th>ALAMAT</th>
                            <th>TELPON</th>
                            <th style="text-align: center;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hamlets as $hamlet)
                        <tr>
                            <td> {{ $hamlet->village->nama }}</td>
                            <td>{{ $hamlet->dusun }}</td>
                            <td>{{ $hamlet->alamat }}</td>
                            <td>{{ $hamlet->hp }}</td>
                            <td style="text-align: center; display: flex; gap: 5px; justify-content: center;">
                                <a href="/hamlets/{{ $hamlet->id }}/edit" class="btn btn-warning btn-sm">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="/hamlets/{{ $hamlet->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Dusun ini?');" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                            
                        </tr>
                        
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#TbDusun').DataTable(); // ID From dataTable 
        });

    </script>

@if (Session::has('berhasil'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ Session::get('berhasil') }}',
        showConfirmButton: false,
        timer: 2000
    });
</script>
    <script>
    // Menghilangkan notifikasi setelah 5 detik
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(() => {
                alert.style.display = 'none';
            }, 2000); // 2000ms = 2 detik
        }
    });
    </script>
    @endif
    <script>
        // Tunggu hingga DOM selesai dimuat
        document.addEventListener('DOMContentLoaded', function () {
            // Pilih elemen notifikasi
            const alert = document.getElementById('success-alert');
            if (alert) {
                // Atur timer untuk menghilangkan notifikasi setelah 3 detik
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s'; // Animasi hilang
                    alert.style.opacity = '0'; 
                    setTimeout(() => alert.remove(), 500); // Hapus elemen setelah animasi selesai
                }, 2000);
            }
        });
    </script>
@endsection