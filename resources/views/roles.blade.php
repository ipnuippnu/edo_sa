<x-layout>
<x-slot:title>Jabatan Pimpinan</x-slot:title>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Daftar Jabatan Anda di Pimpinan Se-Kab. Trenggalek</h4>
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
                                    Jabatan Baru
                                </span>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <p class="small"><b>Informasi!</b> Jika pimpinan / jabatan tidak tersedia pada pilihan, silahkan menghubungi <a href="//wa.me/{{ config('app.admin.phone') }}" target="_blank">Pengelola</a>.</p>


                            <form x-data="$store.formulir" method="POST" action="" id="formulir">
                                @csrf
                                <div class="row">

                                    <div class="col-12">

                                        <div class="select2-input mb-4">
                                            <label class="mb-2">Pilih Pimpinan <span class="text-danger">*</span></label>

                                            <select id="pimpinan" name="pimpinan" class="form-control" x-model="pimpinan">
                                                {{-- <option value="">Cari Pimpinan</option> --}}
                                            </select>

                                        </div>

                                        <div class="select2-input mb-4">
                                            <label class="mb-2">Jenis Jabatan <span class="text-danger">*</span></label>

                                            <select id="jabatan" name="jabatan" class="form-control" x-model="jabatan">
                                                {{-- <option value="">Cari Jabatan</option> --}}
                                            </select>

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
                <table id="table" class="display table table-striped table-hover" >
                    <thead>
                        <tr>
                            <th style="width: 5%">Aksi</th>
                            <th>Status</th>
                            <th>Nama Pimpinan</th>
                            <th>Jabatan</th>
                            <th>Ditambahkan Pada</th>
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

        document.addEventListener('alpine:init', () => {
            Alpine.store('formulir', {
                'jabatan': '',
                'pimpinan': '',
            })
        })

        $('#pimpinan').select2({
            placeholder: 'Cari Pimpinan',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#addRowModal'),
            theme: "bootstrap",
            ajax: {
                url: '{{ route('pimpinans') }}',
                dataType: 'json',
                delay: 500
            }
        }).on('select2:select', (e) => Alpine.store('formulir').pimpinan = e.target.value)

        $('#jabatan').select2({
            placeholder: 'Cari Jabatan',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#addRowModal'),
            theme: "bootstrap",
            ajax: {
                url: '{{ route('roles') }}',
                dataType: 'json',
                delay: 500
            }
        }).on('select2:select', (e) => Alpine.store('formulir').jabatan = e.target.value)

        const table = $('#table').DataTable({
            // processing: true,
            // serverSide: true,
            ajax: '{{ route('roles') }}',
            order: [[1, 'asc']],
            columnDefs: [{
                targets: 4,
                render: data => moment(data).fromNow()
            }],
            columns: [
                {orderable: false, searchable: false, render(a, b, c){

                    return `
                        <div class="d-flex">
                            <button class="btn btn-sm btn-danger mr-1 delete" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>
                    `
                    
                }},
                {data: 'confirmed_at', orderable: false, searchable: false, render(data){
                    if(data != null) return `<span class="badge badge-success">VALID</span>`
                    return '<span class="badge badge-secondary">MENUNGGU ACC</span>'
                } },
                {data: 'team_name'},
                {data: 'display_name'},
                {data: 'created_at', orderable: false, searchable: false}
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