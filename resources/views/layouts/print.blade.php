<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <style>
        body { padding: 20px; font-family: 'Source Sans Pro', sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #dee2e6; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f8f9fa; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
