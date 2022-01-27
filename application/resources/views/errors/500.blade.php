<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <style>
        .btn01 a {
            background-color: #ceb849;
            border: 1px solid #ceb849;
        }

        .btn01 a:hover {
            background-color: #B99b00;
            border: 1px solid #333;
        }

        .btn01 a::after {
            content: '';
            position: absolute;
            top: 50%;
            right: -35px;
            transform: translateY(-50%);
            width: 70px;
            height: 1px;
            background-color: #333;
        }
    </style>
</head>

<body>
    <p>ERROR:500</p>
    <p>{{ $exception->getMessage() }}</p>
    <div class="btn btn01"><a href="{{ route('dashboard') }}">プロジェクト一覧に戻る</a></div>
</body>

</html>
