<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
    <link href="<?= base_url('NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="<?= base_url('NiceAdmin/assets/vendor/boxicons/css/boxicons.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('NiceAdmin/assets/vendor/quill/quill.snow.css') ?>" rel="stylesheet">
    <link href="<?= base_url('NiceAdmin/assets/vendor/quill/quill.bubble.css') ?>" rel="stylesheet">
    <link href="<?= base_url('NiceAdmin/assets/vendor/remixicon/remixicon.css') ?>" rel="stylesheet">
    <link href="<?= base_url('NiceAdmin/assets/vendor/simple-datatables/style.css') ?>" rel="stylesheet">
    <!-- Example tailwind styles -->
    <style>
        .bg-gray-100 {
            background-color: #f7fafc;
        }

        .text-center {
            text-align: center;
        }

        .p-4 {
            padding: 1rem;
        }

        .border-gray-200 {
            border-color: #e2e8f0;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .btn-disabled {
            background-color: #6c757d;

            border-color: #6c757d;

            color: #fff;

            cursor: not-allowed;

        }

        .btn-disabled:hover {
            background-color: #6c757d;
            border-color: #6c757d;
        }
    </style>
</head>
<?php

$total = 0;
if (!empty($items)) {
    foreach ($items as $item) {
        $total += $item['subtotal'];
    }
}
?>

<body class="bg-gray-100">
    <main id="main" class="main">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="pagetitle">
            <h1>Keranjang</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Keranjang</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Produk dalam Keranjang</h5>

                            <div class="table-responsive">
                                <input type="text" id="searchInput" class="form-control mb-3"
                                    placeholder="Cari produk...">
                                <form action="<?= base_url('keranjang/edit') ?>" method="post">
                                    <table class="table datatable" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Foto</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">Subtotal</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = count($items); ?>
                                            <?php foreach (array_reverse($items) as $item): ?>
                                                <tr>
                                                    <td><?= $item['name'] ?></td>
                                                    <td>
                                                        <?php if (!empty($item['options']['foto'])): ?>
                                                            <img src="<?= base_url('img/' . $item['options']['foto']) ?>"
                                                                alt="<?= $item['name'] ?>" class="img-fluid"
                                                                style="max-width: 100px;">
                                                        <?php else: ?>
                                                            No Photo Available
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                                    <td>
                                                        <input type="number" min="1" name="qty<?= $i-- ?>"
                                                            class="form-control qty-input" value="<?= $item['qty'] ?>">
                                                        <input type="hidden" name="rowid<?= $i ?>"
                                                            value="<?= $item['rowid'] ?>">
                                                    </td>
                                                    <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                                    <td>
                                                        <a href="<?= base_url('keranjang/delete/' . $item['rowid']) ?>"
                                                            class="btn btn-danger btn-sm">Hapus</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>

                                    </table>
                                    <div class="alert alert-info">
                                        Total Belanja: <?= number_format($total, 0, ',', '.') ?> IDR
                                    </div>

                                    <div class="flex justify-between mt-3">
                                        <div>

                                            <a href="<?= base_url('keranjang/clear') ?>"
                                                class="btn btn-danger">Kosongkan
                                                Keranjang</a>
                                            <button type="submit" class="btn btn-primary">Perbarui Keranjang</button>
                                        </div>
                                        <div>
                                            <button type="button"
                                                class="btn btn-success checkout-button <?= empty($items) ? 'btn-disabled' : '' ?>"
                                                onclick="<?= empty($items) ? '' : 'window.location.href=\'' . base_url('checkout') . '\';' ?>">
                                                Checkout
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById('searchInput');
            const dataTable = document.getElementById('dataTable');
            const rows = dataTable.getElementsByTagName('tr');

            searchInput.addEventListener('input', function () {
                const searchTerm = searchInput.value.toLowerCase();

                for (let i = 1; i < rows.length; i++) {
                    /
                    const nameColumn = rows[i].getElementsByTagName('td')[0];

                    if (nameColumn) {
                        const productName = nameColumn.textContent.toLowerCase();

                        if (productName.includes(searchTerm)) {
                            rows[i].style.display = '';
                        } else {
                            rows[i].style.display = 'none';
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>