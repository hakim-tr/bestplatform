<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>لعبة حوارات الحب ❤️</title>
<style>
body{margin:0;padding:0;font-family:Cairo,sans-serif;background:#ffe6f0;display:flex;justify-content:center;align-items:center;min-height:100vh;}
.wrapper{display:flex;flex-direction:column;align-items:center;padding:20px;background:#fff0f8;border-radius:20px;width:95%;max-width:600px;box-shadow:0 0 20px rgba(255,0,128,0.5);}
.level-card{width:100%;background:#ffb6c1cc;border-radius:15px;padding:10px;text-align:center;color:#fff;margin-bottom:10px;font-weight:800;}
.progress-bar{width:100%;height:16px;background:#ccc;border-radius:8px;overflow:hidden;margin-bottom:15px;}
.progress-fill{height:100%;background:linear-gradient(90deg,#ff69b4,#ff1493);width:0%;transition:0.5s;}
.card{width:100%;background:#ffe4e1;padding:15px;border-radius:15px;text-align:center;font-weight:700;margin-bottom:15px;}
.listen-btn{margin-top:10px;background:#ff69b4;padding:8px 12px;border-radius:12px;font-weight:800;cursor:pointer;color:#fff;display:inline-block;}
.options{width:100%;display:flex;flex-wrap:wrap;justify-content:space-between;margin-top:10px;}
.opt-btn{width:48%;padding:12px;margin-bottom:10px;border-radius:12px;text-align:center;background:#ffb6c1;color:#fff;font-weight:800;border:2px solid #ff69b4;cursor:pointer;transition:0.2s;}
.opt-btn:hover{transform:scale(1.05);}
.msg{margin-top:10px;font-size:18px;font-weight:800;color:#ff1493;text-align:center;}
.monkey{width:100px;height:100px;margin-top:15px;}
@media (max-width:480px){.opt-btn{width:100%;}}
</style>
</head>
<body>
  @extends('layouts.fr')

<div class="wrapper">
  <div class="level-card">المستوى: <span id="level">1</span> | سؤال: <span id="current">1</span> / <span id="total"></span></div>
  <div class="progress-bar"><div class="progress-fill" id="progress"></div></div>
  <div class="card">
    <div id="question">Bonjour mon amour !</div>
    <span class="listen-btn" onclick="speak()">🔊 اسمع النطق</span>
  </div>
    <button class="reset-btn" onclick="resetGame()">🔄 إعادة اللعبة من البداية</button>

  <div class="options" id="options"></div>
  <img src="assets/monkey/neutral.png" id="monkey" class="monkey"/>
  <div id="msg" class="msg"></div>
</div>

<script>
// جمل حب بالفرنسية + الترجمة العربية

const dialogues = [
{fr:"Bonjour mon amour !", ar:"صباح الخير حبيبي!"},
{fr:"Je t'aime beaucoup.", ar:"أحبك كثيراً."},
{fr:"Tu me manques.", ar:"أشتاق إليك."},
{fr:"Je pense à toi chaque jour.", ar:"أفكر فيك كل يوم."},
{fr:"Tu es très spécial pour moi.", ar:"أنت مميز جداً بالنسبة لي."},
{fr:"Je ne peux pas t'oublier.", ar:"لا أستطيع نسيانك."},
{fr:"Tu es dans mon cœur.", ar:"أنت في قلبي."},
{fr:"J'aime ton sourire.", ar:"أحب ابتسامتك."},
{fr:"Tu rends ma vie plus belle.", ar:"أنت تجعل حياتي أجمل."},
{fr:"Je suis heureux avec toi.", ar:"أنا سعيد معك."},

{fr:"Tu es mon bonheur.", ar:"أنت سعادتي."},
{fr:"Je veux rester avec toi.", ar:"أريد البقاء معك."},
{fr:"Tu es la personne que j'aime.", ar:"أنت الشخص الذي أحبه."},
{fr:"Je rêve de toi.", ar:"أحلم بك."},
{fr:"Tu es mon amour.", ar:"أنت حبي."},
{fr:"Je t'adore.", ar:"أعشقك."},
{fr:"Tu es très gentil.", ar:"أنت لطيف جداً."},
{fr:"Tu es importante pour moi.", ar:"أنت مهمة بالنسبة لي."},
{fr:"Je tiens à toi.", ar:"أنا مهتم بك."},
{fr:"Tu fais battre mon cœur.", ar:"أنت تجعل قلبي ينبض."},

{fr:"Je veux te voir.", ar:"أريد رؤيتك."},
{fr:"Tu es toujours dans mes pensées.", ar:"أنت دائماً في تفكيري."},
{fr:"Je me sens bien avec toi.", ar:"أشعر بالراحة معك."},
{fr:"Tu es mon rêve.", ar:"أنت حلمي."},
{fr:"Je suis amoureux de toi.", ar:"أنا واقع في حبك."},
{fr:"Tu es incroyable.", ar:"أنت رائع."},
{fr:"Je te fais confiance.", ar:"أنا أثق بك."},
{fr:"Tu es mon soleil.", ar:"أنت شمسي."},
{fr:"Je veux te protéger.", ar:"أريد حمايتك."},
{fr:"Tu comptes beaucoup pour moi.", ar:"أنت مهم جداً بالنسبة لي."},

{fr:"Je suis content de te connaître.", ar:"سعيد لأنني أعرفك."},
{fr:"Tu es adorable.", ar:"أنت لطيف جداً."},
{fr:"Je pense à toi le matin.", ar:"أفكر فيك صباحاً."},
{fr:"Tu es mon choix.", ar:"أنت اختياري."},
{fr:"Je veux partager ma vie avec toi.", ar:"أريد مشاركة حياتي معك."},
{fr:"Tu es mon trésor.", ar:"أنت كنزي."},
{fr:"Je me sens en sécurité avec toi.", ar:"أشعر بالأمان معك."},
{fr:"Tu es mon espoir.", ar:"أنت أملي."},
{fr:"Je te respecte beaucoup.", ar:"أحترمك كثيراً."},
{fr:"Tu es quelqu’un de bien.", ar:"أنت شخص طيب."},

{fr:"Je suis fier de toi.", ar:"أنا فخور بك."},
{fr:"Tu es unique.", ar:"أنت فريد من نوعك."},
{fr:"Je veux ton bonheur.", ar:"أريد سعادتك."},
{fr:"Tu es mon avenir.", ar:"أنت مستقبلي."},
{fr:"Je t’apprécie vraiment.", ar:"أقدّرك حقاً."},
{fr:"Tu es toujours avec moi.", ar:"أنت دائماً معي."},
{fr:"Je t’aime de tout mon cœur.", ar:"أحبك من كل قلبي."},
{fr:"Tu es ma joie.", ar:"أنت فرحتي."},
{fr:"Je me sens chanceux avec toi.", ar:"أشعر أنني محظوظ معك."},
{fr:"Tu es la personne que je veux.", ar:"أنت الشخص الذي أريده."}
];



let level = parseInt(localStorage.getItem('level')) || 1;
let current = parseInt(localStorage.getItem('current')) || 0;
let currentSound = null;

document.getElementById('total').innerText = dialogues.length;

function loadQuestion(){
  const q = dialogues[current];
  document.getElementById('question').innerText = q.fr;
  document.getElementById('level').innerText = level;
  document.getElementById('current').innerText = current+1;

  const opts = [q.ar];
  while(opts.length<4){
    let r=dialogues[Math.floor(Math.random()*dialogues.length)];
    if(!opts.includes(r.ar)) opts.push(r.ar);
  }
  opts.sort(()=>Math.random()-0.5);

  const optionsDiv=document.getElementById('options');
  optionsDiv.innerHTML='';
  opts.forEach(opt=>{
    const btn=document.createElement('div');
    btn.className='opt-btn';
    btn.innerText=opt;
    btn.onclick=()=>checkAnswer(opt);
    optionsDiv.appendChild(btn);
  });

  document.getElementById('progress').style.width=((current+1)/dialogues.length*100)+'%';
  document.getElementById('monkey').src="assets/monkey/neutral.png";
  document.getElementById('msg').innerText='';

  localStorage.setItem('level',level);
  localStorage.setItem('current',current);
}

function checkAnswer(ans){
  const correct=dialogues[current].ar;
  if(ans===correct){
    playSound("assets/audio/success.mp3");
    document.getElementById('monkey').src="assets/monkey/happy.png";
    document.getElementById('msg').innerText="✔ صحيح!";
    setTimeout(nextQuestion,900);
  } else{
    playSound("assets/audio/fail.mp3");
    document.getElementById('monkey').src="assets/monkey/sad.png";
    document.getElementById('msg').innerText="❌ خطأ حاول مرة أخرى";
  }
}

function nextQuestion(){
  current++;
  if(current>=dialogues.length){
    current=0;
    level=(level===1)?2:1;
    alert('🎉 انتهى التمرين! المستوى تم تغييره.');
  }
  stopAllSounds();
  loadQuestion();
}

function playSound(src){
  stopAllSounds();
  currentSound=new Audio(src);
  currentSound.play();
}

function stopAllSounds(){
  if(currentSound){currentSound.pause();currentSound=null;}
  if(window.speechSynthesis) window.speechSynthesis.cancel();
}

function speak(){
  const q=dialogues[current];
  if(window.speechSynthesis) window.speechSynthesis.speak(new SpeechSynthesisUtterance(q.fr));
}

function resetGame(){
  level=1;
  current=0;
  stopAllSounds();
  localStorage.removeItem('level');
  localStorage.removeItem('current');
  loadQuestion();
}

loadQuestion();
</script>
</body>
</html>
