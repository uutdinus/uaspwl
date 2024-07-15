<?php

namespace App\Controllers;

use App\Models\ProdukModel;


class Home extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        helper(['form', 'number']);

        $produkModel = new ProdukModel();
        $data['produk'] = $produkModel->findAll();

        return view('/home/v_home', $data);
    }

   



  

}
