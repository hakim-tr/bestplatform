<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Accueil</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    margin: 0;
    padding: 0;
    font-family: 'Cairo', sans-serif;
    min-height: 100vh;
    background-image: url('image/fr.jpg'); /* الصورة ديالك */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    display: flex;
    justify-content: center;
    align-items: flex-start;
}

.container {
    margin-top: 50px;
    width: 95%;
    max-width: 1000px;
}

h2 {
    color: #fff;
    font-weight: 900;
    margin-bottom: 30px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.5);
}

/* Cards */
.card {
    border-radius: 25px;
    transition: transform 0.3s, box-shadow 0.3s;
    background: rgba(255,255,255,0.95); /* شوية شفافية باش الخلفية تبان */
    text-align: center;
    padding: 20px;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
}

.card img {
    width: 80px;
    margin-bottom: 15px;
}

.card-title {
    font-weight: 800;
    font-size: 1.3rem;
}

.card-text {
    font-size: 1rem;
    color: #555;
}

/* Responsive */
@media(max-width:768px){
    .card img {
        width: 70px;
    }
    .card-title {
        font-size: 1.1rem;
    }
    .card-text {
        font-size: 0.95rem;
    }
}
@media(max-width:480px){
    .card img {
        width: 60px;
    }
    .card-title {
        font-size: 1rem;
    }
    .card-text {
        font-size: 0.9rem;
    }
}
</style>
</head>

<body>

<div class="container py-5">

    <h2 class="text-center">مرحبا بك في موقعنا</h2>

    <div class="row g-4 justify-content-center">

        <!-- Carte 1 -->
        <div class="col-md-4 col-sm-6">
            <a href="{{ route('hopetal') }}" class="text-decoration-none">
                <div class="card h-100 shadow">
                    <img src="image/hopital.jpg" class="mx-auto" alt="Hopital">
                    <h5 class="card-title mt-2">الحوارات في المستشفى</h5>
                    <p class="card-text">تمارين وعبارات المستشفى</p>
                </div>
            </a>
        </div>

        <!-- Carte 2 -->
        <div class="col-md-4 col-sm-6">
            <a href="{{ route('love') }}" class="text-decoration-none">
                <div class="card h-100 shadow">
                    <img src="image/romance.jpg" class="mx-auto" alt="Romance">
                    <h5 class="card-title mt-2">في رومانسية</h5>
                    <p class="card-text">حوارات رومانسية ممتعة</p>
                </div>
            </a>
        </div>

        <!-- Carte 3 -->
        <div class="col-md-4 col-sm-6">
            <a href="{{ route('shopping') }}" class="text-decoration-none">
                <div class="card h-100 shadow">
                    <img src="image/shopping.jpg" class="mx-auto" alt="Shopping">
                    <h5 class="card-title mt-2">التسوق</h5>
                    <p class="card-text">حوارات التسوق اليومية</p>
                </div>
            </a>
        </div>

        <!-- Carte 4 -->
        <div class="col-md-4 col-sm-6">
            <a href="{{ route('café') }}" class="text-decoration-none">
                <div class="card h-100 shadow">
                    <img src="image/café.jpg" class="mx-auto" alt="Café">
                    <h5 class="card-title mt-2">Café</h5>
                    <p class="card-text">حوارات القهوة والمقهى</p>
                </div>
            </a>
        </div>

    </div>
</div>

</body>
</html>
