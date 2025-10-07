
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fintrack - Dashboard Keuangan & Manajemen (Dark Luxury)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #0f0f0f, #1a1a1a, #b8860b); /* Dark luxury: black to dark gray with gold accent */
        }
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2); /* Darker shadow for depth */
        }
        .urgent-important { border-left: 4px solid #dc2626; } /* Muted red for dark */
        .not-urgent-important { border-left: 4px solid #3b82f6; } /* Blue remains, but fits dark */
        .urgent-not-important { border-left: 4px solid #d97706; } /* Muted orange-gold */
        .not-urgent-not-important { border-left: 4px solid #059669; } /* Dark green */
        .marketing-gradient { background: linear-gradient(135deg, #065f46, #047857, #b8860b); } /* Dark emerald to gold */
        .employee-gradient { background: linear-gradient(135deg, #92400e, #b45309, #d97706); } /* Dark bronze-gold */
        .decision-gradient { background: linear-gradient(135deg, #581c87, #7c3aed, #a855f7); } /* Dark purple luxury */
        .time-gradient { background: linear-gradient(135deg, #1e3a8a, #1d4ed8, #b8860b); } /* Dark navy to gold */
    </style>
</head>
<body class="bg-gray-900 text-gray-100"> <!-- Dark background -->
    <div class="min-h-screen">
        <!-- Header -->
        <header class="gradient-bg text-white p-6">
            <div class="container mx-auto">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">Fintrack</h1>
                        <p class="text-yellow-300 text-sm mt-1">Selamat datang, {{ $username }}!</p> <!-- Gold accent for welcome -->
                    </div>
                    <nav class="flex space-x-4">
                        <a href="#" class="hover:text-yellow-300 transition">Dashboard</a>
                        <a href="#" class="hover:text-yellow-300 transition">Keuangan</a>
                        <a href="#" class="hover:text-yellow-300 transition">Manajemen Waktu</a>
                        <a href="#" class="hover:text-yellow-300 transition">Marketing</a>
                        <a href="#" class="hover:text-yellow-300 transition">Pengelolaan Karyawan</a>
                        <a href="#" class="hover:text-yellow-300 transition">Decision Making</a>
                        <a href="#" class="hover:text-yellow-300 transition">Tables</a>
                        <a href="#" class="hover:text-yellow-300 transition">Billing</a>
                        <a href="#" class="hover:text-yellow-300 transition">Profile</a>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Alert Success (Adapted for dark) -->
        @if(session('success'))
        <div class="bg-green-900 border border-green-700 text-green-200 px-4 py-3 rounded relative" role="alert"> <!-- Dark green alert -->
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <main class="container mx-auto p-6">
            <!-- Display Uang (Keuangan Section - Dark adapted) -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-gray-800 rounded-2xl card-shadow p-6"> <!-- Dark card -->
                    <h3 class="text-gray-400 text-sm font-medium">Total Balance</h3>
                    <p class="text-3xl font-bold text-yellow-300 mt-2">Rp {{ number_format($total_balance, 0, ',', '.') }}</p> <!-- Gold for amounts -->
                    <p class="text-green-400 text-sm mt-2">+5.2% dari bulan lalu</p>
                </div>

                <div class="bg-gray-800 rounded-2xl card-shadow p-6">
                    <h3 class="text-gray-400 text-sm font-medium">Pemasukan Bulanan</h3>
                    <p class="text-2xl font-bold text-green-300 mt-2">Rp {{ number_format($monthly_income, 0, ',', '.') }}</p>
                    <p class="text-green-400 text-sm mt-2">+8% dari bulan lalu</p>
                </div>

                <div class="bg-gray-800 rounded-2xl card-shadow p-6">
                    <h3 class="text-gray-400 text-sm font-medium">Pengeluaran Bulanan</h3>
                    <p class="text-2xl font-bold text-red-300 mt-2">Rp {{ number_format($monthly_expense, 0, ',', '.') }}</p>
                    <p class="text-red-400 text-sm mt-2">+3% dari bulan lalu</p>
                </div>

                <div class="bg-gray-800 rounded-2xl card-shadow p-6">
                    <h3 class="text-gray-400 text-sm font-medium">Tabungan</h3>
                    <p class="text-2xl font-bold text-yellow-300 mt-2">Rp {{ number_format($savings, 0, ',', '.') }}</p>
                    <p class="text-green-400 text-sm mt-2">+12% dari bulan lalu</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Grafik Pengeluaran dan Pemasukan -->
                <div class="bg-gray-800 rounded-2xl card-shadow p-6">
                    <h2 class="text-xl font-bold text-gray-100 mb-6">Grafik Pengeluaran & Pemasukan</h2>
                    <div class="h-80">
                        <canvas id="financeChart"></canvas>
                    </div>
                </div>

                <!-- Eisenhower Matrix (Dark adapted) -->
                <div class="bg-gray-800 rounded-2xl card-shadow p-6">
                    <h2 class="text-xl font-bold text-gray-100 mb-6">Manajemen Waktu (Eisenhower Matrix)</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Urgent & Important -->
                        <div class="space-y-3">
                            <h3 class="font-semibold text-red-400">Penting & Mendesak</h3>
                            @foreach($eisenhower_data as $item)
                                @if($item['category'] == 'urgent_important')
                                    <div class="urgent-important bg-gray-700 p-3 rounded-lg border border-gray-600"> <!-- Darker inner -->
                                        <p class="font-medium text-gray-100">{{ $item['task'] }}</p>
                                        <p class="text-red-400 font-bold">Rp {{ number_format($item['amount'], 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-400">Jatuh tempo: {{ $item['due_date'] }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Not Urgent & Important -->
                        <div class="space-y-3">
                            <h3 class="font-semibold text-blue-400">Penting & Tidak Mendesak</h3>
                            @foreach($eisenhower_data as $item)
                                @if($item['category'] == 'not_urgent_important')
                                    <div class="not-urgent-important bg-gray-700 p-3 rounded-lg border border-gray-600">
                                        <p class="font-medium text-gray-100">{{ $item['task'] }}</p>
                                        <p class="text-blue-400 font-bold">Rp {{ number_format($item['amount'], 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-400">Jatuh tempo: {{ $item['due_date'] }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Urgent & Not Important -->
                        <div class="space-y-3">
                            <h3 class="font-semibold text-yellow-400">Mendesak & Tidak Penting</h3>
                            @foreach($eisenhower_data as $item)
                                @if($item['category'] == 'urgent_not_important')
                                    <div class="urgent-not-important bg-gray-700 p-3 rounded-lg border border-gray-600">
                                        <p class="font-medium text-gray-100">{{ $item['task'] }}</p>
                                        <p class="text-yellow-400 font-bold">Rp {{ number_format($item['amount'], 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-400">Jatuh tempo: {{ $item['due_date'] }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Not Urgent & Not Important -->
                        <div class="space-y-3">
                            <h3 class="font-semibold text-green-400">Tidak Mendesak & Tidak Penting</h3>
                            @foreach($eisenhower_data as $item)
                                @if($item['category'] == 'not_urgent_not_important')
                                    <div class="not-urgent-not-important bg-gray-700 p-3 rounded-lg border border-gray-600">
                                        <p class="font-medium text-gray-100">{{ $item['task'] }}</p>
                                        <p class="text-green-400 font-bold">Rp {{ number_format($item['amount'], 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-400">Jatuh tempo: {{ $item['due_date'] }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabungan Section (Dark adapted) -->
            <div class="bg-gray-800 rounded-2xl card-shadow p-6 mt-8">
                <h2 class="text-xl font-bold text-gray-100 mb-6">Progress Tabungan</h2>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-400">Target: Rp 10.000.000</span>
                    <span class="text-yellow-300 font-bold">{{ round(($savings / 10000000) * 100) }}%</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-4"> <!-- Darker progress bg -->
                    <div class="gradient-bg h-4 rounded-full" style="width: {{ ($savings / 10000000) * 100 }}%"></div> <!-- Use header gradient for luxury -->
                </div>
                <p class="text-gray-400 text-sm mt-2">Sisa yang dibutuhkan: Rp {{ number_format(10000000 - $savings, 0, ',', '.') }}</p>
            </div>

            <!-- Section Baru: Marketing (Dark luxury) -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mt-8">
                <div class="marketing-gradient text-white rounded-2xl card-shadow p-6">
                    <h3 class="text-gray-200 text-sm font-medium">Leads Baru</h3>
                    <p class="text-3xl font-bold mt-2">{{ $marketing_data['leads'] ?? 150 }}</p>
                    <p class="text-green-200 text-sm mt-2">+12% dari bulan lalu</p>
                </div>

                <div class="marketing-gradient text-white rounded-2xl card-shadow p-6">
                    <h3 class="text-gray-200 text-sm font-medium">Konversi Penjualan</h3>
                    <p class="text-3xl font-bold mt-2">{{ $marketing_data['conversions'] ?? 45 }}%</p>
                    <p class="text-green-200 text-sm mt-2">Target: 50%</p>
                </div>

                <div class="marketing-gradient text-white rounded-2xl card-shadow p-6">
                    <h3 class="text-gray-200 text-sm font-medium">ROI Kampanye</h3>
                    <p class="text-3xl font-bold mt-2">Rp {{ number_format($marketing_data['roi'] ?? 2500000, 0, ',', '.') }}</p>
                    <p class="text-green-200 text-sm mt-2">+15% pertumbuhan</p>
                </div>

                <div class="marketing-gradient text-white rounded-2xl card-shadow p-6">
                    <h3 class="text-gray-200 text-sm font-medium">Engagement Sosmed</h3>
                    <p class="text-3xl font-bold mt-2">{{ $marketing_data['engagement'] ?? 1200 }}</p>
                    <p class="text-green-200 text-sm mt-2">Interaksi harian</p>
                </div>
            </div>

            <!-- Grafik Marketing (Tambahan) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                <div class="bg-gray-800 rounded-2xl card-shadow p-6">
                    <h2 class="text-xl font-bold text-gray-100 mb-6">Grafik Marketing (Leads vs Konversi)</h2>
                    <div class="h-80">
                        <canvas id="marketingChart"></canvas>
                    </div>
                </div>

                <!-- Section Baru: Pengelolaan Karyawan (Dark) -->
                <div class="bg-gray-800 rounded-2xl card-shadow p-6">
                    <h2 class="text-xl font-bold text-gray-100 mb-6">Pengelolaan Karyawan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="employee-gradient text-white rounded-lg p-4">
                            <h3 class="font-semibold text-gray-200">Jumlah Karyawan</h3>
                            <p class="text-2xl font-bold">{{ $employee_data['total'] ?? 25 }}</p>
                        </div>
                        <div class="employee-gradient text-white rounded-lg p-4">
                            <h3 class="font-semibold text-gray-200">Kehadiran Bulan Ini</h3>
                            <p class="text-2xl font-bold">{{ $employee_data['attendance'] ?? 95 }}%</p>
                        </div>
                        <div class="employee-gradient text-white rounded-lg p-4">
                            <h3 class="font-semibold text-gray-200">Performa Rata-rata</h3>
                            <p class="text-2xl font-bold">{{ $employee_data['performance'] ?? 4.2 }}/5</p>
                        </div>
                        <div class="employee-gradient text-white rounded-lg p-4">
                            <h3 class="font-semibold text-gray-200">Karyawan Baru</h3>
                            <p class="text-2xl font-bold">{{ $employee_data['new'] ?? 3 }}</p>
                            <p class="text-xs text-gray-300">Dari rekrutmen terbaru</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="#" class="text-yellow-300 hover:underline text-sm">Kelola Karyawan →</a> <!-- Gold link -->
                    </div>
                </div>
            </div>

            <!-- Section Baru: Decision Making (Dark) -->
            <div class="bg-gray-800 rounded-2xl card-shadow p-6 mt-8">
                <h2 class="text-xl font-bold text-gray-100 mb-6">Decision Making Tools</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="decision-gradient text-white rounded-lg p-4">
                        <h3 class="font-semibold mb-2 text-gray-200">Pros & Cons Analisis</h3>
                        <ul class="space-y-1 text-sm">
                            <li class="flex justify-between"><span>Pro: Efisien</span><span>8/10</span></li>
                            <li class="flex justify-between"><span>Con: Mahal</span><span>4/10</span></li>
                        </div>




      <script>

        const ctx = document.getElementById('financeChart').getContext('2d');
        const financeChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($monthly_data['labels']),
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: @json($monthly_data['income']),
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        tension: 0.4,
                        fill: true  },
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


          // Chart.js Tambahan untuk Marketing (Contoh data dummy)
        const marketingCtx = document.getElementById('marketingChart').getContext('2d');
        const marketingChart = new Chart(marketingCtx, {   type: 'line',
            data: {
                labels: @json($monthly_data['labels']),
                datasets: [
                    {
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

