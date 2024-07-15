<?php

namespace App\Controllers;

use App\Models\OrderModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\Response;
use Dompdf\Dompdf;
use Dompdf\Options;

class TransaksiController extends Controller
{
    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel(); // Inisialisasi OrderModel
    }

    public function index(): Response|string
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $role = session()->get('role');

        if ($role === 'admin') {
            $orders = $this->orderModel->findAll();
        } else if ($role === 'user') {
            $username = session()->get('username');
            $orders = $this->orderModel->where('username', $username)->findAll();
        } else {
            $orders = [];
        }

        return view('transaksi/v_transaksi', ['orders' => $orders]);
    }

    public function update_status()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status') === 'true' ? true : false;

        if ($id !== null) {
            $data = [
                'status' => $status
            ];

            $this->orderModel->update($id, $data);

            session()->setFlashdata('success', 'Berhasil update status.');


            return redirect()->to('/transaksi');
        }

        session()->setFlashdata('error', 'Gagal update status.');
        return redirect()->to('/transaksi');
    }

    public function print_pdf()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/transaksi')->with('error', 'Unauthorized access.');
        }

        $orders = $this->orderModel->findAll();


        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $dompdf->setOptions($options);


        $html = view('transaksi/v_transaksi_pdf', ['orders' => $orders]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Output the generated PDF
        return $dompdf->stream('transaksi_report.pdf', ['Attachment' => 0]);
    }
}
