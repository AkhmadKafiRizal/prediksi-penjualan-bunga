<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Prediksi Penjualan Bunga</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow: hidden; /* Mencegah scroll */
        }
        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        /* Bintang Jatuh Animasi */
        .star {
            position: absolute;
            width: 3px;
            height: 3px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #fff;
            animation: fall linear infinite;
        }
        .star::after {
            content: '';
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 30px;
            height: 1px;
            background: linear-gradient(90deg, #fff, transparent);
            left: 100%;
        }
        @keyframes fall {
            0% { transform: translate(0, -10px) rotate(-45deg); opacity: 0; }
            10% { opacity: 1; }
            80% { opacity: 1; }
            100% { transform: translate(-500px, 500px) rotate(-45deg); opacity: 0; }
        }
    </style>
</head>

<body class="antialiased text-gray-900 bg-gray-900">

    <!-- Latar Belakang Layar Penuh -->
    <div class="fixed inset-0 z-0">
        <img src="{{ asset('images/login_new.png') }}"
             class="object-cover w-full h-full"
             alt="Background Floral">
        <div class="absolute inset-0 bg-black/20"></div> <!-- Overlay gelap sedikit agar teks terbaca -->
        
        <!-- Wadah Bintang Jatuh -->
        <div id="stars-container" class="absolute inset-0 overflow-hidden pointer-events-none"></div>
    </div>

    <div class="relative z-10 flex h-screen w-full">

        <!-- KIRI: Teks & Animasi -->
        <div class="hidden lg:flex lg:w-[55%] flex-col justify-end p-16 text-white pb-24">
            <div class="animate-float max-w-xl">
                <h1 class="text-5xl font-extrabold mb-4 drop-shadow-xl text-white">Florist Insights</h1>
                <p class="text-2xl font-medium drop-shadow-lg text-white/90">Prediksi cerdas untuk bisnis bunga Anda.</p>
            </div>
        </div>

        <!-- KANAN: Form Login -->
        <div class="flex w-full lg:w-[45%] items-center justify-center p-8 lg:p-16 relative">
            <div class="w-full max-w-md fade-in">
                {{ $slot }}
            </div>
        </div>

    </div>

    <!-- Script Bintang Jatuh -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('stars-container');
            const numStars = 15; // Jumlah bintang
            
            for (let i = 0; i < numStars; i++) {
                let star = document.createElement('div');
                star.className = 'star';
                
                // Posisi awal acak
                star.style.left = Math.floor(Math.random() * 150) + '%';
                star.style.top = Math.floor(Math.random() * -50) + '%';
                
                // Durasi dan delay acak
                let duration = Math.random() * 3 + 2; // 2s - 5s
                star.style.animationDuration = duration + 's';
                star.style.animationDelay = Math.random() * 5 + 's';
                
                container.appendChild(star);
            }
        });
    </script>
</body>
</html>