<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body p-0"> <!-- Menghapus padding default card-body -->
                <ul class="nav nav-pills nav-fill"> <!-- Menambahkan nav-fill untuk lebar sama -->
                    <li class="nav-item">
                        <a class="nav-link active w-100 text-center" data-toggle="tab" data-target="#Permohonan"
                            href="#">
                            <b>Permohonan ( R )</b>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link w-100 text-center" data-toggle="tab" data-target="#Pasang" href="#">
                            <b>Pasang ( I )</b>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link w-100 text-center" data-toggle="tab" data-target="#Aktif" href="#">
                            <b>Aktif ( A )</b>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link w-100 text-center" data-toggle="tab" data-target="#Blokir" href="#">
                            <b>Blokir ( B )</b>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link w-100 text-center" data-toggle="tab" data-target="#Cabut" href="#">
                            <b>Cabut ( C )</b>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div id="tabsContent" class="tab-content">
    <div id="Permohonan" role="tab" class="tab-pane active show">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="table-responsive p-3">
                        <table style="width: 100%;" class="table align-items-center table-flush table-hover"
                            id="TbPermohonan">
                            <thead class="thead-light">
                                <tr>
                                    <th>No.Induk</th>
                                    <th>Customer</th>
                                    <th>alamat</th>
                                    <th>Paket</th>
                                    <th>Tanggal Order</th>
                                    <th>Status</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pasang Tab -->
    <div id="Pasang" role="tab" class="tab-pane ">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="table-responsive p-3">
                        <table style="width: 100%;" class="table align-items-center table-flush table-hover"
                            id="TbPasang">
                            <thead class="thead-light">
                                <tr>
                                    <th>No.Induk</th>
                                    <th>Customer</th>
                                    <th>alamat</th>
                                    <th>Paket</th>
                                    <th>Tanggal Order</th>
                                    <th>Status</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktif Tab -->
    <div id="Aktif" role="tab" class="tab-pane ">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="table-responsive p-3">
                        <table style="width: 100%;" class="table align-items-center table-flush table-hover"
                            id="TbAktif">
                            <thead class="thead-light">
                                <tr>
                                    <th>No.Induk</th>
                                    <th>Customer</th>
                                    <th>alamat</th>
                                    <th>Paket</th>
                                    <th>Tanggal Aktif</th>
                                    <th>Status</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blokir Tab -->
    <div id="Blokir" role="tab" class="tab-pane ">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="table-responsive p-3">
                        <table style="width: 100%;" class="table align-items-center table-flush table-hover"
                            id="TbBlokir">
                            <thead class="thead-light">
                                <tr>
                                    <th>No.Induk</th>
                                    <th>Customer</th>
                                    <th>alamat</th>
                                    <th>Paket</th>
                                    <th>Tanggal Blokir</th>
                                    <th>Status</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cabut Tab -->
    <div id="Cabut" role="tab" class="tab-pane ">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="table-responsive p-3">
                        <table style="width: 100%;" class="table align-items-center table-flush table-hover"
                            id="TbCabut">
                            <thead class="thead-light">
                                <tr>
                                    <th>No.Induk</th>
                                    <th>Customer</th>
                                    <th>alamat</th>
                                    <th>Paket</th>
                                    <th>Tanggal Cabut</th>
                                    <th>Status</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
