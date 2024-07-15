<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link rel="stylesheet" href="<?= base_url('NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            background-color: #f7f7f7;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            text-align: center; 
        }

        th,
        td {
            padding: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 80px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .generated-date {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h2>Daftar Produk</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produk as $index => $item): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $item['nama'] ?></td>
                    <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                    <td><?= $item['jumlah'] ?></td>
                    <td><img
                            src="data:image/jpeg;base64,<?= base64_encode(file_get_contents(FCPATH . 'img/' . $item['foto'])) ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="generated-date">
        Generated on <?= date('Y-m-d H:i:s') ?>
    </div>
</body>

</html>
