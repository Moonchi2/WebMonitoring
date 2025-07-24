<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Login')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4CAF50">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: url('{{ asset('img/bg/background.jpg') }}') no-repeat center center fixed;
            background-size: cover;
        }
        .login-box {
            max-width: 400px;
            margin: 5% auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            padding: 32px;
        }
        .logo-img {
            width: 64px;
            height: 64px;
            object-fit: contain;
            margin: 0 auto 12px;
            display: block;
        }
    </style>
    @stack('style')
</head>
<body>
    @yield('main')
</body>
</html>
