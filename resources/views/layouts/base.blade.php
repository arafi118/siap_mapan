<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    {{-- <title>{{ $title }}</title> --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"
        integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css">
    <link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/ruang-admin-min.css" rel="stylesheet">
    <link href="/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


    <!-- Bootstrap DatePicker -->

</head>
<style>
    .btn-white-custom {
        display: flex;
        align-items: center;
        background-color: rgb(253, 12, 12);
        color: black;
        border-color: #ffffff;
        /* Menjaga warna border asli */
    }

    .btn-white-custom:hover,
    .btn-white-custom:focus,
    .btn-white-custom.active {
        background-color: #202b3c;
        /* Warna asli saat aktif atau hover */
        color: rgb(250, 251, 255);
    }

    .left-align {
        display: flex;
        align-items: center;
    }

    .left-align span {
        font-size: 13px;
        /* Adjust the text size as needed */
    }

    HEAD .align-right {
        text-align: right;
        /* Mengatur teks dalam elemen ke kanan */
    }

    .custom-modal .modal-dialog {
        max-width: 600px;
        /* Atur lebar */
        margin: auto;
        /* Tengah */
    }

    @media (max-width: 768px) {
        .custom-modal .modal-dialog {
            max-width: 90%;
            /* Sesuaikan untuk layar kecil */
        }

        .custom-modal .modal-content {
            height: auto;
            /* Biarkan otomatis */
        }
    }

    .custom-modal .modal-content {
        height: 400px;
        /* Atur tinggi */
    }

    .form-label {
        font-size: 12px;
        /* Atur ukuran sesuai kebutuhan */
        font-weight: normal;
        /* Tambahkan jika ingin teks lebih ringan */
    }

    .align-right {
        text-align: right;
        /* Mengatur teks dalam elemen ke kanan */
    }

    .modal-open .select2-dropdown {
        z-index: 10060;
    }

    .modal-open .select2-close-mask {
        z-index: 10055;
    }

    th {
        font-size: 11px;
    }

    td {
        font-size: 13px;
    }

    .custom-button {
        width: 200px;
        /* Atur panjang tombol sesuai kebutuhan */
        float: right;
        /* Tempatkan tombol di sebelah kanan */
        text-align: center;
        /* Pusatkan teks di tombol */
        background-color: #000000;
        /* Warna latar belakang */
        color: rgb(80, 43, 43);
        /* Warna teks */
        border: none;
        /* Hilangkan border */
        border-radius: 5px;
        /* Atur radius sudut */
        cursor: pointer;
        /* Ubah kursor saat dihover */
    }

    .custom-button:hover {
        background-color: #495057;
        /* Warna latar belakang saat dihover */
    }


    .nav-pills {
        display: flex;
        justify-content: space-between;
        /* Jarak merata */
        padding: 0;
        /* Hapus padding default */
        list-style: none;
        /* Hapus bullet */
        text-align: center;
    }

    .nav-pills .nav-link {
        width: 160px;
        /* Atur jarak antar tombol */
    }



    /* Target form labels */
    form#Penduduk label {
        font-size: 0.85rem;
        /* Adjust as needed */
    }

    /* Target form input fields and select dropdowns */
    form#Penduduk input,
    form#Penduduk select {
        font-size: 0.85rem;
        /* Adjust as needed */
    }

    /* Small text for error messages */
    form#Penduduk small.text-danger {
        font-size: 0.75rem;
        /* Adjust as needed */
    }

    /* CSS untuk .app-wrapper-title */
    .app-title {
        background-color: #c0c4c5;
        /* Warna latar belakang untuk app-page-title */
        padding: 20px;
        /* Padding untuk ruang di sekitar konten */
        border-radius: 8px;
        /* Membuat sudut melengkung */
        margin-bottom: 10px;
        /* Jarak bawah dari elemen lain */
    }

    /* CSS untuk .page-title-wrapper */
    .app-wrapper {
        display: flex;
        /* Gunakan flexbox untuk mengatur tata letak */
        align-items: center;
        /* Menyelaraskan item di tengah secara vertikal */
    }

    /* CSS untuk .page-title-heading */
    .app-heading {
        display: flex;
        /* Gunakan flexbox untuk mengatur tata letak */
        align-items: center;
        /* Menyelaraskan item di tengah secara vertikal */
    }

    /* CSS untuk .app-bg-icon */
    .app-bg-icon {
        display: flex;
        /* Gunakan flexbox untuk mengatur tata letak ikon */
        align-items: center;
        /* Menyelaraskan ikon di tengah secara vertikal */
        justify-content: center;
        /* Menyelaraskan ikon di tengah secara horizontal */
        width: 40px;
        /* Lebar tetap untuk ikon */
        height: 40px;
        /* Tinggi tetap untuk ikon */
        background-color: #c0c4c505;
        /* Warna latar belakang untuk ikon */
        border-radius: 10%;
        /* Membuat ikon menjadi lingkaran */
        margin-right: 15px;
        /* Jarak kanan dari teks */
    }


    /* CSS untuk .page-title-subheading */
    .app-text_fount {
        font-size: 14px;
        /* Ukuran font untuk subjudul */
        color: #373636;
        /* Warna teks untuk subjudul */
        margin-top: 15px;
        /* Jarak atas dari judul */
    }

    .btn-purple {
        background-color: purple;
        color: white;
        border-color: purple;
    }

    .small-font-form {
        font-size: 10px;
    }

    .custom-button {
        width: 200px;
        /* Atur panjang tombol sesuai kebutuhan */
        float: right;
        /* Tempatkan tombol di sebelah kanan */
        text-align: center;
        /* Pusatkan teks di tombol */
        background-color: #2280de;
        /* Warna latar belakang */
        color: white;
        /* Warna teks */
        border: none;
        /* Hilangkan border */
        border-radius: 5px;
        /* Atur radius sudut */
        cursor: pointer;
        /* Ubah kursor saat dihover */
    }

    .custom-button:hover {
        background-color: #495057;
        /* Warna latar belakang saat dihover */
    }

</style>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.navbar')
                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    @yield('content')
                </div>
                <!---Container Fluid-->
            </div>
            <!-- Footer -->
            @include('layouts.footer')
            <!-- Footer -->
        </div>
    </div>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @yield('modal')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/assets/vendor/jquery/jquery.min.js"></script>
    <script src="/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="/assets/js/ruang-admin-min.js"></script>
    <script src="/assets/vendor/chart.js/Chart.min.js"></script>
    <script src="/assets/js/demo/chart-area-demo.js"></script>
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugins -->
    <script src="/assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.js"
        integrity="sha512-+UiyfI4KyV1uypmEqz9cOIJNwye+u+S58/hSwKEAeUMViTTqM9/L4lqu8UxJzhmzGpms8PzFJDzEqXL9niHyjA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"
        integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @yield('script')
</body>

</html>
