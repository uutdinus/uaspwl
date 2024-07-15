<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OrderModel; // Pastikan model OrderModel sudah ada
use App\Models\UserModel; // Pastikan model UserModel sudah ada

class DashboardController extends BaseController
{
    protected $orderModel;
    protected $userModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Rekap bulanan
        $monthlyData = $this->getMonthlyData();

        // Rekap tahunan
        $annualData = $this->getAnnualData();

        $data = [
            'monthlyData' => $monthlyData,
            'annualData' => $annualData,
        ];

        return view('/dashboard/v_dashboard', $data);
    }

    private function getMonthlyData()
    {
        $currentYear = date('Y');


        $monthlyOrders = $this->orderModel->select('MONTH(created_at) as month, COUNT(id) as transaction_count, SUM(total) as total_amount')
            ->where('YEAR(created_at)', $currentYear)
            ->groupBy('MONTH(created_at)')
            ->findAll();

        $totalRevenueMonthly = array_sum(array_column($monthlyOrders, 'total_amount'));


        $monthlyUserCounts = [];
        foreach ($monthlyOrders as $order) {
            $month = $order['month'];

            $userCount = $this->orderModel->select('DISTINCT user_id')
                ->where('YEAR(created_at)', $currentYear)
                ->where('MONTH(created_at)', $month)
                ->countAllResults();
            $monthlyUserCounts[$month] = $userCount;
        }

        return [
            'monthlyOrders' => $monthlyOrders,
            'totalRevenueMonthly' => $totalRevenueMonthly,
            'monthlyUserCounts' => $monthlyUserCounts,
        ];
    }


    private function getAnnualData()
    {
        $currentYear = date('Y');


        $annualOrders = $this->orderModel->select('MONTH(created_at) as month, COUNT(id) as transaction_count, SUM(total) as total_amount')
            ->where('YEAR(created_at)', $currentYear)
            ->groupBy('MONTH(created_at)')
            ->findAll();

        $totalRevenue = array_sum(array_column($annualOrders, 'total_amount'));


        $totalOrders = array_sum(array_column($annualOrders, 'transaction_count'));


        $monthlyUserCounts = [];
        foreach ($annualOrders as $order) {
            $month = $order['month'];
            $userCount = $this->orderModel->where('MONTH(created_at)', $month)
                ->distinct()
                ->countAllResults('user_id');
            $monthlyUserCounts[$month] = $userCount;
        }


        $totalUsers = $this->userModel->countAll();

        return [
            'annualOrders' => $annualOrders,
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'totalUsers' => $totalUsers,
            'monthlyUserCounts' => $monthlyUserCounts,
        ];
    }

}
