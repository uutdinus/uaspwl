<?php

namespace App\Controllers;

class CartController extends BaseController
{
    protected $cart;

    public function __construct()
    {
        helper(['number', 'form']); // Load number helper and form helper
        $this->cart = \Config\Services::cart();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $data['items'] = $this->cart->contents(); // Ambil data keranjang
        return view('cart/v_cart', $data);
    }

    public function cart_add()
    {
        $id_produk = $this->request->getPost('id');
        $harga_produk = $this->request->getPost('harga');
        $nama_produk = $this->request->getPost('nama');
        $foto_produk = $this->request->getPost('foto');

        $data = [
            'id' => $id_produk,
            'qty' => 1,
            'price' => $harga_produk,
            'name' => $nama_produk,
            'options' => ['foto' => $foto_produk]
        ];




        $this->cart->insert($data);

        session()->setFlashdata('success', 'Produk ' . $nama_produk . ' berhasil ditambahkan ke keranjang.');

        return redirect()->to(base_url('/keranjang'));
    }
    public function cart_clear()
    {
        $this->cart->destroy();
        session()->setFlashdata('success', 'Keranjang Berhasil Dikosongkan');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_edit()
    {
        $i = 1;
        foreach ($this->cart->contents() as $value) {
            $this->cart->update([
                'rowid' => $value['rowid'],
                'qty' => $this->request->getPost('qty' . $i++)
            ]);
        }

        session()->setFlashdata('success', 'Keranjang Berhasil Diedit');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_delete($rowid)
    {
        $this->cart->remove($rowid);
        session()->setFlashdata('success', 'Keranjang Berhasil Dihapus');
        return redirect()->to(base_url('keranjang'));
    }
}
?>