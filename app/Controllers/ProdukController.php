<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use CodeIgniter\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;

class ProdukController extends Controller
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
    }

    public function index(): string
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $data['produk'] = $this->produkModel->findAll();
        return view('product/v_produk', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required|min_length[6]',
            'harga' => 'required',
            'jumlah' => 'required|numeric',
            'foto' => 'uploaded[foto]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $file = $this->request->getFile('foto');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('img', $newName);
        }

        $hargaStr = $this->request->getPost('harga');
        $harga = (int) preg_replace('/[^0-9]/', '', $hargaStr);

        $data = [
            'nama' => $this->request->getPost('nama'),
            'harga' => $harga,
            'jumlah' => $this->request->getPost('jumlah'),
            'foto' => $newName ?? null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->produkModel->save($data);

        session()->setFlashdata('success', 'Produk berhasil ditambahkan!');

        return redirect()->to('/produk');
    }

    public function update()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required|min_length[6]', // Aturan baru untuk minimal 6 karakter
            'harga' => 'required',
            'jumlah' => 'required|numeric',
            'foto' => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }


        $id = intval($this->request->getPost('id'));
        $nama = $this->request->getPost('nama');
        $harga = $this->request->getPost('harga');
        $jumlah = intval($this->request->getPost('jumlah'));
        $foto = $this->request->getFile('foto');

        $hargaFormat = (int) preg_replace('/[^0-9]/', '', $harga);

        if (empty($id) || empty($nama) || empty($hargaFormat) || empty($jumlah)) {
            $errorMessage = 'Harap lengkapi ';
            if (empty($id)) {
                $errorMessage .= 'ID, ';
            }
            if (empty($nama)) {
                $errorMessage .= 'nama, ';
            }
            if (empty($harga)) {
                $errorMessage .= 'harga, ';
            }
            if (empty($jumlah)) {
                $errorMessage .= 'jumlah, ';
            }

            $errorMessage = rtrim($errorMessage, ', ') . '.';
            return redirect()->back()->withInput()->with('error', $errorMessage);

        }


        $model = new ProdukModel();
        $data = [
            'nama' => $nama,
            'harga' => $hargaFormat,
            'jumlah' => $jumlah
        ];


        $produkLama = $model->find($id);
        $fotoLama = $produkLama['foto'];


        if ($foto->isValid() && !$foto->hasMoved()) {

            $newName = $foto->getRandomName();
            $foto->move('img', $newName);


            $data['foto'] = $newName;


            if (!empty($fotoLama) && file_exists(ROOTPATH . 'public/img/' . $fotoLama)) {
                unlink(ROOTPATH . 'public/img/' . $fotoLama);
            }
        }


        $model->update($id, $data);


        return redirect()->to('/produk')->with('success', 'Produk berhasil diperbarui.');
    }
    public function delete($id = null)
    {
        $model = new ProdukModel();


        $produk = $model->find($id);
        if ($produk) {

            $foto = $produk['foto'];


            $path = WRITEPATH . 'uploads/';
            if (is_file($path . $foto)) {
                unlink($path . $foto);
            }
        }

        $hapus = $model->delete($id);

        if ($hapus) {

            session()->setFlashdata('success', 'Produk  "' . $produk['nama'] . '" berhasil dihapus.');
        } else {

            session()->setFlashdata('error', 'Gagal menghapus produk.');
        }


        return redirect()->to('/produk');
    }
    public function cetakPDF()
    {

        $produk = $this->produkModel->findAll();


        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);


        $dompdf = new Dompdf($options);


        $html = view('product/components/ViewPdf', ['produk' => $produk]);



        $dompdf->loadHtml($html);


        $dompdf->setPaper('A4', 'landscape');


        $dompdf->render();


        $dompdf->stream('daftar_produk.pdf', ['Attachment' => false]);
    }
}
