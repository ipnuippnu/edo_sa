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
                    <form method="POST" action="{{ route('wizard') }}" enctype="multipart/form-data">
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
                                                <input name="name" type="text" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label class="mr-2">Jenis Kelamin <span class="text-danger">*</span></label>
												<div class="selectgroup w-100">
													<label class="selectgroup-item">
                                                        <input class="selectgroup-input" type="radio" name="gender" required value="L" @checked( old('gender', auth()->user()->personal->gender) == 'L' )>
														<span class="selectgroup-button"><span class="fa fa-male mr-2"></span> Laki-laki</span>
													</label>
													<label class="selectgroup-item">
                                                        <input class="selectgroup-input" type="radio" name="gender" required value="P" @checked( old('gender', auth()->user()->personal->gender) == 'P' )>
														<span class="selectgroup-button"><span class="fa fa-female mr-2"></span> Perempuan</span>
													</label>
												</div>
											</div>

                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Tempat Lahir <span class="text-danger">*</span></label>
                                                        <input name="born_place" type="text" class="form-control" value="{{ old('born_place', auth()->user()->personal->born_place) }}" required placeholder="Trenggalek">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                                        <input name="born_date" type="text" class="form-control" value="{{ old('born_date', auth()->user()->personal->born_date) }}" required id="datepicker">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Bergabung IPNU/IPPNU Mulai Tahun <span class="text-danger">*</span></label>
                                                <input name="joined_year" type="text" class="form-control" value="{{ old('joined_year', auth()->user()->personal->joined_at) }}" placeholder="2017" required>

                                            </div>


                                        </div>
            
                                        <div class="col-md-6">

                                            <div class="form-group" x-data="$store.whatsapp">
                                                <label>No. HP / WhatsApp</label>

                                                <div class="input-group">
                                                    <input type="text" class="form-control" x-model="current" x-bind:readOnly="current != '' && current == verified">
                                                    <div class="input-group-append">
                                                        <button :class="{ 'btn btn-info': true, 'btn-success': current == verified && current != '' }" type="button" id="verify-wa" x-bind:disabled="current == verified || current == ''" >
                                                            <span x-show="current != verified || current == ''">Verifikasi!</span>
                                                            <span x-show="current == verified && current != ''">OK</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" x-data="$store.email">
                                                <label>Email</label>

                                                <div class="input-group">
                                                    <input type="text" class="form-control" x-model="current" x-bind:readOnly="current != '' && current == verified">
                                                    <div class="input-group-append">
                                                        <button :class="{ 'btn btn-info': true, 'btn-success': current == verified && current != '' }" type="button" id="verify-email" x-bind:disabled="current == verified || current == ''" >
                                                            <span x-show="current != verified || current == ''">Verifikasi!</span>
                                                            <span x-show="current == verified && current != ''">OK</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
            
                                            <div class="form-group">
                                                <label>Foto Diri <span class="text-danger">*</span></label>
                                                <div class="input-file input-file-image d-flex">
                                                    
                                                    <img class="img-upload-preview img-circle mb-0" width="100" height="100" src="http://placehold.it/300x400" alt="preview" style="object-fit: cover">
                                                    
                                                    <input type="file" class="form-control form-control-file" id="uploadImg" name="profile" accept="image/*" required>

                                                    <label for="uploadImg" class=" label-input-file btn btn-primary my-auto ml-2">Pilih Foto</label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <div class="wizard-action">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-finish btn-danger" style="display: none;">Simpan</button>
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

        (function(){

            $('#datepicker').datetimepicker({
                format: 'YYYY-MM-DD',
            });

            document.addEventListener('alpine:init', () => {

                Alpine.store('whatsapp', {
                    current: '+{{ old('phone', auth()->user()->personal->phone) }}',
                    verified: '{{ auth()->user()->personal->phone_verified_at != null ? ('+' . auth()->user()->personal->phone) : '' }}',
                })

                Alpine.store('email', {
                    current: '{{ old('phone', auth()->user()->email) }}',
                    verified: '{{ auth()->user()->email_verified_at != null ? auth()->user()->email : '' }}',
                })

                $('#verify-wa').click(async e => {
                    e.preventDefault()
                    
                    let data = Alpine.store('whatsapp')

                    try {
                        swal({
                            text: 'Mohon tunggu...',
                            closeOnClickOutside: false,
                            buttons: false
                        })
                        await new Promise((resolve, reject) => setTimeout(() => resolve(), 500))

                        await axios.post('{{ route('verify.request') }}', {
                            type: 'whatsapp',
                            contact: data.current
                        });
                    } catch (error) {
                        if(error.response.data.message != undefined)
                        {
                            swal("Gagal!", error.response.data.message, "error")
                        }
                        
                        throw null
                    }

                    swal({
                        title: 'Verifikasi WhatsApp!',
                        text: `Silahkan cek pesan WhatsApp (${data.current}).`,
                        content: "input",
                        button: {
                            text: "Verifikasi!",
                            closeModal: false,
                        },
                    })
                    .then(val => {
                        if (!val) throw null;
                        
                        return axios.post('{{ route('verify') }}', {

                            type: 'whatsapp',
                            contact: data.current,
                            code: val

                        });
                    })
                    .then(val => val.data)
                    .then(data => {
                        Alpine.store('whatsapp').verified = data.data.contact
                        swal.close()
                    })
                    .catch(() => swal.close())

                })

                $('#verify-email').click(async e => {
                    e.preventDefault()
                    
                    let data = Alpine.store('email')

                    try {
                        swal({
                            text: 'Mohon tunggu...',
                            closeOnClickOutside: false,
                            buttons: false
                        })
                        await new Promise((resolve, reject) => setTimeout(() => resolve(), 500))

                        await axios.post('{{ route('verify.request') }}', {
                            type: 'email',
                            contact: data.current
                        });
                    } catch (error) {
                        if(error.response.data.message != undefined)
                        {
                            swal("Gagal!", error.response.data.message, "error")
                        }
                        
                        throw null
                    }

                    swal({
                        title: 'Verifikasi Email!',
                        text: `Silahkan cek kotak email (${data.current}).`,
                        content: "input",
                        button: {
                            text: "Verifikasi!",
                            closeModal: false,
                        },
                    })
                    .then(val => {
                        if (!val) throw null;
                        
                        return axios.post('{{ route('verify') }}', {

                            type: 'email',
                            contact: data.current,
                            code: val

                        });
                    })
                    .then(val => val.data)
                    .then(data => {
                        Alpine.store('email').verified = data.data.contact
                        swal.close()
                    })
                    .catch(error => swal.close())

                })

            })

        })()

    </script>
    @endpush

</x-layout>