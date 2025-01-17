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
                    <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-tambah"><i
                            class="fas fa-plus-circle"></i> Tambah Data</a>

                    <table id="produkTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>



    {{-- Modal Tambah Data --}}
    <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form {{ $subtitle }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Main content -->

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <!-- /.card-header -->

                        <!-- form start -->
                        <form id="form-tambah" action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-6">
                                        <div class="form-group" id="nama_produk_container">
                                            <label for="nama_produk">Nama Produk</label>
                                            <input type="text" class="form-control" name="nama_produk" id="nama_produk"
                                                placeholder="Nama Produk">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="kategori_produk_id">Kategori</label>
                                            <select class="form-control select2" name="kategori_produk_id"
                                                id="kategori_produk_id" required>
                                                <option value="">--Pilih Kategori--</option>
                                                @foreach ($kategoriProduk as $kategori)
                                                    <option value="{{ $kategori->id }}">
                                                        {{ $kategori->nama_kategori_produk }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="harga_beli_container">
                                            <label for="harga_beli">Harga Beli</label>
                                            <input type="text" class="form-control " name="harga_beli" id="harga_beli"
                                                placeholder="Harga Beli">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="harga_jual_container">
                                            <label for="harga_jual">Harga Jual</label>
                                            <input type="text" class="form-control " name="harga_jual" id="harga_jual"
                                                placeholder="Harga Jual">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group" id="deskripsi_container">
                                            <label for="deskripsi">Deskripsi</label>
                                            <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="2"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group" id="stok_container">
                                            <label for="stok">Stok</label>
                                            <input type="number" class="form-control" name="stok" id="stok"
                                                placeholder="Stok">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group" id="gambar_container">
                                            <label for="gambar">Gambar</label>
                                            <input type="file" class="form-control" name="gambar" id="gambar"
                                                onchange="previewImage()">
                                            <canvas id="preview_canvas"
                                                style="display: none; max-width: 100%; margin-top: 10px;"></canvas>
                                            <img id="preview_image" src="#" alt="Preview Gambar"
                                                style="display: none; max-width: 100%; margin-top: 10px;">
                                        </div>
                                    </div>

                                    <script>
                                        function previewImage() {
                                            var previewCanvas = document.getElementById('preview_canvas');
                                            var previewImage = document.getElementById('preview_image');
                                            var fileInput = document.getElementById('gambar');
                                            var file = fileInput.files[0];
                                            var reader = new FileReader();

                                            reader.onload = function(e) {
                                                var img = new Image();
                                                img.src = e.target.result;

                                                img.onload = function() {
                                                    var canvasContext = previewCanvas.getContext('2d');
                                                    var maxWidth = 200; // Max width untuk pratinja gambar

                                                    var scaleFactor = maxWidth / img.width;
                                                    var newHeight = img.height * scaleFactor;

                                                    previewCanvas.width = maxWidth;
                                                    previewCanvas.height = newHeight;

                                                    canvasContext.drawImage(img, 0, 0, maxWidth, newHeight);

                                                    // Menampilkan pratinja gambar setelah diperkecil
                                                    previewCanvas.style.display = 'block';
                                                    previewImage.style.display = 'none';
                                                };
                                            };

                                            if (file) {
                                                reader.readAsDataURL(file); // Membaca file yang dipilih sebagai URL data
                                            } else {
                                                previewImage.src = '';
                                                previewCanvas.style.display = 'none'; // Menyembunyikan pratinja gambar jika tidak ada file yang dipilih
                                            }
                                        }
                                    </script>

                                    <div class="col-6">
                                        <div class="form-group" id="status_container">
                                            <label for="status_edit">Status</label>
                                            <select class="form-control" name="status" id="status_edit">
                                                <option value="">--Pilih Status--</option>
                                                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>
                                                    Aktif
                                                </option>
                                                <option value="Non Aktif"
                                                    {{ old('status') == 'Non Aktif' ? 'selected' : '' }}>
                                                    Non Aktif
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group" id="status_diskon_container">
                                            <label for="status_diskon_edit">Status Diskon</label>
                                            <select class="form-control" name="status_diskon" id="status_diskon_edit">
                                                <option value="">--Pilih Status Diskon--</option>
                                                <option value="Aktif"
                                                    {{ old('status_diskon') == 'Aktif' ? 'selected' : '' }}>
                                                    Aktif
                                                </option>
                                                <option value="Non Aktif"
                                                    {{ old('status_diskon') == 'Non Aktif' ? 'selected' : '' }}>
                                                    Non Aktif
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group" id="harga_jual_diskon_container">
                                            <label for="harga_jual_diskon">Harga Jual Diskon</label>
                                            <input type="number" class="form-control" name="harga_jual_diskon"
                                                id="harga_jual_diskon" placeholder="Harga Jual Diskon">
                                        </div>
                                    </div>




                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" id="btn-save-tambah"><i
                                            class="fas fa-save"></i> Simpan</button>
                                    <button type="button" class="btn btn-danger float-right" data-dismiss="modal"><span
                                            aria-hidden="true">&times;</span> Close</button>

                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>



    {{-- Modal Edit Data --}}
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form {{ $subtitle }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Main content -->

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <!-- /.card-header -->

                        <form id="form-edit" action="" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" id="id" name="id" />
                            <!-- Input hidden untuk menyimpan ID -->
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group" id="nama_produk_edit_container">
                                            <label for="nama_produk_edit">Nama Produk</label>
                                            <input type="text" class="form-control" name="nama_produk"
                                                id="nama_produk_edit" placeholder="Nama Produk">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="kategori_produk_id_edit">Kategori</label>
                                            <select class="form-control select2" name="kategori_produk_id"
                                                id="kategori_produk_id_edit" required>
                                                <option value="">--Pilih Kategori--</option>
                                                @foreach ($kategoriProduk as $kategori)
                                                    <option value="{{ $kategori->id }}">
                                                        {{ $kategori->nama_kategori_produk }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="harga_beli__edit_container">
                                            <label for="harga_beli_edit">Harga Beli</label>
                                            <input type="text" class="form-control" name="harga_beli"
                                                id="harga_beli_edit" placeholder="Harga Beli">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="harga_jual__edit_container">
                                            <label for="harga_jual_edit">Harga Jual</label>
                                            <input type="text" class="form-control" name="harga_jual"
                                                id="harga_jual_edit" placeholder="Harga Jual">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group" id="deskripsi__edit_container">
                                            <label for="deskripsi_edit">Deskripsi</label>
                                            <textarea class="form-control" name="deskripsi" id="deskripsi_edit" cols="30" rows="2"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group" id="stok__edit_container">
                                            <label for="stok_edit">Stok</label>
                                            <input type="number" class="form-control" name="stok" id="stok_edit"
                                                placeholder="Stok">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group" id="gambar__edit_container">
                                            <label for="gambar_edit">Gambar</label>
                                            <input type="file" class="form-control" name="gambar" id="gambar_edit"
                                                onchange="previewImage()">
                                            <canvas id="preview_canvas_edit"
                                                style="display: none; max-width: 100%; margin-top: 10px;"></canvas>
                                            <img id="preview_image_edit" src="#" alt="Preview Gambar"
                                                style="display: none; max-width: 100%; margin-top: 10px;">
                                        </div>
                                    </div>

                                    <script>
                                        function previewImage() {
                                            var previewCanvas = document.getElementById('preview_canvas_edit');
                                            var previewImage = document.getElementById('preview_image_edit');
                                            var fileInput = document.getElementById('gambar_edit');
                                            var file = fileInput.files[0];
                                            var reader = new FileReader();

                                            reader.onload = function(e) {
                                                var img = new Image();
                                                img.src = e.target.result;

                                                img.onload = function() {
                                                    var canvasContext = previewCanvas.getContext('2d');
                                                    var maxWidth = 200; // Max width untuk pratinja gambar

                                                    var scaleFactor = maxWidth / img.width;
                                                    var newHeight = img.height * scaleFactor;

                                                    previewCanvas.width = maxWidth;
                                                    previewCanvas.height = newHeight;

                                                    canvasContext.drawImage(img, 0, 0, maxWidth, newHeight);

                                                    // Menampilkan pratinja gambar setelah diperkecil
                                                    previewCanvas.style.display = 'block';
                                                    previewImage.style.display = 'none';
                                                };
                                            };

                                            if (file) {
                                                reader.readAsDataURL(file); // Membaca file yang dipilih sebagai URL data
                                            } else {
                                                previewImage.src = '';
                                                previewCanvas.style.display = 'none'; // Menyembunyikan pratinja gambar jika tidak ada file yang dipilih
                                            }
                                        }
                                    </script>
<div class="col-6">
    <div class="form-group" id="status_edit_container">
        <label for="status_edit">Status</label>
        <select class="form-control" name="status" id="status_edit">
            <option value="">--Pilih Status--</option>
            <option value="Aktif">Aktif</option>
            <option value="Non Aktif">Non Aktif</option>
        </select>
    </div>
</div>

<div class="col-6">
    <div class="form-group" id="status_diskon_edit_container">
        <label for="status_diskon_edit">Status Diskon</label>
        <select class="form-control" name="status_diskon" id="status_diskon_edit">
            <option value="">--Pilih Status--</option>
            <option value="Aktif">Aktif</option>
            <option value="Non Aktif">Non Aktif</option>
        </select>
    </div>
</div>

                                    {{-- <div class="col-6">
                                        <div class="form-group" id="status_edit_container">
                                            <label for="status_edit">Status</label>
                                            <select class="form-control" name="status" id="status_edit">
                                                <option value="">--Pilih Status--</option>
                                                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>
                                                    Aktif</option>
                                                <option value="Non Aktif"
                                                    {{ old('status') == 'Non Aktif' ? 'selected' : '' }}>Non Aktif</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group" id="status_diskon_edit_container">
                                            <label for="status_diskon_edit">Status Diskon</label>
                                            <select class="form-control" name="status_diskon" id="status_diskon_edit">
                                                <option value="">--Pilih Status--</option>
                                                <option value="Aktif"
                                                    {{ old('status_diskon') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="Non Aktif"
                                                    {{ old('status_diskon') == 'Non Aktif' ? 'selected' : '' }}>Non Aktif
                                                </option>
                                            </select>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-6">
                                        <div class="form-group" id="status_edit_container">
                                            <label for="status_edit">Status</label>
                                            <select class="form-control" name="status" id="status_edit">
                                                <option value="">--Pilih Status--</option>
                                                <option value="Aktif">Aktif</option>
                                                <option value="Non Aktif">Non Aktif</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group" id="status_diskon_edit_container">
                                            <label for="status_diskon_edit">Status Diskon</label>
                                            <select class="form-control" name="status_diskon" id="status_diskon_edit">
                                                <option value="">--Pilih Status--</option>
                                                <option value="Aktif">Aktif</option>
                                                <option value="Non Aktif">Non Aktif</option>
                                            </select>
                                        </div>
                                    </div> --}}




                                    <div class="col-12">
                                        <div class="form-group" id="harga_jual_diskon_edit_container">
                                            <label for="harga_jual_diskon_edit">Harga Jual Diskon</label>
                                            <input type="number" class="form-control" name="harga_jual_diskon"
                                                id="harga_jual_diskon_edit" placeholder="Harga Jual Diskon">
                                        </div>
                                    </div>
                                </div>

                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" id="btn-save-edit"><i
                                            class="fas fa-save"></i> Simpan</button>
                                    <button type="button" class="btn btn-danger float-right" data-dismiss="modal"><span
                                            aria-hidden="true">&times;</span> Close</button>

                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>






@endsection




@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>




    {{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script> --}}

    <script>
        $(document).ready(function() {
            $('#produkTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('datatables.produk') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'kategori',
                        name: 'kategori'
                    },
                    {
                        data: 'nama_produk',
                        name: 'nama_produk'
                    },

                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'gambar',
                        name: 'gambar',
                        render: function(data, type, full, meta) {
                            return '<a href="/upload/produk/' + data +
                                '" target="_blank"><img style="max-width:100px; max-height:100px" src="/upload/produk/' +
                                data + '" alt=""></a>';
                        },
                        orderable: false
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });
    </script>

    {{-- PERINTAH SIMPAN DATA --}}
    <script>
        $(document).ready(function() {
            $('#form-tambah').submit(function(event) {
                event.preventDefault();
                const tombolSimpan = $('#btn-save-tambah')

                // Buat objek FormData
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('produk.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false, // Menghindari jQuery memproses data
                    contentType: false, // Menghindari jQuery mengatur Content-Type
                    beforeSend: function() {
                        $('form').find('.error-message').remove()
                        tombolSimpan.prop('disabled', true)
                    },
                    success: function(response) {
                        $('#modal-tambah').modal('hide');
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Data berhasil disimpan',
                            icon: 'success',
                            html: '<br>Data berhasil disimpan', // Tambahkan subjudul di sini
                            confirmButtonText: 'OK'
                        }).then(function() {
                            location.reload();
                        });
                    },

                    complete: function() {
                        tombolSimpan.prop('disabled', false);
                    },
                    error: function(xhr) {
                        if (xhr.status !== 422) {
                            // $('#form-tambah').trigger('reset');
                            $('#produkTable').DataTable().ajax.reload();
                            $('#modal-tambah').modal('hide');
                        }
                        var errorMessages = xhr.responseJSON.errors;
                        var errorMessage = '';
                        $.each(errorMessages, function(key, value) {
                            errorMessage += value + '<br>';
                        });
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
    {{-- PERINTAH SIMPAN DATA --}}

    {{-- PERINTAH EDIT DATA --}}
    <script>
$(document).ready(function() {
    $('#produkTable').on('click', '.btn-edit', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        console.log('ID: ', id); // Tambahkan log untuk memeriksa ID
        $.ajax({
            method: 'GET',
            url: '/produk/' + id + '/edit',
            success: function(data) {
                console.log('Data dari server: ', data); // Tambahkan log untuk memeriksa data yang diterima

                $('#id').val(data.id);
                $('#nama_produk_edit').val(data.nama_produk);
                $('#kategori_produk_id_edit').val(data.kategori_produk_id);
                $('#harga_beli_edit').val(data.harga_beli);
                $('#harga_jual_edit').val(data.harga_jual);
                $('#deskripsi_edit').val(data.deskripsi);
                $('#stok_edit').val(data.stok);
                $('#harga_jual_diskon_edit').val(data.harga_jual_diskon);

                // Set nilai dan tambahkan log untuk memastikan bahwa nilai benar-benar di-set
                $('#status_edit').val(data.status);
                $('#status_diskon_edit').val(data.status_diskon);

                // Atur properti selected secara eksplisit
                $('#status_edit option').each(function() {
                    if ($(this).val() == data.status) {
                        $(this).prop('selected', true);
                    }
                });

                $('#status_diskon_edit option').each(function() {
                    if ($(this).val() == data.status_diskon) {
                        $(this).prop('selected', true);
                    }
                });

                // Tambahkan log untuk memeriksa nilai setelah pengaturan
                console.log('Status:', data.status);
                console.log('Status Diskon:', data.status_diskon);
                console.log('Element status_edit value after setting:', $('#status_edit').val());
                console.log('Element status_diskon_edit value after setting:', $('#status_diskon_edit').val());

                // Hapus gambar yang ada sebelum menambahkan gambar yang baru
                $('#gambar_edit_container img').remove();
                $('#gambar_edit_container a').remove();

                // Tambahkan logika untuk menampilkan gambar bukti pada formulir edit
                if (data.gambar) {
                    var gambarImg = '<img src="/upload/produk/' + data.gambar + '" style="max-width: 200px; max-height: 200px;">';
                    var gambarLink = '<a href="/upload/produk/' + data.gambar + '" target="_blank"><i class="fa fa-eye"></i> Lihat Gambar</a>';
                    $('#gambar_edit_container').append(gambarImg + '<br>' + gambarLink);
                }

                $('#modal-edit').modal('show');
            },
            error: function(xhr) {
                // Tangani kesalahan jika ada
                alert('Error: ' + xhr.statusText);
            }
        });
    });

    // Mengosongkan gambar saat modal ditutup
    $('#modal-edit').on('hidden.bs.modal', function() {
        $('#gambar_edit_container img').remove();
        $('#gambar_edit_container a').remove();
    });
});




    </script>
    {{-- PERINTAH EDIT DATA --}}



    {{-- PERINTAH UPDATE DATA --}}
    <script>
        $(document).ready(function() {
            $('#btn-save-edit').click(function(e) {
                e.preventDefault();
                const tombolUpdate = $('#btn-save-edit');
                var id = $('#id').val();
                var formData = new FormData($('#form-edit')[0]);

                $.ajax({
                    type: 'POST', // Gunakan POST karena kita override dengan PUT
                    url: '/produk/' + id,
                    data: formData,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('form').find('.error-message').remove();
                        tombolUpdate.prop('disabled', true);
                    },
                    success: function(response) {
                        $('#modal-edit').modal('hide');
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed || result.isDismissed) {
                                location.reload();
                            }
                        });
                    },
                    complete: function() {
                        tombolUpdate.prop('disabled', false);
                    },
                    error: function(xhr) {
                        if (xhr.status !== 422) {
                            $('#modal-edit').modal('hide');
                        }
                        var errorMessages = xhr.responseJSON.errors;
                        var errorMessage = '';
                        $.each(errorMessages, function(key, value) {
                            errorMessage += value + '<br>';
                        });
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>

    {{-- PERINTAH UPDATE DATA --}}

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
                            url: '/produk/' + id,
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
