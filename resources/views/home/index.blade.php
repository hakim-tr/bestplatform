<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kids Magical Game</title>
<style>
    body { margin:0; overflow:hidden; font-family:'Inter', sans-serif; background:#000; }
    canvas { display:block; }
/* FORCE dialogs in ONE ROW */
.dialog-menu {
    position: absolute;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    display: grid;
    grid-auto-flow: column;   /* ← سطر واحد بالقوة */
    gap: 30px;
    z-index: 9999;
    pointer-events: auto;
    a{
        
    }
}

/* Dialog item */
.dialog-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    color: black;
}

.dialog-item img {
    width: 120px;
    height: 120px;
    background: white;
    border-radius: 12px;
    border: 3px solid black;
}

.dialog-item span {
    margin-top: 6px;
    background: white;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 14px;
    border: 2px solid black;
}

/* EVEN ON MOBILE stay one row */
@media (max-width: 480px) {
    .dialog-menu {
        gap: 15px;
    }
}

    /* Overlay Title and Stats */
    .overlay {
        position: absolute;
        top:0; left:0; width:100%; height:100%;
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
        text-align:center;
        color:white;
        z-index:1;
        pointer-events:none;
        padding: 1rem;
        margin-top: 30px;
    }

    h1 {
        font-size:4rem;
        margin-bottom:1rem;
        background: linear-gradient(135deg, #f5a, #8af, #ff0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: glowText 2s ease-in-out infinite alternate;
    }

    @keyframes glowText {
        0% { text-shadow:0 0 5px #f5a,0 0 10px #8af; }
        100% { text-shadow:0 0 20px #f5a,0 0 40px #8af; }
    }

    .stats {
        display:flex;
        gap:2rem;
        margin-top:2rem;
        font-size:1.2rem;
        pointer-events:auto;
        flex-wrap: wrap;
        justify-content:center;
    }

    .stat {
        background: rgba(255,255,255,0.1);
        padding:1rem 2rem;
        border-radius:1rem;
        box-shadow: 0 0 10px rgba(255,255,255,0.3);
        transition: transform 0.2s;
        margin: 0.5rem;
    }

    .stat:hover { transform: scale(1.05); }

    /* Auth Menu Icons أعلى الشاشة */
    .auth-menu {
        display:flex;
        position:absolute;
        top:1rem;
        left:50%;
        transform:translateX(-50%);
        gap:1rem;
        z-index:3;
        pointer-events:auto;
    }

    .auth-icon {
        display:flex;
        flex-direction:column;
        align-items:center;
        text-decoration:none;
        color:white;
    }

    .auth-icon img {
        background: white ;
        width:80px;
        height:80px;
        border:3px solid rgba(228, 220, 220, 0.94);
        border-radius:1rem;
        transition: transform 0.3s, border 0.3s;
    }

    .auth-icon:hover img {
        transform: scale(1.2) rotate(-5deg);
        border-color: rgba(255,255,255,0.8);
    }

    .icon-label {
        margin-top:0.5rem;
        font-size:1rem;
        background: rgba(254, 254, 254, 1);
        padding:0.3rem 0.6rem;
        border-radius:0.5rem;
        text-align:center;
        border:3px black solid ;
        color:black;
    }

    /* Game Menu */
    .game-menu {
        position:absolute;
        bottom:2rem;
        display:flex;
        justify-content:center;
        flex-wrap: wrap;
        gap:2rem;
        width:100%;
        pointer-events:auto;
        z-index:2;
    }

    .menu-icon {
        display:flex;
        flex-direction:column;
        align-items:center;
        text-decoration:none;
        color:white;
        transition: transform 0.3s;
    }

    .menu-icon img {
        width:120px;
        height:120px;
        background: white;
        object-fit:contain;
        border: 3px solid rgba(255, 255, 255, 1);
        border-radius:1rem;
        transition: transform 0.3s, border 0.3s;
    }

    .menu-icon:hover img {
        transform: scale(1.1);
        border-color: rgba(255,255,255,0.8);
    }

    /* Media Queries */
    @media (max-width:768px){
        h1 { font-size:3rem; }
        .stats { font-size:1rem; gap:1rem; }
        .menu-icon img { width:90px; height:90px; }
        .auth-icon img { width:60px; height:60px; }
        .icon-label { font-size:0.9rem; }

    }

    @media (max-width:480px){
        h1 { font-size:2.2rem; }
        .stats { font-size:0.9rem; gap:0.5rem; }
        .menu-icon img { width:70px; height:70px; }
        .auth-icon img { width:50px; height:50px; }
        .icon-label { font-size:0.8rem; }
    }

    
</style>
<style>
/* CONTAINER OF IMAGES */
.side-images {
    position: absolute;
    top: 100px;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: space-between;
    padding: 0 40px;
    z-index: 5;
}

/* IMAGES STYLE */
.side-images img {
    width: 420px;
    height: auto;
    animation: float 3s ease-in-out infinite;
}

/* FLOAT ANIMATION */
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
    100% { transform: translateY(0px); }
}

/* Tablet */
@media (max-width: 1024px) {
    .side-images {
        top: 110px;
        padding: 0 30px;
    }
    .side-images img {
        width: 320px;
       
    }
}
@media (max-width: 768px) {
    .side-images {
        top: 120px;
        padding: 0 15px;
    }
    .side-images img {
        width: 260px;
      
    }
}

/* Small phones */
@media (max-width: 480px) {
    .side-images {
        top: 140px;
        padding: 0 10px;
    }
    .side-images img {
        width: 170px;
        animation: float 2.5s ease-in-out infinite;
        margin-top: 100px;;
    }
    .game-menu {
        bottom: 1rem;
        gap: 1rem;
    }
@media (max-width: 360px) {
    .side-images img {
        width: 140px;
         animation: float 2.5s ease-in-out infinite;
        margin-top: 100px;;
    }
     .game-menu{
        margin-top: 150px;
     
    }
     
}

</style>


</head>
<body>
   <div class="dialog-menu">
    <a href="{{ route('francais') }}" class="dialog-item">
        <img src="/image/fr.jpg" alt="Francais">
        <span>حوارات فرنسية</span>
    </a>

   
</div>


<div class="side-images">

    <img src="/image/asd1.png" alt="Left Image" class="left-img">
    <img src="/image/nasr1.png" alt="Right Image" class="right-img">
</div>


<canvas id="animationCanvas"></canvas>

<div class="overlay">
    <h1>مغامرة الأطفال السحرية</h1>
    <div class="stats">
        <div class="stat">👦 Players: 1M+</div>
        <div class="stat">⭐ Rating: 4.9</div>
        <div class="stat">🏆 Awards: 15+</div>
        <div class="stat">❤️ Reviews: 50K+</div>
    </div>
</div>

<!-- Auth Menu أعلى -->


<!-- Game Menu -->
<div class="game-menu">
    <a href="{{ route('color') }}" class="menu-icon">
        <img src="/assets/images/color.png" alt="Colors">
        <div class="icon-label">الألوان </div>
    </a>
    <a href="{{ route('math') }}" class="menu-icon">
        <img src="/assets/images/math.png" alt="Math">
        <div class="icon-label">الرياضيات</div>
    </a>
  
    <a href="{{route('animale')}}" class="menu-icon">
        <img src="/assets/images/animals.png" alt="Animals">
        <div class="icon-label">الحيوانات</div>
    </a>
    <a href="{{route('fruits')}}" class="menu-icon">
        <img src="/assets/images/fruits.png" alt="Fruits">
        <div class="icon-label">الفواكه</div>
    </a>
    <a href="{{ route('transport') }}" class="menu-icon">
        <img src="/assets/images/transport.png" alt="Transport">
        <div class="icon-label">وسائل النقل</div>
    </a>
</div>

<script>
// Particle Animation
const canvas = document.getElementById('animationCanvas');
const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

window.addEventListener('resize', ()=>{
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    initParticles(150);
});

let particles = [];
class Particle {
    constructor(x,y,size,color,velocity){
        this.x=x; this.y=y; this.size=size; this.color=color; this.velocity=velocity;
    }
    draw(){
        ctx.beginPath();
        ctx.arc(this.x,this.y,this.size,0,Math.PI*2);
        ctx.fillStyle=this.color;
        ctx.fill();
    }
    update(){
        this.x+=this.velocity.x;
        this.y+=this.velocity.y;
        if(this.x+this.size>canvas.width||this.x-this.size<0) this.velocity.x*=-1;
        if(this.y+this.size>canvas.height||this.y-this.size<0) this.velocity.y*=-1;
        this.draw();
    }
}

function initParticles(count){
    particles=[];
    for(let i=0;i<count;i++){
        const size=Math.random()*5+2;
        const x=Math.random()*(canvas.width-size*2)+size;
        const y=Math.random()*(canvas.height-size*2)+size;
        const color=`hsl(${Math.random()*360},70%,50%)`;
        const velocity={x:(Math.random()-0.5)*2, y:(Math.random()-0.5)*2};
        particles.push(new Particle(x,y,size,color,velocity));
    }
}

function animate(){
    ctx.fillStyle='rgba(0,0,0,0.05)';
    ctx.fillRect(0,0,canvas.width,canvas.height);
    particles.forEach(p=>p.update());
    requestAnimationFrame(animate);
}

initParticles(150);
animate();
</script>
</body>
</html>
