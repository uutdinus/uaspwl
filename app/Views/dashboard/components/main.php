<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.7/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-800 font-sans">

    <main id="main" class="main">


        <h2 class="text-2xl font-bold mb-4">Rekap Bulanan</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Bulan</th>
                        <th class="py-3 px-6 text-left">Jumlah Transaksi</th>
                        <th class="py-3 px-6 text-left">Total Pendapatan</th>
                        <th class="py-3 px-6 text-left">Jumlah Pengguna</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($monthlyData['monthlyOrders'] as $order): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="py-3 px-6 text-left"><?= date('F Y', mktime(0, 0, 0, $order['month'], 10)) ?></td>
                            <td class="py-3 px-6 text-left"><?= $order['transaction_count'] ?></td>
                            <td class="py-3 px-6 text-left"><?= number_format($order['total_amount'], 2) ?></td>
                            <td class="py-3 px-6 text-left"><?= $monthlyData['monthlyUserCounts'][$order['month']] ?? 0 ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <h3 class="text-xl font-semibold">Total Pendapatan Bulanan:
                <?= number_format($monthlyData['totalRevenueMonthly'], 2) ?>
            </h3>
        </div>

        <!-- Menampilkan Data Tahunan -->
        <h2 class="text-2xl font-bold mt-8 mb-4">Rekap Tahunan</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Total Pendapatan Tahun Ini</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-100">
                        <td class="py-3 px-6 text-left"><?= number_format($annualData['totalRevenue'], 2) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>


    </main>
</body>

</html>