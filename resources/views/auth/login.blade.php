<x-layout-auth>

<h3 class="text-center">Masuk ke EDO</h3>

@if($errors->any())
<div class="alert alert-warning">
	{{ $errors->first() }}
</div>
@elseif(Session::has('auth'))
<div class="alert alert-info">
	{{ Session::get('auth') }}
</div>
@endif

<form class="login-form" method="POST" action="">
	<div class="form-group">
		<label for="username" class="placeholder"><b>Email / No. HP</b></label>
		<input id="username" name="username" type="text" class="form-control" value="{{ old('username') }}" required>
	</div>
	<div class="form-group">
		<label for="password" class="placeholder"><b>Kata Sandi</b></label>
		{{-- <a href="#" class="link float-right">Lupa Sandi ?</a> --}}
		<div class="position-relative">
			<input id="password" name="password" type="password" class="form-control" required>
			<div class="show-password">
				<i class="icon-eye"></i>
			</div>
		</div>
	</div>
	@csrf
	<div class="form-group form-action-d-flex mb-3">
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="rememberme" name="remember" checked>
			<label class="custom-control-label m-0" for="rememberme">Ingat di sini</label>
		</div>
		<button type="submit" class="btn btn-primary col-md-5 float-right mt-3 mt-sm-0 fw-bold">Masuk</button>
	</div>
	<div class="login-account">
		<span class="msg">Anda baru disini ?</span>
		<a href="{{ route('signup') }}" class="link">Daftar Anggota</a>
	</div>
</form>

</x-layout-auth>