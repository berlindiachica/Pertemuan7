<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fintrack - Dashboard Keuangan & Manajemen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #ec4899, #8b5cf6, #3b82f6);
        }

        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .urgent-important {
            border-left: 4px solid #ef4444;
        }

        .not-urgent-important {
            border-left: 4px solid #3b82f6;
        }

        /* Mengubah warna kuning dan hijau menjadi navy */
        .urgent-not-important {
            border-left: 4px solid #1e3a8a;
        }

        /* Navy untuk kuning */
        .not-urgent-not-important {
            border-left: 4px solid #1e3a8a;
        }

        /* Navy untuk hijau */
        /* Mengubah gradient untuk kartu marketing dan employee */
        .marketing-gradient {
            background: linear-gradient(135deg, #1e3a8a, #1e40af);
        }

        /* Navy gradient */
        .employee-gradient {
            background: linear-gradient(135deg, #1e3a8a, #1e40af);
        }

        /* Navy gradient */
        .decision-gradient {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        .time-gradient {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="gradient-bg text-white p-6">
            <div class="container mx-auto">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">Fintrack</h1>
                        <p class="text-pink-200 text-sm mt-1">Selamat datang, {{ $username }}!</p>
                    </div>
                    <nav class="flex space-x-4">
                        <a href="#" class="hover:text-pink-200 transition">Dashboard</a>
                        <a href="#" class="hover:text-pink-200 transition">Keuangan</a>
                        <a href="#" class="hover:text-pink-200 transition">Manajemen Waktu</a>
                        <a href="#" class="hover:text-pink-200 transition">Marketing</a>
                        <a href="#" class="hover:text-pink-200 transition">Pengelolaan Karyawan</a>
                        <a href="#" class="hover:text-pink-200 transition">Decision Making</a>
                        <a href="#" class="hover:text-pink-200 transition">Tables</a>
                        <a href="#" class="hover:text-pink-200 transition">Billing</a>
                        <a href="#" class="hover:text-pink-200 transition">Profile</a>
                    </nav>
                </div>
            </div>
        </header>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <main class="container mx-auto p-6">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Total Balance</h3>
                    <p class="text-3xl font-bold text-gray-800 mt-2">Rp {{ number_format($total_balance, 0, ',', '.') }}
                    </p>
                    <p class="text-green-500 text-sm mt-2">+5.2% dari bulan lalu</p>
                </div>

                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Pemasukan Bulanan</h3>
                    <p class="text-2xl font-bold text-gray-800 mt-2">Rp
                        {{ number_format($monthly_income, 0, ',', '.') }}</p>
                    <p class="text-green-500 text-sm mt-2">+8% dari bulan lalu</p>
                </div>

                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Pengeluaran Bulanan</h3>
                    <p class="text-2xl font-bold text-gray-800 mt-2">Rp
                        {{ number_format($monthly_expense, 0, ',', '.') }}</p>
                    <p class="text-red-500 text-sm mt-2">+3% dari bulan lalu</p>
                </div>

                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Tabungan</h3>
                    <p class="text-2xl font-bold text-gray-800 mt-2">Rp {{ number_format($savings, 0, ',', '.') }}</p>
                    <p class="text-green-500 text-sm mt-2">+12% dari bulan lalu</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Grafik Pengeluaran & Pemasukan</h2>
                    <div class="h-80">
                        <canvas id="financeChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Manajemen Waktu (Eisenhower Matrix)</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <h3 class="font-semibold text-red-600">Penting & Mendesak</h3>
                            @foreach ($eisenhower_data as $item)
                                @if ($item['category'] == 'urgent_important')
                                    <div class="urgent-important bg-white p-3 rounded-lg border border-gray-200">
                                        <p class="font-medium">{{ $item['task'] }}</p>
                                        <p class="text-red-600 font-bold">Rp
                                            {{ number_format($item['amount'], 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">Jatuh tempo: {{ $item['due_date'] }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="space-y-3">
                            <h3 class="font-semibold text-blue-600">Penting & Tidak Mendesak</h3>
                            @foreach ($eisenhower_data as $item)
                                @if ($item['category'] == 'not_urgent_important')
                                    <div class="not-urgent-important bg-white p-3 rounded-lg border border-gray-200">
                                        <p class="font-medium">{{ $item['task'] }}</p>
                                        <p class="text-blue-600 font-bold">Rp
                                            {{ number_format($item['amount'], 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">Jatuh tempo: {{ $item['due_date'] }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="space-y-3">
                            <!-- Mengubah warna kuning menjadi navy -->
                            <h3 class="font-semibold text-navy-800">Mendesak & Tidak Penting</h3>
                            @foreach ($eisenhower_data as $item)
                                @if ($item['category'] == 'urgent_not_important')
                                    <div class="urgent-not-important bg-white p-3 rounded-lg border border-gray-200">
                                        <p class="font-medium">{{ $item['task'] }}</p>
                                        <!-- Mengubah warna kuning menjadi navy -->
                                        <p class="text-navy-800 font-bold">Rp
                                            {{ number_format($item['amount'], 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">Jatuh tempo: {{ $item['due_date'] }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="space-y-3">
                            <!-- Mengubah warna hijau menjadi navy -->
                            <h3 class="font-semibold text-navy-800">Tidak Mendesak & Tidak Penting</h3>
                            @foreach ($eisenhower_data as $item)
                                @if ($item['category'] == 'not_urgent_not_important')
                                    <div
                                        class="not-urgent-not-important bg-white p-3 rounded-lg border border-gray-200">
                                        <p class="font-medium">{{ $item['task'] }}</p>
                                        <!-- Mengubah warna hijau menjadi navy -->
                                        <p class="text-navy-800 font-bold">Rp
                                            {{ number_format($item['amount'], 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">Jatuh tempo: {{ $item['due_date'] }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl card-shadow p-6 mt-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Progress Tabungan</h2>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-600">Target: Rp 10.000.000</span>
                    <span class="text-blue-600 font-bold">{{ round(($savings / 10000000) * 100) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="gradient-bg h-4 rounded-full" style="width: {{ ($savings / 10000000) * 100 }}%"></div>
                </div>
                <p class="text-gray-600 text-sm mt-2">Sisa yang dibutuhkan: Rp
                    {{ number_format(10000000 - $savings, 0, ',', '.') }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mt-8">
                <div class="marketing-gradient text-white rounded-2xl card-shadow p-6">
                    <h3 class="text-sm font-medium">Leads Baru</h3>
                    <p class="text-3xl font-bold mt-2">{{ $marketing_data['leads'] ?? 150 }}</p>
                    <p class="text-blue-200 text-sm mt-2">+12% dari bulan lalu</p>
                </div>

                <div class="marketing-gradient text-white rounded-2xl card-shadow p-6">
                    <h3 class="text-sm font-medium">Konversi Penjualan</h3>
                    <p class="text-3xl font-bold mt-2">{{ $marketing_data['conversions'] ?? 45 }}%</p>
                    <p class="text-blue-200 text-sm mt-2">Target: 50%</p>
                </div>

                <div class="marketing-gradient text-white rounded-2xl card-shadow p-6">
                    <h3 class="text-sm font-medium">ROI Kampanye</h3>
                    <p class="text-3xl font-bold mt-2">Rp
                        {{ number_format($marketing_data['roi'] ?? 2500000, 0, ',', '.') }}</p>
                    <p class="text-blue-200 text-sm mt-2">+15% pertumbuhan</p>
                </div>

                <div class="marketing-gradient text-white rounded-2xl card-shadow p-6">
                    <h3 class="text-sm font-medium">Engagement Sosmed</h3>
                    <p class="text-3xl font-bold mt-2">{{ $marketing_data['engagement'] ?? 1200 }}</p>
                    <p class="text-blue-200 text-sm mt-2">Interaksi harian</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Grafik Marketing (Leads vs Konversi)</h2>
                    <div class="h-80">
                        <canvas id="marketingChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Pengelolaan Karyawan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="employee-gradient text-white rounded-lg p-4">
                            <h3 class="font-semibold">Jumlah Karyawan</h3>
                            <p class="text-2xl font-bold">{{ $employee_data['total'] ?? 25 }}</p>
                        </div>
                        <div class="employee-gradient text-white rounded-lg p-4">
                            <h3 class="font-semibold">Kehadiran Bulan Ini</h3>
                            <p class="text-2xl font-bold">{{ $employee_data['attendance'] ?? 95 }}%</p>
                        </div>
                        <div class="employee-gradient text-white rounded-lg p-4">
                            <h3 class="font-semibold">Performa Rata-rata</h3>
                            <p class="text-2xl font-bold">{{ $employee_data['performance'] ?? 4.2 }}/5</p>
                        </div>
                        <div class="employee-gradient text-white rounded-lg p-4">
                            <h3 class="font-semibold">Karyawan Baru</h3>
                            <p class="text-2xl font-bold">{{ $employee_data['new'] ?? 3 }}</p>
                            <p class="text-xs">Dari rekrutmen terbaru</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="#" class="text-blue-600 hover:underline text-sm">Kelola Karyawan →</a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl card-shadow p-6 mt-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Decision Making Tools</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="decision-gradient text-white rounded-lg p-4">
                        <h3 class="font-semibold mb-2">Pros & Cons Analisis</h3>
                        <ul class="space-y-1 text-sm">
                            <li class="flex justify-between"><span>Pro: Efisien</span><span>8/10</span></li>
                            <li class="flex justify-between"><span>Kontra: Biaya Tinggi</span><span>4/10</span></li>
                            <li class="flex justify-between"><span>Pro: Skalabel</span><span>9/10</span></li>
                        </ul>
                        <p class="mt-2 text-xs">Skor Keseluruhan: {{ $decision_data['score'] ?? 7.3 }}/10</p>
                    </div>
                    <div class="decision-gradient text-white rounded-lg p-4">
                        <h3 class="font-semibold mb-2">Rekomendasi Keputusan</h3>
                        <div class="space-y-2">
                            @foreach ($decision_data['recommendations'] ?? ['Investasi Marketing', 'Rekrut Karyawan Baru', 'Optimasi Waktu'] as $rec)
                                <div class="flex justify-between bg-white/20 rounded p-2">
                                    <span>{{ $rec }}</span>
                                    <span class="text-green-200">Prioritas Tinggi</span>
                                </div>
                            @endforeach
                        </div>
                        <a href="#" class="mt-2 inline-block text-xs underline">Tambah Keputusan Baru →</a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const ctx = document.getElementById('financeChart').getContext('2d');
        const financeChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($monthly_data['labels']),
                datasets: [{
                        label: 'Pemasukan',
                        data: @json($monthly_data['income']),
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Pengeluaran',
                        data: @json($monthly_data['expense']),
                        borderColor: '#ec4899',
                        backgroundColor: 'rgba(236, 72, 153, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        const marketingCtx = document.getElementById('marketingChart').getContext('2d');
        const marketingChart = new Chart(marketingCtx, {
            type: 'line',
            data: {
                labels: @json($monthly_data['labels']),
                datasets: [{
                        label: 'Pemasukan',
                        data: @json($monthly_data['income']),
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Pengeluaran',
                        data: @json($monthly_data['expense']),
                        borderColor: '#ec4899',
                        backgroundColor: 'rgba(236, 72, 153, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
