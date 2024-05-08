<x-layout-auth>

<h3 class="text-center">Pendaftaran Anggota</h3>

@if($errors->any())
<div class="alert alert-warning">
	{!! $errors->first() !!}
</div>
@endif

{{-- <div class="alert alert-info">
    Layanan ini hanya dapat digunakan untuk membuat akun personal. <br>Jika anda ingin menambah/mengaktifkan pimpinan baru, silahkan hubungi <a href="//wa.me/6285175303855" target="_blank">Pengelola</a>.
</div> --}}
<form class="login-form" action="" method="POST" autocomplete="off">

    <hr>
    <div class="form-group">
        <label for="phone" class="placeholder"><b>Nomor WhatsApp</b> </label>
        <input  id="phone" name="phone" type="text" class="form-control" value="{{ old('phone') }}">
    </div>
    <div class="form-group">
        <label for="email" class="placeholder"><b>Email</b> </label>
        <input  id="email" name="email" type="text" class="form-control" value="{{ old('email') }}">
        <small class="form-text text-muted">Anda dapat menggunakan salah satu atau keduanya <b>(Email dan/atau No. WhatsApp)</b></small>
    </div>
    <hr>
    
    <div class="form-group">
        <label for="fullname" class="placeholder"><b>Nama Lengkap</b> <span class="text-danger">*</span></label>
        <input  id="fullname" name="fullname" type="text" class="form-control" required value="{{ old('fullname') }}">
    </div>
    <div class="form-check">
        <label>Gender</label> <span class="text-danger">*</span><br>
        <label class="form-radio-label">
            <input class="form-radio-input" type="radio" name="gender" required value="L" @checked( old('gender') == 'L' || old('gender') == "" )>
            <span class="form-radio-sign">Laki-laki</span>
        </label>
        <label class="form-radio-label ml-3">
            <input class="form-radio-input" type="radio" name="gender" required value="P" @checked( old('gender') == 'P' )>
            <span class="form-radio-sign">Perempuan</span>
        </label>
    </div>

    @csrf

    <div class="form-group">
        <label for="password" class="placeholder"><b>Buat Sandi</b> <span class="text-danger">*</span></label>
        <div class="position-relative">
            <input  id="password" name="password" type="password" class="form-control" required>
            <div class="show-password">
                <i class="icon-eye"></i>
            </div>
        </div>
    </div>

    <div class="row form-sub m-0">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="agree" id="agree" required>
            <label class="custom-control-label" for="agree">Saya menyetujui PD-PRT Organisasi</label> <span class="text-danger">*</span>
        </div>
    </div>
    <div class="row form-action">
        <div class="col-md-6">
            <a href="{{ route('login') }}" class="btn btn-danger btn-link w-100 fw-bold">Sudah Punya Akun</a>
        </div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary w-100 fw-bold">Buat Akun</submit>
        </div>
    </div>
</form>

</x-layout-auth>