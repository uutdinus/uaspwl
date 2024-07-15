<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        <div class="pagetitle">

            <?php if (session()->getFlashdata('success_message')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success_message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <nav>

                <div class="card">
                    <div class="card-body mt-10">
                        <h1>Home</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        </ol>


                    </div>
                </div>
            </nav>
        </div>
        <?php


        function formatRupiah($angka)
        {
            $reverse = strrev((string) $angka);
            $ribuan = implode('.', str_split($reverse, 3));
            return 'Rp ' . strrev($ribuan);
        }

        ?>

        <section class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <?php foreach ($produk as $item): ?>
                        <div class="col-lg-4 mb-4">
                            <div class="card shadow">
                                <?php if ($item['foto']): ?>
                                    <img src="<?= base_url('img/' . $item['foto']) ?>" class="card-img-top img-thumbnail"
                                        alt="Product Image" style="height: 300px; object-fit: cover;">
                                <?php endif; ?>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title font-weight-bold"><?= $item['nama'] ?></h5>
                                    <p class="card-text"><?= formatRupiah($item['harga']) ?></p>
                                    <p class="card-text">Qty: <?= $item['jumlah'] ?></p>
                                    <div class="w-full">
                                        <form action="<?= base_url('keranjang/add') ?>" class="w-full" method="post">
                                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                            <input type="hidden" name="nama" value="<?= $item['nama'] ?>">
                                            <input type="hidden" name="harga" value="<?= $item['harga'] ?>">
                                            <input type="hidden" name="foto" value="<?= $item['foto'] ?>">
                                            <button type="submit" class="btn btn-success btn-block mt-auto" style="width: 100%">
                                                Tambahkan
                                                <i class="bi bi-cart-plus-fill ml-2"></i>
                                            </button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>





                    <?php endforeach; ?>
                </div>
            </div>
        </section>


        <script>

            function formatRupiah(angka) {
                var reverse = angka.toString().split('').reverse().join(''),
                    ribuan = reverse.match(/\d{1,3}/g);
                ribuan = ribuan.join('.').split('').reverse().join('');
                return 'Rp ' + ribuan;
            }


        </script>





    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="<?= base_url('NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>