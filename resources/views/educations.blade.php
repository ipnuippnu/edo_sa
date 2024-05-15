<x-layout>
<x-slot:title>Riwayat Pendidikan</x-slot:title>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Daftar Riwayat Pendidikan</h4>
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
                                    Riwayat Pendidikan
                                </span>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="small"><b>Informasi!</b> Anda hanya dapat menambahkan riwayat pendidikan yang sudah tuntas/lulus.</p>
                            <form x-data="$store.pendidikan" method="POST" action="" id="formulir">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group form-group-default">
                                            <label>Jenjang Pendidikan <span class="text-danger">*</span></label>
                                            <select id="jenjang" name="jenjang" class="form-control" required x-model="jenjang">
                                                @foreach(App\Enums\SchoolLevel::cases() as $level)
                                                <option value="{{ $level->value }}">{{ $level->fullName() }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Nama Instansi <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" required name="name" x-model="name">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Lulus Tahun <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" required name="graduated_at" x-model="graduated_at">
                                        </div>
                                    </div>
                                    <div class="col-md-6" >
                                        <template x-if="jenjang != 1 && jenjang != 2">
                                            <div class="form-group form-group-default mb-0">
                                                <label>Jurusan <span class="text-danger" x-show="jenjang != 3">*</span></label>
                                                <input type="text" class="form-control" x-bind:required="jenjang != 3" name="jurusan" x-model="jurusan">
                                            </div>
                                        </template>
                                        <p class="text-muted" x-show="jenjang == 3">Kosongkan jika tidak perlu</p>
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
                <table id="educations" class="display table table-striped table-hover" >
                    <thead>
                        <tr>
                            <th>Jenjang</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Lulus Tahun</th>
                            <th style="width: 10%">Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Jenjang</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Lulus Tahun</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
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
        document.addEventListener('alpine:init', () => {
            Alpine.store('pendidikan', {
                'jurusan': '{{ old('jurusan') }}',
                'graduated_at': '{{ old('graduated_at') }}',
                'jenjang': '{{ old('jenjang', 1) }}',
                'name': '{{ old('name') }}'
            })
        })

        const table = $('#educations').DataTable({
            searching: false,
            ajax: '{{ route('educations') }}',
            order: [[3, 'desc']],
            columns: [
                {data: 'jenjang', orderable: false },
                {data: 'name', orderable: false},
                {data: 'jurusan', orderable: false},
                {data: 'graduated_at'},
                {orderable: false, render(a, b, c){

                    return $('<button>  ').attr('data-toggle', 'tooltip').attr('data-original-title', 'Hapus')
                                        .attr('class', 'btn btn-link btn-danger delete')
                                        .html('<span class="fas fa-trash"></span>')
                                        .prop('outerHTML');
                }},
            ]
        });

        table.on('click', '.delete', async function(){
            let data = table.row(this.parentElement.parentElement).data()
            swal({
                title: `Yakin hapus data ${data.name}?`,
                text: `Anda tidak dapat membatalkan aksi ini!`,
                type: 'warning',
                buttons: {confirm: true, cancel: true}
            }).then(Delete => {
                if(Delete)
                {
                    return axios.post(`{{ route('educations') }}/${data.id}`, {
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