<x-layout>
<x-slot:title>Riwayat Pengkaderan</x-slot:title>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Pengkaderan Anda</h4>
                <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addRowModal">
                    <i class="fa fa-plus mr-2"></i>
                    Tambah
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Modal -->
            <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">
                                <span class="fw-mediumbold">
                                Tambah</span> 
                                <span class="fw-light">
                                    Pengkaderan
                                </span>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{-- <p class="small"><b>Informasi!</b> Anda hanya dapat menambahkan riwayat pendidikan yang sudah tuntas/lulus.</p> --}}


                            <form x-data="$store.pengkaderan" method="POST" action="" id="formulir">
                                @csrf
                                <div class="row">

                                    <div class="col-12">
                                        <div class="select2-input" x-show="!kosong">
                                            <select id="pengkaderan" name="pengkaderan" class="form-control" x-bind:required="!kosong">
                                                <option value="">Cari Kegiatan Pengkaderan</option>
                                            </select>
                                            <p class="mb-0 text-muted">Anda dapat mencari dengan menggunakan Nama Kegiatan, Nama Pimpinan, dan/atau Tahun Pelaksanaan</p>
                                        </div>
                                    </div>

                                </div>
                                <div class="row" x-show="kosong">

                                    <div class="col-12">
                                        <button x-on:click="reset" class="btn btn-primary"><i class="fas fa-arrow-left mr-2"></i> Kembali ke Pencarian</button>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Jenis Pengkaderan</label>
                                            <div class="selectgroup w-100">
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="jenis" x-model="jenis" value="formal" class="selectgroup-input" checked="" x-bind:required="kosong">
                                                    <span class="selectgroup-button">FORMAL</span>
                                                </label>
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="jenis" x-model="jenis" value="non-formal" class="selectgroup-input" x-bind:required="kosong">
                                                    <span class="selectgroup-button">NON - FORMAL</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group" x-show="jenis == 'formal'">
                                            <label>Jenjang Pengkaderan <span class="text-danger">*</span></label>
                                            <select id="jenjang" name="jenjang" class="form-control" x-model="jenjang" x-bind:required="kosong">
                                                @foreach(App\Models\FormalTrainingLevel::get()->groupBy('pelaksana') as $pelaksana => $levels)
                                                <optgroup label="{{ $pelaksana }}">
                                                @foreach($levels as $level)
                                                <option value="{{ $level->name }}">{{  "($level->name) " . $level->fullname }}</option>
                                                @endforeach
                                                </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <template x-if="jenis != 'formal'">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Nama Kegiatan Pengkaderan <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="nama" x-model="nama" x-bind:required="kosong">
                                                <p class="mb-0 text-muted">Mohon tidak menyertakan nama pimpinan pelaksana & tahun pada kolom nama kegiatan</p>
                                            </div>
                                        </div>
                                    </template>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Dilaksanakan Oleh <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="pelaksana" x-model="pelaksana" x-bind:required="kosong">
                                            <p class="mb-0 text-muted">Jika pelaksana adalah Ranting/Komisariat, sertakan kecamatan. Contoh: "PR IPNU-IPPNU Pakel, Watulimo"</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Tahun Pelaksanaan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="year" x-model="year" x-bind:required="kosong">
                                        </div>
                                    </div>
                                    

                                </div>
                            </form>

                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-primary" onclick="$('#formulir').submit()">Simpan</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="trainings" class="display table table-striped table-hover" >
                    <thead>
                        <tr>
                            <th style="width: 5%">Aksi</th>
                            <th>Jenis</th>
                            <th>Nama Pengkaderan</th>
                            <th>Pelaksana</th>
                            <th>Tahun Pelaksanaan</th>
                        </tr>
                    </thead>
                    {{-- <tfoot>
                        <tr>
                            <th>Jenis</th>
                            <th>Nama Pengkaderan</th>
                            <th>Pelaksana</th>
                            <th>Tahun Pelaksanaan</th>
                        </tr>
                    </tfoot> --}}
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (async () => {

        let jenjang = $('#jenjang').select2({
            theme: 'bootstrap', width: '100%',
            dropdownParent: $('#addRowModal'),
        })

        let pengkaderan = $('#pengkaderan').select2({
            allowClear: true,
            width: '100%',
            dropdownParent: $('#addRowModal'),
            theme: "bootstrap",
            ajax: {
                url: '{{ route('trainings') }}',
                dataType: 'json',
                delay: 500
            }
        });

        document.addEventListener('alpine:init', () => {
            Alpine.store('pendidikan', {
                'jurusan': '{{ old('jurusan') }}',
                'graduated_at': '{{ old('graduated_at') }}',
                'jenjang': '{{ old('jenjang', 1) }}',
                'name': '{{ old('name') }}'
            })

            Alpine.store('pengkaderan', {
                'kosong': false,
                'jenis': 'formal',
                'year': '',
                'jenjang': '',
                'pelaksana': '',
                'nama': '',
                reset(){
                    this.kosong = false
                    pengkaderan.val(null).trigger('change')
                }
            })
        })

        jenjang.on('select2:select', function(e) {
            Alpine.store('pengkaderan').jenjang = e.target.value
        })

        pengkaderan.on('select2:select', function(e) {
            let data = e.params.data
            if(data.id == "_null")
            {
                Alpine.store('pengkaderan').kosong = true
            }
        })

        const table = $('#trainings').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('trainings') }}',
            order: [[1, 'asc']],
            columns: [
                {orderable: false, render(a, b, c){

                    return `

                        <div class="d-flex">
                            <button class="btn btn-sm btn-danger mr-1 delete" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>

                    `
                    
                }},
                {data: 'is_formal', render(data){
                    if(data === true) return `<span class="badge badge-success">FORMAL</span>`
                    return '<span class="badge badge-secondary">NON-FORMAL</span>'
                } },
                {data: 'name'},
                {data: 'pelaksana'},
                {data: 'year'}
            ]
        });

        table.on('click', '.delete', async function(){
            let data = table.row(this.parentElement.parentElement).data()
            swal({
                title: `Yakin hapus data ${data.name}?`,
                text: `Setelah dihapus, Anda tidak dapat mengurungkan aksi ini.`,
                type: 'warning',
                buttons: {confirm: true, cancel: true}
            }).then(Delete => {
                if(Delete)
                {
                    return axios.post(`{{ route('trainings') }}/${data.id}`, {
                        '_method': 'DELETE',
                    }).then(res => res.data).then(res => {
                        $.notify({
                            message: res.message,
                            icon: 'fa fa-info',
                            title: 'Informasi!'
                        },{
                            type: 'primary',
                            placement: {
                                from: 'top',
                                align: 'right'
                            },
                            time: 1000,
                            delay: 0,
                        });

                        table.ajax.reload()
                    })
                }
            })
        })

    })()

    
</script>
@endpush

</x-layout>