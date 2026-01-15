<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>لعبة حوارات التسوق 🛒</title>

<style>
body{
  margin:0;padding:0;font-family:Cairo,sans-serif;
  background:#f0f9ff;
  display:flex;justify-content:center;align-items:center;
  min-height:100vh;
}
.wrapper{
  background:#ffffff;
  padding:20px;
  width:95%;max-width:650px;
  border-radius:20px;
  box-shadow:0 0 20px rgba(0,128,255,.4);
  text-align:center;
}
.level-card{
  background:#4fc3f7;
  color:#fff;
  padding:10px;
  border-radius:12px;
  font-weight:800;
}
.progress-bar{
  width:100%;height:15px;
  background:#ddd;
  border-radius:10px;
  margin:15px 0;
  overflow:hidden;
}
.progress-fill{
  height:100%;
  width:0%;
  background:linear-gradient(90deg,#00bcd4,#2196f3);
  transition:.4s;
}
.card{
  background:#e3f2fd;
  padding:15px;
  border-radius:15px;
  font-size:20px;
  font-weight:700;
}
.listen-btn{
  display:inline-block;
  margin-top:10px;
  background:#2196f3;
  color:#fff;
  padding:8px 14px;
  border-radius:10px;
  cursor:pointer;
  font-weight:800;
}
.options{
  display:flex;
  flex-wrap:wrap;
  justify-content:space-between;
  margin-top:15px;
}
.opt-btn{
  width:48%;
  background:#bbdefb;
  margin-bottom:10px;
  padding:12px;
  border-radius:12px;
  font-weight:800;
  cursor:pointer;
  transition:.2s;
}
.opt-btn:hover{transform:scale(1.05);}
.msg{
  margin-top:10px;
  font-size:18px;
  font-weight:800;
}
.reset-btn{
  margin-top:10px;
  background:#ff5252;
  color:#fff;
  border:none;
  padding:10px 15px;
  border-radius:12px;
  cursor:pointer;
  font-weight:800;
}
.monkey{
  width:100px;
  margin:10px auto;
}
@media(max-width:480px){
  .opt-btn{width:100%;}
}
</style>
</head>

<body>
@extends('layouts.fr')

<div class="wrapper">

  <div class="level-card">
    المستوى: <span id="level"></span> |
    سؤال: <span id="current"></span> / <span id="total"></span>
  </div>

  <div class="progress-bar">
    <div class="progress-fill" id="progress"></div>
  </div>

  <!-- 🐒 MONKEY -->
  <img src="assets/monkey/neutral.png" id="monkey" class="monkey">

  <div class="card">
    <div id="question"></div>
    <div class="listen-btn" onclick="speak()">🔊 اسمع</div>
  </div>

  <button class="reset-btn" onclick="resetGame()">🔄 إعادة من البداية</button>

  <div class="options" id="options"></div>
  <div class="msg" id="msg"></div>

</div>

<!-- 🔊 AUDIO -->
<audio id="successSound" src="assets/audio/success.mp3"></audio>
<audio id="failSound" src="assets/audio/fail.mp3"></audio>

<script>
const dialogues = [
{fr:"Bonjour, je veux faire du shopping.", ar:"مرحبا، أريد القيام بالتسوق."},
{fr:"Je cherche un magasin.", ar:"أبحث عن متجر."},
{fr:"Où est le centre commercial ?", ar:"أين المركز التجاري؟"},
{fr:"Je veux acheter quelque chose.", ar:"أريد شراء شيء."},
{fr:"Combien ça coûte ?", ar:"بكم هذا؟"},
{fr:"C’est trop cher.", ar:"هذا غالي جداً."},
{fr:"C’est pas cher.", ar:"هذا غير غالي."},
{fr:"Avez-vous une réduction ?", ar:"هل عندكم تخفيض؟"},
{fr:"C’est en promotion.", ar:"هذا في التخفيض."},
{fr:"Je veux comparer les prix.", ar:"أريد مقارنة الأسعار."},

{fr:"Je cherche des vêtements.", ar:"أبحث عن ملابس."},
{fr:"Je veux acheter un pantalon.", ar:"أريد شراء سروال."},
{fr:"Je veux acheter une chemise.", ar:"أريد شراء قميص."},
{fr:"Je veux acheter une robe.", ar:"أريد شراء فستان."},
{fr:"Je veux acheter des chaussures.", ar:"أريد شراء حذاء."},
{fr:"Avez-vous cette taille ?", ar:"هل عندكم هذا المقاس؟"},
{fr:"C’est trop grand.", ar:"هذا كبير جداً."},
{fr:"C’est trop petit.", ar:"هذا صغير جداً."},
{fr:"Je veux essayer ça.", ar:"أريد تجربة هذا."},
{fr:"Où est la cabine d’essayage ?", ar:"أين غرفة القياس؟"},

{fr:"Avez-vous une autre couleur ?", ar:"هل عندكم لون آخر؟"},
{fr:"Je préfère celui-ci.", ar:"أفضل هذا."},
{fr:"Je prends celui-là.", ar:"سآخذ هذا."},
{fr:"C’est de bonne qualité.", ar:"جودته جيدة."},
{fr:"Ce n’est pas mon style.", ar:"هذا ليس ذوقي."},
{fr:"Je cherche quelque chose de simple.", ar:"أبحث عن شيء بسيط."},
{fr:"Je cherche quelque chose de moderne.", ar:"أبحث عن شيء عصري."},
{fr:"C’est à la mode.", ar:"هذا على الموضة."},
{fr:"C’est confortable.", ar:"هذا مريح."},
{fr:"Je vais réfléchir.", ar:"سأفكر في الأمر."},

{fr:"Je reviens plus tard.", ar:"سأعود لاحقاً."},
{fr:"Je regarde seulement.", ar:"أنا فقط أتفرج."},
{fr:"C’est pour moi.", ar:"هذا لي."},
{fr:"C’est pour offrir.", ar:"هذا كهدية."},
{fr:"Je cherche un cadeau.", ar:"أبحث عن هدية."},
{fr:"C’est pour un enfant.", ar:"هذا لطفل."},
{fr:"C’est pour un adulte.", ar:"هذا لشخص بالغ."},
{fr:"Avez-vous une garantie ?", ar:"هل هناك ضمان؟"},
{fr:"Je veux changer cet article.", ar:"أريد تبديل هذا المنتج."},
{fr:"Je veux un remboursement.", ar:"أريد استرجاع المال."},

{fr:"Où est la caisse ?", ar:"أين الصندوق؟"},
{fr:"Je veux payer.", ar:"أريد الدفع."},
{fr:"Je paie en espèces.", ar:"سأدفع نقداً."},
{fr:"Je paie par carte.", ar:"سأدفع بالبطاقة."},
{fr:"Puis-je avoir un ticket ?", ar:"هل يمكنني أخذ الفاتورة؟"},
{fr:"Puis-je avoir un sac ?", ar:"هل يمكنني أخذ كيس؟"},
{fr:"C’est cassé.", ar:"هذا مكسور."},
{fr:"Il manque quelque chose.", ar:"ينقصه شيء."},
{fr:"Je fais les courses.", ar:"أقوم بالتسوق."},
{fr:"Merci pour votre aide.", ar:"شكراً على المساعدة."},

{fr:"Le magasin est fermé.", ar:"المتجر مغلق."},
{fr:"Le magasin est ouvert.", ar:"المتجر مفتوح."},
{fr:"C’est mon magasin préféré.", ar:"هذا متجري المفضل."},
{fr:"Je viens souvent ici.", ar:"آتي إلى هنا كثيراً."},
{fr:"Il y a beaucoup de choix.", ar:"هناك اختيارات كثيرة."},
{fr:"Il n’y a plus de stock.", ar:"المنتج غير متوفر."},
{fr:"C’est une bonne affaire.", ar:"صفقة جيدة."},
{fr:"Je veux acheter aujourd’hui.", ar:"أريد الشراء اليوم."},
{fr:"À bientôt.", ar:"إلى اللقاء."},
{fr:"Au revoir.", ar:"مع السلامة."}
];


let level = parseInt(localStorage.getItem("shop_level")) || 1;
let current = parseInt(localStorage.getItem("shop_current")) || 0;

const question=document.getElementById("question");
const options=document.getElementById("options");
const msg=document.getElementById("msg");
const progress=document.getElementById("progress");
const levelEl=document.getElementById("level");
const currentEl=document.getElementById("current");
const monkey=document.getElementById("monkey");
const successSound=document.getElementById("successSound");
const failSound=document.getElementById("failSound");

document.getElementById("total").innerText = dialogues.length;

function loadQuestion(){
  const q = dialogues[current];
  question.innerText = q.fr;
  levelEl.innerText = level;
  currentEl.innerText = current+1;
  monkey.src="assets/monkey/neutral.png";
  msg.innerText="";

  let opts=[q.ar];
  while(opts.length<4){
    let r=dialogues[Math.floor(Math.random()*dialogues.length)].ar;
    if(!opts.includes(r)) opts.push(r);
  }
  opts.sort(()=>Math.random()-0.5);

  options.innerHTML="";
  opts.forEach(o=>{
    let d=document.createElement("div");
    d.className="opt-btn";
    d.innerText=o;
    d.onclick=()=>checkAnswer(o);
    options.appendChild(d);
  });

  progress.style.width=((current+1)/dialogues.length*100)+"%";
  localStorage.setItem("shop_level",level);
  localStorage.setItem("shop_current",current);
}

function checkAnswer(ans){
  if(ans===dialogues[current].ar){
    successSound.play();
    monkey.src="assets/monkey/happy.png";
    msg.innerText="✔ صحيح";
    current++;
    setTimeout(loadQuestion,700);
  }else{
    failSound.play();
    monkey.src="assets/monkey/sad.png";
    msg.innerText="❌ خطأ";
  }
}

function resetGame(){
  localStorage.clear();
  level=1; current=0;
  loadQuestion();
}

function speak(){
  speechSynthesis.speak(new SpeechSynthesisUtterance(dialogues[current].fr));
}

loadQuestion();
</script>

</body>
</html>
