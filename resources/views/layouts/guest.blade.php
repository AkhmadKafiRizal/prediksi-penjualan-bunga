<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    <div class="min-h-screen flex">

        <!-- LEFT SIDE IMAGE -->
        <div class="hidden lg:flex lg:w-1/2">
            <img src="{{ asset('images/login.jpg') }}"
                 class="object-cover w-full h-screen"
                 alt="Background">
        </div>

        <!-- RIGHT SIDE FORM -->
        <div class="flex w-full lg:w-1/2 items-center justify-center bg-gray-50 px-8">
            {{ $slot }}
        </div>

    </div>

</body>
</html>