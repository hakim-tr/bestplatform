<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>لعبة حوارات القهوة ☕</title>

<style>
body{
  margin:0;padding:0;font-family:Cairo,sans-serif;
  background:#f3e5ab;
  display:flex;justify-content:center;align-items:center;
  min-height:100vh;
}
.wrapper{
  background:#ffffff;
  padding:20px;
  width:95%;max-width:650px;
  border-radius:20px;
  box-shadow:0 0 20px rgba(0,0,0,.2);
  text-align:center;
}
.level-card{
  background:#795548;
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
  background:linear-gradient(90deg,#6f4e37,#d7b899);
  transition:.4s;
}
.card{
  background:#d7b899;
  padding:15px;
  border-radius:15px;
  font-size:20px;
  font-weight:700;
}
.listen-btn{
  display:inline-block;
  margin-top:10px;
  background:#6f4e37;
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
  background:#bc8f8f;
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

  <img src="assets/monkey/neutral.png" id="monkey" class="monkey">

  <div class="card">
    <div id="question"></div>
    <div class="listen-btn" onclick="speak()">🔊 اسمع</div>
  </div>

  <button class="reset-btn" onclick="resetGame()">🔄 إعادة من البداية</button>

  <div class="options" id="options"></div>
  <div class="msg" id="msg"></div>

</div>

<audio id="successSound" src="assets/audio/success.mp3"></audio>
<audio id="failSound" src="assets/audio/fail.mp3"></audio>

<script>
// =====================
// Café dialogues
// =====================
const dialogues = [
{fr:"Bonjour, je voudrais un café.", ar:"مرحبا، أريد قهوة."},
{fr:"Un café s’il vous plaît.", ar:"قهوة من فضلك."},
{fr:"Je veux un café noir.", ar:"أريد قهوة سوداء."},
{fr:"Je veux un café au lait.", ar:"أريد قهوة بالحليب."},
{fr:"Un espresso, s’il vous plaît.", ar:"إسبريسو من فضلك."},
{fr:"Un cappuccino, s’il vous plaît.", ar:"كابتشينو من فضلك."},
{fr:"Un café crème.", ar:"قهوة بالكريمة."},
{fr:"Je prends un latte.", ar:"سآخذ لاتيه."},
{fr:"Un café serré.", ar:"قهوة مركزة."},
{fr:"Un café allongé.", ar:"قهوة خفيفة."},
{fr:"Avec sucre, s’il vous plaît.", ar:"مع سكر من فضلك."},
{fr:"Sans sucre, merci.", ar:"بدون سكر شكراً."},
{fr:"Avec beaucoup de sucre.", ar:"مع الكثير من السكر."},
{fr:"Avec un peu de lait.", ar:"مع قليل من الحليب."},
{fr:"Je préfère sans lait.", ar:"أفضل بدون حليب."},
{fr:"C’est chaud ?", ar:"هل هو ساخن؟"},
{fr:"C’est trop chaud.", ar:"ساخن جداً."},
{fr:"C’est parfait.", ar:"مثالي."},
{fr:"Je veux un café froid.", ar:"أريد قهوة باردة."},
{fr:"Un café glacé.", ar:"قهوة مثلجة."},
// ... أكمل حتى 100 جملة بنفس الأسلوب
];

// =====================
// State
// =====================
let level = parseInt(localStorage.getItem("cafe_level")) || 1;
let current = parseInt(localStorage.getItem("cafe_current")) || 0;

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

// =====================
// Load Question
// =====================
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
  localStorage.setItem("cafe_level",level);
  localStorage.setItem("cafe_current",current);
}

// =====================
// Check Answer
// =====================
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

// =====================
// Reset Game
// =====================
function resetGame(){
  localStorage.clear();
  level=1; current=0;
  loadQuestion();
}

// =====================
// Speak
// =====================
function speak(){
  speechSynthesis.speak(new SpeechSynthesisUtterance(dialogues[current].fr));
}

loadQuestion();
</script>

</body>
</html>
