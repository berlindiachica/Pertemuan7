<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeAdvanceController extends Controller
{
    /**
     *
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // --- DATA KEUANGAN UTAMA ---
        $totalBalance = 85000000;
        $monthlyIncome = 15000000;
        $monthlyExpense = 7000000;
        $savings = 7800000;

        // --- DATA GRAFIK BULANAN  ---
        $monthlyData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'],
            'income' => [12000000, 13500000, 15000000, 14000000, 16000000, 17000000, 15500000, 18000000, 16500000, $monthlyIncome],
            'expense' => [6500000, 7000000, 7500000, 6800000, 7200000, 7500000, 7000000, 8000000, 7500000, $monthlyExpense],
        ];

        $eisenhowerData = [
            [
                'task' => 'Bayar Sewa Kantor',
                'amount' => 5000000,
                'due_date' => Carbon::now()->addDays(2)->format('d M'),
                'category' => 'urgent_important'
            ],
            [
                'task' => 'Meeting Klien A (Follow-up)',
                'amount' => 0,
                'due_date' => Carbon::now()->addDays(1)->format('d M'),
                'category' => 'urgent_important'
            ],
            [
                'task' => 'Riset Pasar Kuartal Depan',
                'amount' => 0,
                'due_date' => Carbon::now()->addDays(15)->format('d M'),
                'category' => 'not_urgent_important'
            ],
            [
                'task' => 'Perencanaan Tabungan Jangka Panjang',
                'amount' => 0,
                'due_date' => Carbon::now()->addDays(30)->format('d M'),
                'category' => 'not_urgent_important'
            ],
            [
                'task' => 'Mengecek Email Promosi',
                'amount' => 0,
                'due_date' => Carbon::now()->addDays(0)->format('d M'),
                'category' => 'urgent_not_important'
            ],
            [
                'task' => 'Membersihkan Meja Kerja',
                'amount' => 0,
                'due_date' => 'Kapan saja',
                'category' => 'not_urgent_not_important'
            ],
        ];

        // --- DATA MARKETING  ---
        $marketingData = [
            'leads' => 175,
            'conversions' => 48,
            'roi' => 3250000,
            'engagement' => 1350,
        ];

        // --- DATA PENGELOLAAN KARYAWAN  ---
        $employeeData = [
            'total' => 30,
            'attendance' => 97,
            'performance' => 4.3,
            'new' => 4,
        ];

        // --- DATA DECISION MAKING  ---
        $decisionData = [
            'score' => 7.8,
            'recommendations' => [
                'Prioritaskan Pembayaran Utang',
                'Alokasikan Dana untuk Riset',
                'Tinjau Ulang Kontrak Vendor C'
            ],
        ];

        return view('halaman-advance-user', [
            'username' => 'BOSS BESAR',
            'total_balance' => $totalBalance,
            'monthly_income' => $monthlyIncome,
            'monthly_expense' => $monthlyExpense,
            'savings' => $savings,
            'monthly_data' => $monthlyData,
            'eisenhower_data' => $eisenhowerData,
            'marketing_data' => $marketingData,
            'employee_data' => $employeeData,
            'decision_data' => $decisionData,
        ]);
    }
}
