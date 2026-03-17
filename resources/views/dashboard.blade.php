<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">

                    <h2 class="text-2xl font-bold mb-4">
                        Sistem Prediksi Penjualan Bunga
                    </h2>

                    <p class="mb-6">
                        Anda berhasil login ke dashboard admin.
                    </p>

                    <!-- Tombol menuju halaman dataset -->
                    <div class="mb-6">
                        <a href="{{ route('sales') }}"
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Lihat Data Penjualan
                        </a>
                    </div>

                    <!-- ============================== -->
                    <!-- TAMBAHAN: Statistik Dataset -->
                    <!-- ============================== -->

                    <div class="mb-6">
                        <h3 class="text-xl font-semibold mb-3">
                            Statistik Dataset
                        </h3>

                        <p><strong>Total Data Dataset:</strong> {{ $totalData }}</p>
                        <p><strong>Periode Data:</strong> {{ $totalData }} bulan</p>
                        <p><strong>Prediksi Berikutnya:</strong> bulan ke-{{ $nextPeriod }}</p>
                    </div>

                    <hr class="mb-6">

                    <h3 class="text-xl font-semibold mb-3">
                        Prediksi Penjualan Bulan Berikutnya
                    </h3>

                    <div class="text-4xl font-bold text-green-600 mb-6">
                        {{ $prediction }} bunga
                    </div>

                    <hr class="mb-6">

                    <h3 class="text-xl font-semibold mb-3">
                        Evaluasi Model Machine Learning
                    </h3>

                    <div class="mb-6">
                        <p><strong>MAE:</strong> {{ $mae }}</p>
                        <p><strong>RMSE:</strong> {{ $rmse }}</p>
                    </div>

                    <hr class="mb-6">

                    <h3 class="text-xl font-semibold mb-4">
                        Grafik Prediksi Penjualan
                    </h3>

                    <!-- Grafik Chart.js -->
                    <canvas id="salesChart"></canvas>

                </div>

            </div>

        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const labels = @json($labels);
        const values = @json($values);

        const ctx = document.getElementById('salesChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Penjualan Bunga',
                    data: values,
                    borderWidth: 2,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</x-app-layout>