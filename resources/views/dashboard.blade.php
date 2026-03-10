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

                    <img src="{{ asset('prediction_graph.png') }}" style="width:100%;max-width:800px;">

                </div>

            </div>

        </div>
    </div>
</x-app-layout>