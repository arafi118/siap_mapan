<h7 class="card-title" style="color:rgb(100, 121, 216); font-weight: 800;">&nbsp;&nbsp;UPLOAD LOGO</h7>
<div class="row">
    <div class="col-md-8"><br>
        <div class="card mt-4 border" data-animation="true">
            <a class="d-block blur-shadzow-image">
                <img src="{{ asset('storage/logo/' . Session::get('logo')) }}" alt="img-blur-shadow"
                    class="img-fluid shadow border-radius-lg mt-3" id="previewLogo"
                    style="width: 180px; height: auto; margin-left: 20px;">
            </a>
            <div class="colored-shadow"
                style="background-image: url(&quot;{{ asset('storage/logo/' . Session::get('logo')) }}&quot;);">
            </div>
            <div class="card-body text-center pb-0">
                <div class="d-flex mt-n6 justify-content-end">
                    <button class="btn btn-info border-0" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        data-bs-original-title="Edit" id="EditLogo">
                        <i class="fa fa-edit text-lg"></i>&nbsp;Edit Logo
                    </button>
                </div>
            </div><br>
        </div>
    </div>
</div>
<form action="/pengaturan/logo/{{ $business->id }}" method="post" enctype="multipart/form-data" id="FormLogo">
    @csrf
    @method('PUT')
    <input type="file" name="logo_busines" id="logo_busines" class="d-none">
</form>
