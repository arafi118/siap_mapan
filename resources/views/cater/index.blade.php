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
                    <table class="table align-items-center table-flush" id="TbDesa">
                        <thead class="thead-light">
                            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                <!-- Data Desa -->
                                <div style="display: flex; align-items: center;">
                                    <i class="fas fa-home" style="font-size: 30px; margin-right: 9px;"></i>
                                    <b>Data Desa</b>
                                </div>
                            </div>
                            <div>&nbsp;</div>
                            <tr>
                                <th>KODE</th>
                                <th>NAMA DESA</th>
                                <th>AWAL</th>
                                <th>AKHIR</th>
                                <th>AKHIR</th>
                                <th>AKHIR</th>
                                <th style="text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($villages as $village)
                            <tr>
                                <td>{{ $village->kode }}</td>
                                <td>{{ $village->nama }}</td>
                                <td style="padding: 3px; word-wrap: break-word; max-width: 200px;">
                                    {{ $village->alamat }}
                                </td>
                                <td>{{ $village->hp }}</td>
                                <td style="text-align: center; display: flex; gap: 5px; justify-content: center;">
                                    <a href="/villages/{{ $village->id }}/edit" class="btn btn-warning btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="/villages/{{ $village->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus desa ini?');" style="margin: 0;">
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
<!--Row-->

<!-- Documentation Link -->

<!-- Modal Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to logout?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                <a href="login.html" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#TbDesa').DataTable(); // ID From dataTable 
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
            }, 3000);
        }
    });
</script>
@endsection
