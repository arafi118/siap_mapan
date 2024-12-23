 <div class="row">
     <div class="col-lg-12">
         <div class="card mb-4">
             <div class="card-body">
                 <!-- Bagian Informasi Customer -->
                 <div class="alert alert-warning d-flex align-items-center" role="alert">
                     <!-- Gambar -->
                     <img src="../../assets/img/user.png" style="max-height: 150px; margin-right: 20px;" class="img-fluid">

                     <!-- Konten Teks -->
                     <div>
                         <div>
                             <h4 class="alert-heading">Customer an. {{ $REG_status->customer->nama }} <b></b>
                                 masih
                                 memiliki pinjaman dengan status
                                 <b>
                                     @if ($REG_status->status === 'B')
                                         Blokir ( B )
                                     @elseif($REG_status->status === 'C')
                                         Cabut ( C )
                                     @endif
                                 </b>
                             </h4>
                             <hr>
                             <p class="mb-0">
                                 desa.{{ $REG_status->alamat }},
                                 ,
                                 koordinate [ {{ $REG_status->koordinate }}
                                 ].
                             </p>
                         </div>
                     </div>

                 </div>
                 <!-- Tabel di Bawah Customer -->
                 <div class="mt-4">
                     <table class="table table-bordered table-striped">
                         <thead class="thead-light">
                             <tr>
                                 <th colspan="2">Deatil Pemberitahuan Permohonan</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr>
                                 <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                     <span style="float: left;">Tanggal</span>
                                     <span class="badge badge-warning"
                                         style="float: right; width: 20%; padding: 5px; text-align: center;">
                                         {{ $REG_status->blokir ?? ($REG_status->cabut ?? 0) }}
                                     </span>
                                 </td>
                                 <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                     <span style="float: left;">Abodemen</span>
                                     <span class="badge badge-warning"
                                         style="float: right; width: 20%; padding: 5px; text-align: center;">
                                         {{ number_format($REG_status->abodemen, 2) }}
                                     </span>
                                 </td>
                             </tr>
                             <tr>
                                 <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                     <span style="float: left;">Paket Instalasi</span>
                                     <span class="badge badge-warning"
                                         style="float: right; width: 20%; padding: 5px; text-align: center;">
                                         {{ $REG_status->package->kelas }}
                                     </span>
                                 </td>
                                 <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                     <span style="float: left;">Status Instalasi</span>
                                     @if ($REG_status->status == 'B')
                                         <span class="badge badge-warning"
                                             style="float: right; width: 20%; padding: 5px; text-align: center;">
                                             BLokir
                                         </span>
                                     @elseif ($REG_status->status == 'C')
                                         <span class="badge badge-warning"
                                             style="float: right; width: 20%; padding: 5px; text-align: center;">
                                             CABUT
                                         </span>
                                     @endif
                                 </td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
                 <br>
                 <div class="col-12 d-flex justify-content-end">
                     @if ($REG_status->status == 'B')
                         <a href="/installations?status=B" class="btn btn-secondary">Cek Detail</a>
                     @elseif ($REG_status->status == 'C')
                         <a href="/installations?status=C" class="btn btn-secondary">Cek Detail</a>
                     @endif
                 </div>
             </div>
         </div>
     </div>
 </div>
