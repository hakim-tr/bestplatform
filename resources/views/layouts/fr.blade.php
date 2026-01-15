<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>

    <style>
        body {
            margin: 0;
            font-family: 'Cairo', sans-serif;
            background: #f4f6f8;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            justify-content: space-between;
        }

        /* ===== الحاوية ===== */
        .container {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
            flex: 1;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        /* ===== GRID للبطاقات ===== */
        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 18px;
            padding: 30px 20px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .card img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .card h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color:black
        }

        /* ===== القائمة تحت ===== */
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

        /* ===== MEDIA QUERIES ===== */
        @media (max-width: 900px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .menu a {
                padding: 8px 12px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        

        <div class="grid">

            <div class="card" onclick="location.href='{{route('hopetal')}}';">
                <img src="image/hopital.jpg" alt=" في المستشفى">
                    <h5 class="card-title mt-2">الحوارات في المستشفى</h5>
            </div>
            <div class="card" onclick="location.href='{{ route('love') }}';">
                <img src="image/romance.jpg" alt="رومانسية">
                <h3> حوارات رومانسية</h3>
            </div>
            <div class="card" onclick="location.href='{{ route('shopping') }}';">
                <img src="image/shopping.jpg" alt="حوارات التسوق">
                <h3> حوارات التسوق</h3>
            </div>
            <div class="card" onclick="location.href='{{ route('café') }}';">
                <img src="image/café.jpg" alt="القهوة ">
                    <h3 class="card-text">حوارات القهوة والمقهى</h3>
            </div>
           
           
        </div>
    </div>

    <div class="menu">
        <a href="/" class="active">الرئيسية</a>
        <a href="{{ route('fruits') }}">🍎 الفواكه</a>
        <a href="{{ route('color') }}">🎨 الألوان</a>
        <a href="{{ route('transport') }}">🚗 وسائل النقل</a>
        <a href="{{ route('math') }}">📐📏 الرياضيات </a>
    </div>

</body>
</html>
