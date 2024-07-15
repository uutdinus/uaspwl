<?php

namespace App\Controllers;

use App\Models\OrderModel;

class OrderController extends BaseController
{
    public function create()
    {
        $orderModel = new OrderModel();

        $cartController = new CartController();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'address' => 'required|string',
            'shipping_cost' => 'required|integer',
            'total_cost' => 'required|integer',
        ]);

        if (!$validation->withRequest($this->request)->run()) {

            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }


        $data = [
            'username' => session()->get('username'),
            'alamat' => $this->request->getPost('address'),
            'ongkir' => $this->request->getPost('shipping_cost'),
            'total' => $this->request->getPost('total_cost'),
            'status' => false,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];


        $orderModel->save($data);
        $cartController->cart_clear();
        session()->setFlashdata('success', 'Berhasil buat pesanan.');


        return redirect()->to('/transaksi');
    }
}
