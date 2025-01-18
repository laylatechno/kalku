@extends('back.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Catering Pro - {{ $subtitle }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Cek</th>
                            <th>Nama</th>
                            <th>Nama Orang Tua</th>
                            <th>No WA</th>
                            <th>Tanggal Lahir</th>
                            <th>Umur</th>
                            <th>Jenis Kelamin</th>
                            <th>Wilayah Puskesmas</th>
                            <th>Total Ya</th>
                            <th>Interpretasi</th>
                            <th>Jawaban</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($hasil_kpsp as $p)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $p->created_at }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->nama_ortu }}</td>
                            <td>{{ $p->no_wa }}</td>
                            <td>{{ $p->tanggal_lahir }}</td>
                            <td>{{ $p->umur }}</td>
                            <td>{{ $p->jenis_kelamin }}</td>
                            <td>{{ $p->wilayah_puskesmas }}</td>
                            <td>{{ $p->total_ya }}</td>
                            <td>{{ $p->interpretasi }}</td>
                            <td>{{ $p->jawaban }}</td>

                            <td>
                                <a href="#" class="btn btn-sm btn-warning btn-edit" data-toggle="modal"
                                    data-target="#modal-edit" data-id="{{ $p->id }}" style="color: black">
                                    <i class="fas fa-edit"></i> Detail
                                </a>
                                <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $p->id }}"
                                    style="color: white">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>


            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>



{{-- Modal Edit Data --}}
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Lengkap</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group" id="nama_ortu_edit_container">
                                    <label for="nama_ortu_edit">Nama Orang Tua</label>
                                    <input type="text" class="form-control" name="nama_ortu" id="nama_ortu_edit" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group" id="no_wa_edit_container">
                                    <label for="no_wa_edit">No WA</label>
                                    <input type="text" class="form-control" name="no_wa" id="no_wa_edit" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="nama_edit">Nama Anak</label>
                                    <input type="text" class="form-control" id="nama_edit" name="nama_anak" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tanggal_lahir_edit">Tanggal Lahir</label>
                                    <input type="text" class="form-control" id="tanggal_lahir_edit" name="tanggal_lahir" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="umur_edit">Umur</label>
                                    <input type="text" class="form-control" id="umur_edit" name="umur" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="jenis_kelamin_edit">Jenis Kelamin</label>
                                    <input type="text" class="form-control" id="jenis_kelamin_edit" name="jenis_kelamin" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="wilayah_puskesmas_edit">Wilayah Puskesmas</label>
                                    <input type="text" class="form-control" id="wilayah_puskesmas_edit" name="wilayah_puskesmas" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="total_ya_edit">Total Ya</label>
                                    <input type="text" class="form-control" id="total_ya_edit" name="total_ya" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="interpretasi_edit">Interpretasi</label>
                                    <input type="text" class="form-control" id="interpretasi_edit" name="interpretasi" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="jawaban_edit">Jawaban</label>
                                    <input type="text" class="form-control" id="jawaban_edit" name="jawaban" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>






@endsection




@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

{{-- PERINTAH EDIT DATA --}}
<script>
    $(document).ready(function() {
        $('.btn-edit').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                method: 'GET',
                url: '/hasil_kpsp/' + id + '/edit',
                success: function(data) {
                    // Mengisi nilai input sesuai dengan elemen yang ada di tabel
                    $('#id').val(data.id);
                    $('#nama_edit').val(data.nama); // Nama Anak
                    $('#tanggal_lahir_edit').val(data.tanggal_lahir); // Tanggal Lahir
                    $('#umur_edit').val(data.umur); // Umur
                    $('#jenis_kelamin_edit').val(data.jenis_kelamin); // Jenis Kelamin
                    $('#wilayah_puskesmas_edit').val(data.wilayah_puskesmas); // Wilayah Puskesmas
                    $('#total_ya_edit').val(data.total_ya); // Total Ya
                    $('#interpretasi_edit').val(data.interpretasi); // Interpretasi
                    $('#jawaban_edit').val(data.jawaban); // Jawaban
                    $('#nama_ortu_edit').val(data.nama_ortu); // Nama Orang Tua
                    $('#no_wa_edit').val(data.no_wa); // No WA

                    // Menampilkan modal edit
                    $('#modal-edit').modal('show');
                },
                error: function(xhr) {
                    // Tangani kesalahan jika ada
                    alert('Error: ' + xhr.statusText);
                }
            });
        });
    });
</script>


{{-- PERINTAH EDIT DATA --}}


{{-- PERINTAH DELETE DATA --}}
<script>
    $(document).ready(function() {
        $('.dataTable tbody').on('click', 'td .btn-hapus', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            Swal.fire({
                title: 'Apakah yakin akan menghapus data ?',
                text: "data tidak bisa dikembalikan jika sudah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika dikonfirmasi, lakukan permintaan AJAX ke endpoint penghapusan
                    $.ajax({
                        url: '/hasil_kpsp/' + id,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.hasOwnProperty('message') && response
                                .message.includes(
                                    'terkait dengan mutasi_surat-keluar')) {
                                Swal.fire({
                                    title: 'Oops!',
                                    text: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            } else if (response.hasOwnProperty('message') &&
                                response.message === 'Data Berhasil Dihapus') {
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed || result
                                        .isDismissed) {
                                        location
                                            .reload(); // Merefresh halaman saat pengguna menekan OK pada SweetAlert
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: response.message ||
                                        'Gagal menghapus data',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat menghapus data/masih terkait dengan tabel lain',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            console.log(xhr
                                .responseText
                            ); // Tampilkan pesan error jika terjadi
                        }
                    });
                }
            });
        });
    });
</script>
{{-- PERINTAH DELETE DATA --}}
@endpush