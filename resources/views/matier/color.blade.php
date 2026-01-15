<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>تعلم الفواكه للأطفال</title>

<style>
body{
  font-family:"Cairo", sans-serif;
  background:#e6ffd7;
  margin:0;
  padding:20px;
  text-align:center;
}

h1{color:#83ff4a; margin-bottom:10px;}
.level{font-weight:700; color:#c11313; margin-bottom:10px;}
.score{font-weight:700; margin-bottom:12px; color:#fd0000;}

.progress{
  width:100%;
  height:14px;
  background:#333;
  border-radius:8px;
  overflow:hidden;
  margin:15px 0;
}
.progress span{
  display:block;
  height:100%;
  width:0%;
  background:#0045f5;
  transition:.4s;
}

img{
  width:200px;
  height:200px;
  object-fit:contain;
  border:3px solid #0727f3;
  border-radius:20px;
  background:#222;
}

.options{
  display:flex;
  flex-wrap:wrap;
  justify-content:space-between;
  margin-top:20px;
}
.options button{
  width:48%;
  padding:14px;
  margin-bottom:10px;
  font-size:18px;
  font-weight:bold;
  border:none;
  border-radius:15px;
  background:#333;
  color:#eeedf4;
  cursor:pointer;
}

.message{
  font-size:20px;
  margin-top:15px;
  font-weight:bold;
  color:#11ff00;
  text-shadow: 1px 1px 3px rgba(0,0,0,0.8);
}

input[type="text"]{
  margin-top:10px;
  padding:10px;
  font-size:18px;
  border-radius:15px;
  border:2px solid #FFD54A;
  background:rgba(0,0,0,0.6);
  color:#fff;
  width:60%;
  text-align:center;
}

.confetti-piece{
  position:absolute;
  width:8px; height:8px;
  background:yellow;
  animation:fall 2s linear forwards;
}
@keyframes fall{
  0%{transform:translateY(0) rotate(0deg);}
  100%{transform:translateY(400px) rotate(360deg);}
}

#monkeyImg{
  width:100px;
  height:100px;
  margin-top:20px;
}
</style>
</head>
<body>
@extends('layouts.app')
<h1 >تعلم  الألوان بطريقة ممتعة 🎨🟥🟦</h1>
<div class="level" id="level">المستوى: 1</div>
<div class="score"><span id="score">0</span> / <span id="total">0</span></div>
<div class="progress"><span id="bar"></span></div>

<img id="fruitImg" src="" alt="fruit">
<br>
<button onclick="speak()">🔊 استمع</button>

<div class="options" id="options"></div>
<div id="inputDiv"></div>

<img id="monkeyImg" src="image/monkey/neutral.png" alt="monkey">
<div class="message" id="msg"></div>

<script>
// colors
// colors
const colors = [
  { name: "rouge",  img: "image/colors/rouge.png" },
  { name: "gris",   img: "image/colors/gris.png" },
  { name: "bleu",   img: "image/colors/bleu.png" },
  { name: "jaune",  img: "image/colors/jaune.png" },
  { name: "vert",   img: "image/colors/vert.png" },
  { name: "orange", img: "image/colors/orange.png" },
  { name: "violet", img: "image/colors/violet.png" },
  { name: "noir",   img: "image/colors/noir.png" },
  { name: "blanc",  img: "image/colors/blanc.png" },
  { name: "marron", img: "image/colors/marron.png" },
  { name: "rose",   img: "image/colors/rose.png" },
  { name: "cyan",   img: "image/colors/cyan.png" },
];


let index=0, score=0, level=1;
let textOptions=[];

const fruitImg = document.getElementById("fruitImg");
const optionsDiv = document.getElementById("options");
const msg = document.getElementById("msg");
const scoreEl = document.getElementById("score");
const totalEl = document.getElementById("total");
const bar = document.getElementById("bar");
const levelEl = document.getElementById("level");
const inputDiv = document.getElementById("inputDiv");
const monkeyImg = document.getElementById("monkeyImg");

totalEl.innerText = colors.length;

function shuffle(arr){ return arr.sort(()=>Math.random()-0.5); }

function load(){
  const q = colors[index];
  fruitImg.src = q.img;
  msg.innerText = "";
  optionsDiv.innerHTML = "";
  inputDiv.innerHTML = "";
  monkeyImg.src = "image/monkey/neutral.png"; // reset monkey

  if(level===1){
    let answers = [q.name];
    while(answers.length<4){
      let r = colors[Math.floor(Math.random()*colors.length)].name;
      if(!answers.includes(r)) answers.push(r);
    }
    answers = shuffle(answers);
    answers.forEach(a=>{
      const btn = document.createElement("button");
      btn.innerText = a;
      btn.onclick = ()=>check(a);
      optionsDiv.appendChild(btn);
    });
  }

  if(level===2){
    const input = document.createElement("input");
    input.type = "text";
    input.id = "textInput";
    input.placeholder = "اكتب اسم الفاكهة";
    inputDiv.appendChild(input);

    const validerBtn = document.createElement("button");
    validerBtn.innerText = "✔ تحقق";
    validerBtn.style.marginTop = "10px";
    validerBtn.onclick = ()=>check(input.value);
    inputDiv.appendChild(validerBtn);
  }

  updateBar();
}

// Sounds
const sounds = {
  success: new Audio("assets/audio/success.mp3"),
  fail: new Audio("assets/audio/fail.mp3")
};

function check(ans){
  const q = colors[index];
  if(ans.toLowerCase() === q.name.toLowerCase()){
    score++;
    msg.innerText = "✔ صحيح!";
    monkeyImg.src = "image/monkey/happy.png"; // happy monkey
    sounds.success.currentTime = 0;
    sounds.success.play();
    setTimeout(next,1000);
  } else {
    msg.innerText = "❌ خطأ! حاول مرة أخرى";
    monkeyImg.src = "image/monkey/sad.png"; // sad monkey
    sounds.fail.currentTime = 0;
    sounds.fail.play();
  }
  scoreEl.innerText = score;
}

function next(){
  if(index < colors.length-1){
    index++;
    load();
  } else {
    msg.innerText="🎉 أحسنت! انتهى التمرين";
    setTimeout(resetGame,2000);
  }
}

function resetGame(){
  score=0;
  index=0;
  level=(level===1)?2:1;
  scoreEl.innerText=score;
  levelEl.innerText="المستوى: "+level;
  bar.style.width="0%";
  msg.innerText="";
  load();
  showConfetti();
}

function updateBar(){
  bar.style.width = ((index/colors.length)*100)+"%";
}

function speak(){
  const u = new SpeechSynthesisUtterance(colors[index].name);
  u.lang = "fr-FR";
  speechSynthesis.speak(u);
}

function showConfetti(){
  for(let i=0;i<50;i++){
    const c = document.createElement("div");
    c.className = "confetti-piece";
    c.style.left = Math.random()*window.innerWidth+"px";
    c.style.backgroundColor = `hsl(${Math.random()*360},100%,50%)`;
    document.body.appendChild(c);
    setTimeout(()=>c.remove(),2000);
  }
}

load();
</script>
</body>
</html>
