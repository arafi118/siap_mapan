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
                    <table class="table align-items-center table-flush" id="TbPemakain">
                        <thead class="thead-light">
                            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                <!-- Data Desa -->
                                <div style="display: flex; align-items: center;">
                                    <i class="fas fa-tint" style="font-size: 28px; margin-right: 8px;"></i>
                                    <b>Data Pemakaian</b>
                                </div>
                                <div style="display: flex; justify-content: flex-end;">
                                    <a href="/usages/create" class="btn btn-primary" id="RegisterDusun"
                                        style="display: inline-block; width: 150px; height: 30px; text-align: center; line-height: 18px; font-size: 12px;">
                                        <i class="fas fa-plus"></i> Register Pemakaian
                                    </a>
                                </div>
                            </div>
                            <div>&nbsp;</div>
                            <tr>
                                <th>NAMA</th>
                                <th>KODE INSTALASI</th>
                                <th>AWAL</th>
                                <th>AKHIR</th>
                                <th>JUMLAH</th>
                                <th>TGL AKHIR</th>
                                <th style="text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usages as $usage)
                            <tr>
                                <td>{{ ($usage->customers) ? $usage->customers->nama:'' }}</td>
                                {{-- <td>{{ ($usage->kode_instalasi) ?$usage->installations->kode_instalasi:'' }}</td> --}}
                                <td>{{ $usage->kode_instalasi }}</td> 
                                <td>{{ $usage->awal }}</td>
                                <td>{{ $usage->akhir }}</td>
                                <td>{{ $usage->jumlah }}</td>
                                <td>{{ $usage->tgl_akhir }}</td>
                                <td style="text-align: center; display: flex; gap: 5px; justify-content: center;">
                                    <a href="/usages/{{ $usage->id }}/edit" class="btn btn-warning btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="/usages/{{ $usage->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemakaian ini?');" style="margin: 0;">
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
        $(document).ready(function() {
            $('#TbPemakain').DataTable(); // ID From dataTable 
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
        document.addEventListener('DOMContentLoaded', function() {
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
