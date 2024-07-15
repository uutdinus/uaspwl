<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .footer {
            text-align: right;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Laporan Transaksi</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Alamat</th>
                <th>Ongkir</th>
                <th>Total</th>
                <th>Status</th>
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
                        <td><?= $order['status'] ? 'Selesai' : 'Belum Selesai'; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data transaksi</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="footer">
        Download on <?= date('d M Y'); ?>
    </div>
</body>
</html>
