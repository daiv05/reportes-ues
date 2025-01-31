<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    @laravelPWA
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-100">
    <main class="min-h-screen">
        <h2>Actualmente no tienes conexión a
            internet
        </h2>
    </main>
</body>
</html>
