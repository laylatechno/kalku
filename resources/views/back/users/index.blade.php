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

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th width="5%">Gambar</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>


                            <?php $i = 1; ?>
                            @foreach ($users as $p)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $p->name }}</td>
                                    <td>{{ $p->email }}</td>
                                    <td>{{ $p->role }}</td>
                                    <td><a href="/upload/user/{{ $p->picture }}" target="_blank"><img
                                                style="max-width:100px; max-height:100px"
                                                src="/upload/user/{{ $p->picture }}" alt=""></a></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning btn-edit" data-toggle="modal"
                                            data-target="#modal-edit" data-id="{{ $p->id }}" style="color: black">
                                            <i class="fas fa-edit"></i> Edit
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
                                        <div class="form-group" id="name_container">
                                            <label for="name">Nama User</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Nama User">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="email_container">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control " name="email" id="email"
                                                placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="role_container">
                                            <label for="role">Role</label>
                                            <select class="form-control" name="role" id="role">
                                                <option value="">--Pilih Role--</option>
                                                <option value="administrator">Administrator</option>
                                                <option value="admin">Admin</option>
                                                <option value="kasir">Kasir</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="phone_number_container">
                                            <label for="phone_number">No Telp</label>
                                            <input type="number" class="form-control " name="phone_number"
                                                id="phone_number" placeholder="No Telp">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group" id="address_container">
                                            <label for="address">Alamat</label>
                                            <textarea class="form-control" name="address" id="address" cols="30" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="password_container">
                                            <label for="password">Masukkan Password</label>
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="Masukkan Password">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="confirmation_password_container">
                                            <label for="confirmation_password">Konfirmasi Password</label>
                                            <input type="password" class="form-control" id="confirmation_password"
                                                placeholder="Masukkan Konfirmasi Password">
                                            <span id="password_match_message" style="color: red;"></span>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('confirmation_password').addEventListener('keyup', function() {
                                            var password = document.getElementById('password').value;
                                            var confirmationPassword = this.value;
                                            var passwordMatchMessage = document.getElementById('password_match_message');

                                            if (password !== confirmationPassword) {
                                                passwordMatchMessage.textContent = 'Password belum sama.';
                                                passwordMatchMessage.style.color = 'red';
                                            } else {
                                                passwordMatchMessage.textContent = 'Password sudah sama.';
                                                passwordMatchMessage.style.color = 'green'; // Mengubah warna teks menjadi hijau
                                            }
                                        });
                                    </script>



                                    <div class="col-12">
                                        <div class="form-group" id="picture_container">
                                            <label for="picture">Gambar</label>
                                            <input type="file" class="form-control" name="picture" id="picture"
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
                                            var fileInput = document.getElementById('picture');
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

                        <form id="form-edit" action="" method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" id="id" name="id" />
                            <!-- Input hidden untuk menyimpan ID -->
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-6">
                                        <div class="form-group" id="name_edit_container">
                                            <label for="name_edit">Nama User</label>
                                            <input type="text" class="form-control" name="name" id="name_edit"
                                                placeholder="Nama User">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="email_edit_container">
                                            <label for="email_edit">Email</label>
                                            <input type="email" class="form-control " name="email" id="email_edit"
                                                placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="role_edit_container">
                                            <label for="role_edit">Role</label>
                                            <select class="form-control" name="role" id="role_edit">
                                                <option value="">--Pilih Role--</option>
                                                <option value="administrator">Administrator</option>
                                                <option value="admin">Admin</option>
                                                <option value="kasir">Kasir</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="phone_number_edit_container">
                                            <label for="phone_number_edit">No Telp</label>
                                            <input type="number" class="form-control " name="phone_number"
                                                id="phone_number_edit" placeholder="No Telp">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group" id="address_edit_container">
                                            <label for="address_edit">Alamat</label>
                                            <textarea class="form-control" name="address" id="address_edit" cols="30" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="password_edit_container">
                                            <label for="password_edit">Masukkan Password</label>
                                            <input type="password" class="form-control" name="password"
                                                id="password_edit" placeholder="Masukkan Password">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="confirmation_password_edit_container">
                                            <label for="confirmation_password_edit">Konfirmasi Password</label>
                                            <input type="password" class="form-control" id="confirmation_password_edit"
                                                placeholder="Masukkan Konfirmasi Password">
                                            <span id="password_match_message_edit" style="color: red;"></span>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('confirmation_password_edit').addEventListener('keyup', function() {
                                            var password = document.getElementById('password_edit').value;
                                            var confirmationPassword = this.value;
                                            var passwordMatchMessage = document.getElementById('password_match_message_edit');

                                            if (password !== confirmationPassword) {
                                                passwordMatchMessage.textContent = 'Password belum sama.';
                                                passwordMatchMessage.style.color = 'red';
                                            } else {
                                                passwordMatchMessage.textContent = 'Password sudah sama.';
                                                passwordMatchMessage.style.color = 'green'; // Mengubah warna teks menjadi hijau
                                            }
                                        });
                                    </script>



                                    <div class="col-12">
                                        <div class="form-group" id="picture_edit_container">
                                            <label for="picture_edit">Gambar</label>
                                            <br>
                                            <input type="file" class="form-control" name="picture" id="picture_edit"
                                                onchange="previewImage_edit()">

                                            <canvas id="preview_canvas_edit"
                                                style="display: none; max-width: 100%; margin-top: 10px;"></canvas>
                                            <img id="preview_image_edit" src="#" alt="Preview Gambar"
                                                style="display: none; max-width: 100%; margin-top: 10px;">
                                            <br>
                                        </div>
                                    </div>

                                    <script>
                                        function previewImage_edit() {
                                            var previewCanvas_edit = document.getElementById('preview_canvas_edit');
                                            var previewImage_edit = document.getElementById('preview_image_edit');
                                            var fileInput_edit = document.getElementById('picture_edit'); // Mengubah id menjadi picture_edit
                                            var file_edit = fileInput_edit.files[0];
                                            var reader_edit = new FileReader();

                                            reader_edit.onload = function(e) {
                                                var img = new Image();
                                                img.src = e.target.result;

                                                img.onload = function() {
                                                    var canvasContext = previewCanvas_edit.getContext('2d');
                                                    var maxWidth = 200; // Max width untuk pratinja gambar

                                                    var scaleFactor = maxWidth / img.width;
                                                    var newHeight = img.height * scaleFactor;

                                                    previewCanvas_edit.width = maxWidth;
                                                    previewCanvas_edit.height = newHeight;

                                                    canvasContext.drawImage(img, 0, 0, maxWidth, newHeight);

                                                    // Menampilkan pratinja gambar setelah diperkecil
                                                    previewCanvas_edit.style.display = 'block';
                                                    previewImage_edit.style.display = 'none';
                                                };
                                            };

                                            if (file_edit) {
                                                reader_edit.readAsDataURL(file_edit); // Membaca file yang dipilih sebagai URL data
                                            } else {
                                                previewImage_edit.src = '';
                                                previewCanvas_edit.style.display =
                                                    'none'; // Menyembunyikan pratinja gambar jika tidak ada file yang dipilih
                                            }
                                        }
                                    </script>






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
    {{-- PERINTAH SIMPAN DATA --}}
    <script>
        $(document).ready(function() {
            $('#form-tambah').submit(function(event) {
                event.preventDefault();
                const tombolSimpan = $('#btn-save-tambah')

                // Buat objek FormData
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('users.store') }}',
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
            $('.btn-edit').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    method: 'GET',
                    url: '/users/' + id + '/edit',
                    success: function(data) {
                        $('#id').val(data.id);
                        $('#name_edit').val(data.name);
                        $('#email_edit').val(data.email);
                        $('#role_edit').val(data.role);
                        $('#address_edit').val(data.address);
                        $('#phone_number_edit').val(data.phone_number);

                        // Hapus gambar yang ada sebelum menambahkan gambar yang baru
                        $('#picture_edit_container img').remove();
                        $('#picture_edit_container a').remove();

                        // Tambahkan logika untuk menampilkan gambar bukti pada formulir edit
                        if (data.picture) {
                            var pictureImg = '<img src="/upload/user/' + data.picture +
                                '" style="max-width: 200px; max-height: 200px;">';
                            var pictureLink = '<a href="/upload/user/' + data.picture +
                                '" target="_blank"><i class="fa fa-eye"></i> Lihat Gambar</a>';
                            $('#picture_edit_container').append(pictureImg + '<br>' +
                                pictureLink);
                        }

                        $('#modal-edit').modal('show');
                        $('#id').val(id);
                    },
                    error: function(xhr) {
                        // Tangani kesalahan jika ada
                        alert('Error: ' + xhr.statusText);
                    }
                });
            });

            // Mengosongkan gambar saat modal ditutup
            $('#modal-edit').on('hidden.bs.modal', function() {
                $('#picture_edit_container img').remove();
                $('#picture_edit_container a').remove();
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
                    url: '/users/' + id,
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
                            url: '/users/' + id,
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
