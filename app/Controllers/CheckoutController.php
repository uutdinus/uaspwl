<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RajaOngkirModel;
use CodeIgniter\HTTP\ResponseInterface;

class CheckoutController extends BaseController
{
    protected $cart;
    protected $rajaOngkirModel;

    public function __construct()
    {
        helper(['number', 'form']);
        $this->cart = \Config\Services::cart();
        $this->rajaOngkirModel = new RajaOngkirModel();
    }

    public function index(): ResponseInterface|string
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $data['items'] = $this->cart->contents();

        if (empty($data['items'])) {
            session()->setFlashdata('error', 'Keranjang kosong. Silakan tambahkan produk ke keranjang terlebih dahulu.');
            return redirect()->to('/keranjang');
        }


        $data['provinces'] = $this->rajaOngkirModel->getProvinces();
        $data['cities'] = [];

        session()->setFlashdata('success', 'Berhasil buat pesanan.');

        return view('checkouts/v_checkout', $data);
    }

    public function getCities($province_id)
    {
        $cities = $this->rajaOngkirModel->getCities($province_id);
        return $this->response->setJSON($cities);
    }

    public function getCost()
    {
        $origin = $this->request->getPost('origin');
        $destination = $this->request->getPost('destination');
        $weight = $this->request->getPost('weight');
        $courier = $this->request->getPost('courier');

        $cost = $this->rajaOngkirModel->getCost($origin, $destination, $weight, $courier);
        return $this->response->setJSON($cost);
    }

    public function getCostOptions()
    {
        $origin = $this->request->getPost('origin');
        $destination = $this->request->getPost('destination');
        $weight = $this->request->getPost('weight');

        $costOptions = $this->rajaOngkirModel->getCostOptions($origin, $destination, $weight);


        return $this->response->setJSON($costOptions);
    }
}
