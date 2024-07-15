<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link href="<?= base_url('NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="<?= base_url('NiceAdmin/assets/vendor/boxicons/css/boxicons.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('NiceAdmin/assets/vendor/quill/quill.snow.css') ?>" rel="stylesheet">
    <link href="<?= base_url('NiceAdmin/assets/vendor/quill/quill.bubble.css') ?>" rel="stylesheet">
    <link href="<?= base_url('NiceAdmin/assets/vendor/remixicon/remixicon.css') ?>" rel="stylesheet">
    <link href="<?= base_url('NiceAdmin/assets/vendor/simple-datatables/style.css') ?>" rel="stylesheet">
</head>

<body>
    <main id="main" class="main">

        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger" role="alert">
                <ul>
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>


        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?= session('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('success')): ?>
            <div class="alert alert-success" role="alert">
                <?= session('success') ?>
            </div>
        <?php endif; ?>
        <div class="pagetitle">
            <h1>Produk</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item">Produk</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#tambahDataModal">
                                            <i class="bi bi-plus-circle mt-1"></i> Tambah Produk
                                        </button>
                                    </div>
                                    <div>
                                        <a href="<?= base_url('/produk/cetakpdf') ?>" target="_blank"
                                            class="btn btn-secondary">
                                            <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <table class="table datatable mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Foto</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($produk)): ?>
                                        <?php foreach ($produk as $index => $item): ?>
                                            <tr>
                                                <th scope="row"><?= $index + 1 ?></th>
                                                <td><?= $item['nama'] ?></td>
                                                <td><?= number_format($item['harga'], 0, ',', '.') ?></td>
                                                <td><?= $item['jumlah'] ?></td>
                                                <td><img src="<?= base_url('img/' . $item['foto']) ?>"
                                                        alt="<?= $item['nama'] ?>" width="50"></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        onclick="editProduk(<?= $index ?>)">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                        data-id="<?= $item['id'] ?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada produk</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>
    <!-- Modal Tambah produk -->
    <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('/produk/store') ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto (.png, .jpg, .jpeg)</label>
                            <input type="file" class="form-control" id="tambahFotoInput" name="foto"
                                accept=".png, .jpg, .jpeg" onchange="previewTambahFoto(this)">
                            <img src="https://via.placeholder.com/400x400" id="tambahPreviewFoto" alt="Preview Foto"
                                class="img-fluid mx-auto d-block"
                                style="max-width: 50%; margin-top: 10px; display: none;">
                        </div>
                        <div class="d-grid justify-content-center">
                            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Edit Produk -->
    <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataModalLabel">Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('/produk/update') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="editId" name="id">
                        <div class="mb-3">
                            <label for="editNama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="editNama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="editHarga" class="form-label">Harga</label>
                            <input type="text" class="form-control" id="editHargaNumeric" value="" name="harga"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editJumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="editJumlah" name="jumlah" required>
                        </div>
                        <div class="mb-3">
                            <label for="editFoto" class="form-label">Foto (.png, .jpg, .jpeg)</label>
                            <input type="file" class="form-control" id="editFotoInput" name="foto"
                                accept=".png, .jpg, .jpeg" onchange="previewEditFoto(this)">
                            <img src="" id="editPreviewFoto" alt="Preview Foto" class="img-fluid mx-auto d-block"
                                style="max-width: 50%; margin-top: 10px; display: none;">
                        </div>
                        <div class="d-grid justify-content-center">
                            <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Hapus Produk -->

    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus produk ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a id="deleteProductLink" href="#" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>


    <script src="<?= base_url('NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('NiceAdmin/assets/vendor/simple-datatables/simple-datatables.js') ?>"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            new simpleDatatables.DataTable(".datatable");
        });
        document.addEventListener("DOMContentLoaded", function () {

            var deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var id = this.getAttribute('data-id');
                    var deleteProductLink = document.getElementById('deleteProductLink');
                    deleteProductLink.href = '<?= base_url('produk/delete/') ?>' + id;

                    var deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'), {
                        keyboard: false
                    });
                    deleteConfirmationModal.show();
                });
            });
        });


        function editProduk(index) {
            var produk = <?= json_encode($produk) ?>;
            var editId = document.getElementById('editId');
            var editNama = document.getElementById('editNama');
            var editHarga = document.getElementById('editHargaNumeric');
            var editJumlah = document.getElementById('editJumlah');
            var previewFoto = document.getElementById('editPreviewFoto');
            var selectedProduk = produk[index];

            editId.value = selectedProduk.id;
            editNama.value = selectedProduk.nama;
            editHarga.value = formatRupiah(selectedProduk.harga);
            editJumlah.value = selectedProduk.jumlah;
            previewFoto.src = '<?= base_url('img/') ?>' + selectedProduk.foto;
            previewFoto.style.display = 'block';

            console.log(editHarga.value)

            var editDataModal = new bootstrap.Modal(document.getElementById('editDataModal'), {
                keyboard: false
            });
            editDataModal.show();
        }

        function previewEditFoto(input) {
            var previewFoto = document.getElementById('editPreviewFoto');
            var file = input.files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                previewFoto.src = reader.result;
                previewFoto.style.display = 'block';
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                previewFoto.src = "";
                previewFoto.style.display = 'none';
            }
        }

        function formatRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return 'Rp ' + ribuan;
        }

        document.getElementById('editHargaNumeric').addEventListener('keyup', function () {
            var harga = this.value.replace(/\D/g, '');
            this.value = formatRupiah(harga);



        });
        function previewTambahFoto(input) {
            var previewFoto = document.getElementById('tambahPreviewFoto');
            var file = input.files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                previewFoto.src = reader.result;
                previewFoto.style.display = 'block';
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {

                previewFoto.style.display = 'none';
            }
        }



        document.getElementById('harga').addEventListener('keyup', function () {
            var harga = this.value.replace(/\D/g, '');
            this.value = formatRupiah(harga);
        });
    </script>

</body>

</html>