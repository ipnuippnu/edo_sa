<x-layout>

    <div class="panel-header">
        <div class="page-inner border-bottom pb-0 mb-3">
            <div class="d-flex align-items-left flex-column">
                <h2 class="pb-2 fw-bold">Lengkapi Data</h2>
            </div>
        </div>
    </div>
    <div class="page-inner">
        <div class="row">
            <div class="col">

                <div class="wizard-container wizard-round col-md-9">
                    <div class="wizard-header text-center">
                        <h3 class="wizard-title">Selamat Datang, <b>{{ auth()->user()->name }}</b>.</h3>
                        <small>Terima kasih telah menjadi keluarga besar EDO. Silahkan melengkapi profil kamu untuk mendapatkan berbagai akses layanan.</small>
                    </div>
                    <form method="POST" action="{{ route('wizard') }}">
                        @csrf
                        <div class="wizard-body">
                            <div class="row">
            
                                <ul class="wizard-menu nav nav-pills nav-primary">
                                    <li class="step">
                                        <a class="nav-link" href="#" data-toggle="tab"><i class="fa fa-user mr-2"></i> Info Personal</a>
                                    </li>
                                </ul>

                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                                <input name="name" type="text" class="form-control" value="{{ auth()->user()->name }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label class="mr-2">Jenis Kelamin <span class="text-danger">*</span></label>
												<div class="selectgroup w-100">
													<label class="selectgroup-item">
                                                        <input class="selectgroup-input" type="radio" name="gender" required value="L" @checked( auth()->user()->personal->gender == 'L' )>
														<span class="selectgroup-button"><span class="fa fa-male mr-2"></span> Laki-laki</span>
													</label>
													<label class="selectgroup-item">
                                                        <input class="selectgroup-input" type="radio" name="gender" required value="P" @checked( auth()->user()->personal->gender == 'P' )>
														<span class="selectgroup-button"><span class="fa fa-female mr-2"></span> Perempuan</span>
													</label>
												</div>
											</div>

                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Tempat Lahir <span class="text-danger">*</span></label>
                                                        <input name="born_place" type="text" class="form-control" value="{{ auth()->user()->personal->born_place }}" required placeholder="Trenggalek">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                                        <input name="born_date" type="text" class="form-control" value="{{ auth()->user()->personal->born_date }}" required id="datepicker">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>No. HP / WhatsApp <span class="text-danger">*</span></label>

                                                <div class="input-group">
                                                    <input name="phone" type="text" class="form-control" value="+{{ auth()->user()->personal->phone }}" required>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-info" type="button">Verifikasi!</button>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
            
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label>Email</label>

                                                <div class="input-group">
                                                    <input name="email" type="email" class="form-control" value="{{ auth()->user()->email }}" required>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-info" type="button">Verifikasi!</button>
                                                    </div>
                                                </div>
                                            </div>
            
                                            <div class="form-group">
                                                <label>Foto Formal</label>
                                                <div class="input-file input-file-image">
                                                    <div class="row">
                                                        <div class="col-auto">
                                                            <img class="img-upload-preview img-circle" width="100" height="100" src="http://placehold.it/300x400" alt="preview" style="object-fit: cover">
                                                            <input type="file" class="form-control form-control-file" id="uploadImg" name="uploadImg" accept="image/*" required>
                                                            <label for="uploadImg" class=" label-input-file btn btn-primary">Pilih Foto</label>
                                                        </div>
                                                        <div class="col-md col-12">
                                                            <div class="mt-4 mt-xl-0 alert alert-info">Foto ini digunakan untuk keperluan Kartu Tanda Anggota (KTA).
                                                            <br />
                                                            <br />
                                                            Ketentuan:
                                                            <div class="row gap-0">
                                                                <div class="col-auto pr-0">
                                                                    1.
                                                                </div>
                                                                <div class="col">
                                                                    IPNU (<i>Background</i> Biru), IPPNU (<i>Background</i> Merah)
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-auto pr-0">
                                                                    2.
                                                                </div>
                                                                <div class="col">
                                                                    Memakai atribut organisasi / kemeja putih
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-auto pr-0">
                                                                    3.
                                                                </div>
                                                                <div class="col">
                                                                    Foto berskala 3:4
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <div class="wizard-action">
                            <div class="pull-left">
                                <input type="button" class="btn btn-previous btn-fill btn-black" name="previous" value="Sebelumnya">
                            </div>
                            <div class="pull-right">
                                <input type="button" class="btn btn-next btn-danger" name="next" value="Selanjutnya">
                                <input type="submit" class="btn btn-finish btn-danger" name="finish" value="Selesai" style="display: none;">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    let a = $('#datepicker').datetimepicker({
        format: 'YYYY-MM-DD',
    });
    </script>
    @endpush

</x-layout>