@extends('back.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sistem - {{ $subtitle }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Cek</th>
                            <th>Nama</th>
                            <th>Sekolah</th>
                            <th>Tanggal Lahir</th>
                            <th>Umur</th>
                            <th>Jenis Kelamin</th>
                            <th>Tinggi Badan</th>
                            <th>Berat Badan</th>
                            <th>Lila</th>
                            <th>HB</th>
                            <th>Total</th>
                            <th>Hasil</th>
                            <th>Deskripsi</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($hasil_sras as $p)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $p->created_at }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->sekolah }}</td>
                            <td>{{ $p->tanggal_lahir }}</td>
                            <td>{{ $p->umur }}</td>
                            <td>{{ $p->jenis_kelamin }}</td>
                            <td>{{ $p->tinggi_badan }}</td>
                            <td>{{ $p->berat_badan }}</td>
                            <td>{{ $p->lila }}</td>
                            <td>{{ $p->hb }}</td>
                            <td>{{ $p->total }}</td>
                            <td>{{ $p->hasil }}</td>
                            <td>{{ $p->deskripsi }}</td>

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
                                <div class="form-group">
                                    <label for="nama_edit">Nama</label>
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
                                    <label for="sekolah_edit">Sekolah</label>
                                    <input type="text" class="form-control" id="sekolah_edit" name="sekolah" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tinggi_badan_edit">Tinggi Badan</label>
                                    <input type="text" class="form-control" id="tinggi_badan_edit" name="tinggi_badan" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="berat_badan_edit">Berat Badan</label>
                                    <input type="text" class="form-control" id="berat_badan_edit" name="berat_badan" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="lila_edit">Lila</label>
                                    <input type="text" class="form-control" id="lila_edit" name="lila" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="hb_edit">HB</label>
                                    <input type="text" class="form-control" id="hb_edit" name="hb" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="total_edit">Total</label>
                                    <input type="text" class="form-control" id="total_edit" name="total" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="hasil_edit">Hasil</label>
                                    <input type="text" class="form-control" id="hasil_edit" name="hasil" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="deskripsi_edit">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi_edit" name="deskripsi" rows="6" readonly></textarea>
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
                url: '/hasil_sras/' + id + '/edit',
                success: function(data) {
                    // Isi field modal dengan data dari server
                    $('#id').val(data.id);
                    $('#nama_edit').val(data.nama);
                    $('#sekolah_edit').val(data.sekolah);
                    $('#tanggal_lahir_edit').val(data.tanggal_lahir);
                    $('#umur_edit').val(data.umur);
                    $('#jenis_kelamin_edit').val(data.jenis_kelamin);
                    $('#tinggi_badan_edit').val(data.tinggi_badan);
                    $('#berat_badan_edit').val(data.berat_badan);
                    $('#lila_edit').val(data.lila);
                    $('#hb_edit').val(data.hb);
                    $('#total_edit').val(data.total);
                    $('#hasil_edit').val(data.hasil);
                    $('#deskripsi_edit').val(data.deskripsi);

                    // Tampilkan modal
                    $('#modal-edit').modal('show');
                },
                error: function(xhr) {
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
                        url: '/hasil_sras/' + id,
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