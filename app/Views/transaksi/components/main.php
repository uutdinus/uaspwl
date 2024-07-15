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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.4/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .flash-message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Transaksi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item">Transaksi</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Transaksi</h5>
                            <?php if (session()->get('role') === 'admin'): ?>

                                <a href="<?= site_url('transaksi/print_pdf'); ?>" class="btn btn-success">Download PDF</a>
                            <?php endif; ?>

                            <!-- Flash Message -->
                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="flash-message">
                                    <?= esc(session()->getFlashdata('success')) ?>
                                </div>
                            <?php endif; ?>

                            <!-- Error Message -->
                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="error-message">
                                    <?= esc(session()->getFlashdata('error')) ?>
                                </div>
                            <?php endif; ?>

                            <!-- Tabel untuk menampilkan data orders -->
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Alamat</th>
                                        <th>Ongkir</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <?php if (session()->get('role') === 'admin'): ?>
                                            <th>Actions</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($orders)): ?>
                                        <?php $i = 1; ?>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= esc($order['username']); ?></td>
                                                <td><?= esc($order['alamat']); ?></td>
                                                <td><?= number_format($order['ongkir'], 0, ',', '.'); ?> IDR</td>
                                                <td><?= number_format($order['total'], 0, ',', '.'); ?> IDR</td>
                                                <td
                                                    style="color: <?= $order['status'] ? 'green' : 'red'; ?>; font-weight: bold;">
                                                    <?= $order['status'] ? 'Selesai' : 'Belum Selesai'; ?>
                                                </td>
                                                <?php if (session()->get('role') === 'admin'): ?>
                                                    <td>
                                                        <!-- Trigger modal -->
                                                        <button data-id="<?= $order['id']; ?>"
                                                            data-status="<?= $order['status']; ?>"
                                                            class="btn btn-primary edit-status-btn" data-bs-toggle="modal"
                                                            data-bs-target="#editStatusModal">Edit Status</button>
                                                        <!-- Button to print PDF -->

                                                    </td>
                                                <?php endif; ?>

                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="<?= session()->get('role') === 'admin' ? '7' : '6'; ?>"
                                                class="text-center">Tidak ada data transaksi</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- Modal -->
    <div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStatusModalLabel">Edit Status Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editStatusForm" method="post" action="<?= site_url('transaksi/update_status'); ?>">
                    <div class="modal-body">
                        <input type="hidden" id="orderId" name="id">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="true">Selesai</option>
                                <option value="false">Belum Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editStatusButtons = document.querySelectorAll('.edit-status-btn');
            const orderIdInput = document.getElementById('orderId');
            const statusSelect = document.getElementById('status');

            editStatusButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const orderId = this.getAttribute('data-id');
                    const orderStatus = this.getAttribute('data-status');

                    orderIdInput.value = orderId;
                    statusSelect.value = orderStatus ? 'true' : 'false';
                });
            });
        });
    </script>
</body>

</html>