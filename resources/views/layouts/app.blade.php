<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'تطبيق التعلم')</title>

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            background: #f4f6f8;
        }

        /* ===== MENU ===== */
        .menu {
            display: flex;
            justify-content: center;
            gap: 15px;
            background: linear-gradient(135deg, #3f51b5, #5c6bc0);
            padding: 14px;
            flex-wrap: wrap;
        }

        .menu a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 18px;
            border-radius: 12px;
            background: rgba(255,255,255,0.15);
            transition: 0.3s;
        }

        .menu a:hover,
        .menu a.active {
            background: #FFD54A;
            color: #000;
        }

        /* ===== CONTAINER ===== */
        .container {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }

        /* ===== GRID (3 f sطر) ===== */
        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        /* ===== CARD ===== */
        .card {
            background: white;
            border-radius: 18px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-6px);
        }

        .card img {
            width: 100%;
            max-height: 160px;
            object-fit: contain;
        }

        .card h3 {
            margin-top: 15px;
            font-size: 20px;
        }

        .btn {
            margin-top: 12px;
            padding: 10px 20px;
            border-radius: 25px;
            border: none;
            background: #3f51b5;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background: #303f9f;
        }

        /* ===== MEDIA QUERY ===== */

        /* Tablet */
        @media (max-width: 900px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Phone */
        @media (max-width: 600px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .menu {
                gap: 8px;
            }

            .menu a {
                padding: 8px 12px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="menu">
        <a href="/" class="{{ request()->routeIs('animale') ? 'active' : '' }}">الراسية</a>
        <a href="{{ route('animale') }}" class="{{ request()->routeIs('animale') ? 'active' : '' }}">🐾🐒🦍 الحيوانات</a>
        <a href="{{ route('fruits') }}" class="{{ request()->routeIs('fruits') ? 'active' : '' }}">🍎🍍🍓 الفواكه</a>
        <a href="{{ route('color') }}" class="{{ request()->routeIs('colors') ? 'active' : '' }}">🎨 الألوان</a>
        <a href="{{ route('math') }}">📐📏 الرياضيات </a>
        <a href="{{ route('transport') }}" class="{{ request()->routeIs('transport') ? 'active' : '' }}">🚒🚗🚕 وسائل النقل</a>
    </div>

    <div class="container">
        @yield('content')
    </div>

</body>
</html>
