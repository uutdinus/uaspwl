<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.4/dist/tailwind.min.css" rel="stylesheet">

</head>

<body class="bg-gray-100">
    <main id="main" class="main">
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-4">Checkout</h2>

            <!-- Form Checkout -->
            <form action="/order/create" method="post">
                <?= csrf_field() ?>
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Alamat -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea placeholder="Tulis alamat"
                        maxlength="100"
                            class="mt-1 pl-2 p-2 border border-gray-500 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            id="address" name="address" rows="2" required></textarea>
                    </div>

                    <!-- Provinsi -->
                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700">Provinsi</label>
                        <select
                            class="mt-1 block p-2 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            id="province" name="province" required>
                            <option value="">Pilih Provinsi</option>
                            <?php foreach ($provinces['rajaongkir']['results'] as $province): ?>
                                <option value="<?= $province['province_id'] ?>"><?= $province['province'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Kabupaten/Kota -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                        <select
                            class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            id="city" name="city" required>
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                    </div>

                    <!-- Kurir -->
                    <div>
                        <label for="courier" class="block text-sm font-medium text-gray-700">Kurir</label>
                        <select
                            class="mt-1 block w-full border-gray-300 p-2 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            id="courier" name="courier" required>
                            <option value="">Pilih Kurir</option>
                        </select>
                    </div>

                    <!-- Layanan -->
                    <div>
                        <label for="service" class="block text-sm font-medium text-gray-700">Layanan</label>
                        <select
                            class="mt-1 block w-full border-gray-300 p-2 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            id="service" name="service" required>
                            <option value="">Pilih Layanan</option>
                        </select>
                    </div>

                    <!-- Ongkir -->
                    <div>
                        <label for="shipping-cost" class="block  text-sm font-medium text-gray-700">Ongkir</label>
                        <input type="text"
                            class="mt-1 block w-full border-gray-300 p-2 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            id="shipping-cost" name="shipping_cost" readonly>
                    </div>

                    <!-- Tambahkan input tersembunyi untuk total_cost -->
                    <input type="hidden" id="total-cost-field" name="total_cost" value="0">


        </div>

        <!-- Info Pengiriman -->

        <div class="mt-6 p-4 bg-gray-200 rounded-md ">
            <label class="block text-sm font-medium text-gray-700">Info Pengiriman</label>
            <p id="shipping-info" class="mt-1 text-gray-600">Barang akan dikirim dari Semarang Kota, Jawa Tengah
                ke
                <span id="destination-name">...</span>
            </p>
        </div>

        <!-- Data Keranjang -->
        <div class="flex justify-between mt-6 item-center">

            <h3 class="text-xl font-bold ">Keranjang</h3>
            <a href="/keranjang" class="bg-blue-500 py-2 px-3 rounded-md font-bold text-white">Edit
                Keranjang</a>
        </div>
        <table class="min-w-full mt-4 bg-white border border-gray-300 rounded-lg">
            <thead>
                <tr class="border-b bg-gray-50">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Gambar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nama Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Total</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $subtotal = 0; ?>
                <?php foreach ($items as $item): ?>
                    <?php
                    $item_total = $item['price'] * $item['qty'];
                    $subtotal += $item_total;
                    ?>
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <img src="<?= base_url('img/' . $item['options']['foto']) ?>" alt="<?= $item['name'] ?>"
                                class="w-16 h-16 object-cover rounded">
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?= $item['name'] ?></td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <?= number_format($item['price'], 0, ',', '.') ?> IDR
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?= $item['qty'] ?></td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?= number_format($item_total, 0, ',', '.') ?>
                            IDR
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Subtotal dan Total -->
        <div class="mt-6 bg-gray-50 p-4 rounded-lg">
            <div class="flex justify-between text-sm font-medium text-gray-700">
                <span>Subtotal:</span>
                <span><?= number_format($subtotal, 0, ',', '.') ?> IDR</span>
            </div>
            <div class="flex justify-between text-sm font-medium text-gray-700 mt-2">
                <span>Ongkir:</span>
                <span id="shipping-cost-display">0 IDR</span>
            </div>
            <div class="flex justify-between text-sm font-medium text-gray-700 mt-2">
                <span>Total:</span>
                <span id="total-cost">0 IDR</span>
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="w-full flex justify-end">
            <button type="submit" id="order-button"
                class="mt-4 px-4 disabled:bg-gray-500 py-2 bg-blue-500 text-white font-semibold rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                disabled>Buat Pesanan</button>
        </div>
        </form>
        </div>
    </main><!-- End #main -->




    <!-- JS Dependencies -->
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        var origin = 399;
        var subtotal = <?= $subtotal ?>;


        function formatRupiah(angka) {
            var number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return 'Rp ' + rupiah;
        }


        function updateTotal() {
            var shippingCost = parseInt($('#shipping-cost').val()) || 0;
            var total = subtotal + shippingCost;
            $('#total-cost').text(total.toLocaleString('id-ID') + ' IDR');
            $('#shipping-cost-display').text(shippingCost.toLocaleString('id-ID') + ' IDR');
            $('#total-cost-field').val(total); // Tambahkan baris ini untuk memperbarui nilai input tersembunyi
        }


        $('#province').on('change', function () {
            var province_id = $(this).val();
            if (province_id) {
                $.ajax({
                    url: '/checkout/getCities/' + province_id,
                    type: 'GET',
                    success: function (data) {
                        var cities = data.rajaongkir.results;
                        var citySelect = $('#city');
                        citySelect.empty();
                        citySelect.append('<option value="">Pilih Kabupaten/Kota</option>');
                        $.each(cities, function (index, city) {
                            citySelect.append('<option value="' + city.city_id + '">' + city.city_name + '</option>');
                        });


                        $('#courier').empty().append('<option value="">Pilih Kurir</option>');
                        $('#service').empty().append('<option value="">Pilih Layanan</option>');
                        $('#shipping-cost').val('');
                        $('#shipping-cost-display').text('0 IDR');
                        $('#total-cost').text((subtotal).toLocaleString('id-ID') + ' IDR');
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        });

        $('#city').on('change', function () {
            var city_id = $(this).val();
            var weight = 1000;
            if (city_id) {
                $.ajax({
                    url: '/checkout/getCostOptions',
                    type: 'POST',
                    data: {
                        origin: origin,
                        destination: city_id,
                        weight: weight
                    },
                    success: function (data) {
                        var couriers = data;
                        var courierSelect = $('#courier');
                        courierSelect.empty();
                        courierSelect.append('<option value="">Pilih Kurir</option>');
                        $.each(couriers, function (courierCode, courierData) {
                            courierSelect.append('<option value="' + courierCode + '">' + courierCode.toUpperCase() + '</option>');
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        });

        $('#courier').on('change', function () {
            var courier = $(this).val();
            var city_id = $('#city').val();
            var weight = 1000;
            if (city_id && courier) {
                $.ajax({
                    url: '/checkout/getCost',
                    type: 'POST',
                    data: {
                        origin: origin,
                        destination: city_id,
                        weight: weight,
                        courier: courier
                    },
                    success: function (data) {
                        var services = data.rajaongkir.results[0].costs;
                        var serviceSelect = $('#service');
                        serviceSelect.empty();
                        serviceSelect.append('<option value="">Pilih Layanan</option>');
                        $.each(services, function (index, service) {
                            serviceSelect.append('<option value="' + service.service + '">' + service.description + '</option>');
                        });

                        var destinationName = $('#city option:selected').text();
                        $('#destination-name').text(destinationName);

                        if (services.length > 0) {
                            var firstService = services[0];
                            var shippingCost = firstService.cost[0].value;
                            $('#shipping-cost').val(shippingCost);
                            updateTotal();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
        function checkFormCompletion() {
            var address = $('#address').val().trim();
            var province = $('#province').val();
            var city = $('#city').val();
            var courier = $('#courier').val();
            var service = $('#service').val();

            if (address && province && city && courier && service) {
                $('#order-button').prop('disabled', false);
            } else {
                $('#order-button').prop('disabled', true);
            }
        }

        $('#shipping-cost').on('input', function () {
            updateTotal();
        });

        $('#address, #province, #city, #courier, #service').on('change keyup', function () {
            checkFormCompletion();
        });


        checkFormCompletion();


    });
</script>



</html>