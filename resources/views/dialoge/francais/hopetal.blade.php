<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>تعلم الحوارات في الحب</title>
<style>
body{margin:0;padding:0;font-family:Cairo,sans-serif;background:#f2f2f2;}
.wrapper{display:flex;flex-direction:column;align-items:center;padding:20px;background:url('assets/images/hopetal.png') no-repeat center;background-size:cover;}
.level-card{width:90%;background:#000000cc;border-radius:20px;padding:10px;text-align:center;color:#00ffff;border:2px solid #ff0400ff;margin-bottom:15px;}
.progress-bar{width:100%;height:20px;background:#333;border-radius:8px;overflow:hidden;margin-bottom:10px;}
.progress-fill{height:100%;background:#bbff00ff;width:0%;transition:0.5s;}
.card{width:90%;background:#1c1c1c;padding:20px;border-radius:15px;border:2px solid #0008ffff;text-align:center;color:#fff;margin-bottom:15px;}
.listen-btn{margin-top:10px;background:#FFD54A;padding:10px 15px;border-radius:12px;font-weight:800;cursor:pointer;color:#000;display:inline-block;}
.options{width:100%;display:flex;flex-wrap:wrap;justify-content:space-between;margin-top:10px;}
.opt-btn{width:48%;padding:12px;margin-bottom:10px;border-radius:15px;text-align:center;background:#000;color:#fff;font-weight:800;border:2px solid #001affff;cursor:pointer;}
.msg{margin-top:10px;font-size:20px;font-weight:800;color:#ff4a4a;text-align:center;}
.monkey{width:100px;height:110px;margin-top:15px;}
.reset-btn{margin-top:10px;padding:10px 20px;border:none;background:#ff4081;color:#fff;font-weight:800;border-radius:12px;cursor:pointer;}
@media (max-width:768px){ 
  .wrapper{padding:10px;}
  .level-card{width:95%;padding:8px;font-size:14px;}
  .progress-bar{height:16px;}
  .card{width:95%;padding:15px;font-size:14px;}
  .listen-btn{padding:8px 10px;font-size:14px;}
  .opt-btn{width:100%;padding:10px;margin-bottom:8px;font-size:16px;}
  .monkey{width:80px;height:90px;}
  .msg{font-size:18px;}
}
@media (max-width:480px){ 
  .level-card{font-size:12px;}
  .card{font-size:12px;}
  .listen-btn{font-size:12px;padding:6px 8px;}
  .opt-btn{width:100%;font-size:14px;padding:8px;}
  .monkey{width:70px;height:80px;}
  .msg{font-size:16px;}
}
</style>
</head>
<body>
@extends('layouts.fr')

<div class="wrapper">
  <div class="level-card">
    المستوى: <span id="level">1</span> | السؤال: <span id="current">1</span> / <span id="total"></span>
  </div>

  <div class="progress-bar">
    <div class="progress-fill" id="progress"></div>
  </div>

  <div class="card">
    <div id="question" style="font-size:22px; font-weight:700;color:black"></div>
    <span class="listen-btn" onclick="speak()">🔊 اسمع النطق</span>
    <span class="listen-btn" onclick="stopAllSounds()">🔇 إيقاف الصوت</span>
  </div>

  <div class="options" id="options"></div>

  <img src="assets/monkey/neutral.png" id="monkey" class="monkey" />
  <div id="msg" class="msg"></div>
  <button class="reset-btn" onclick="resetGame()">🔄 إعادة اللعبة من البداية</button>
</div>

<audio id="successAudio" src="assets/audio/success.mp3" preload="auto"></audio>
<audio id="failAudio" src="assets/audio/fail.mp3" preload="auto"></audio>

<script>
// ============================
// 100 جملة بالفرنسية والعربية
// ============================
const dialogues = [
  { fr:"Bonjour !", ar:"مرحبا!" }, { fr:"Comment ça va ?", ar:"كيف حالك؟" }, { fr:"Je vais bien, merci.", ar:"أنا بخير، شكراً." },
  { fr:"Quel est ton nom ?", ar:"ما اسمك؟" }, { fr:"Je m'appelle Ahmed.", ar:"اسمي أحمد." }, { fr:"Enchanté de te rencontrer.", ar:"سعيد بلقائك." },
  { fr:"Où habites-tu ?", ar:"أين تسكن؟" }, { fr:"J'habite à Casablanca.", ar:"أسكن في الدار البيضاء." }, { fr:"Quel âge as-tu ?", ar:"كم عمرك؟" },
  { fr:"J'ai 16 ans.", ar:"عمري 16 سنة." }, { fr:"Quel est ton passe-temps ?", ar:"ما هوايتك؟" }, { fr:"J'aime le football.", ar:"أحب كرة القدم." },
  { fr:"As-tu des frères ?", ar:"هل لديك إخوة؟" }, { fr:"Oui, j'ai un frère.", ar:"نعم، لدي أخ." }, { fr:"Que fais-tu aujourd'hui ?", ar:"ماذا تفعل اليوم؟" },
  { fr:"Je vais à l'école.", ar:"أنا ذاهب إلى المدرسة." }, { fr:"Quel est ton plat préféré ?", ar:"ما هو طعامك المفضل؟" }, { fr:"J'adore les pizzas.", ar:"أحب البيتزا." },
  { fr:"Quelle heure est-il ?", ar:"كم الساعة؟" }, { fr:"Il est dix heures.", ar:"إنها الساعة العاشرة." }, { fr:"As-tu des animaux ?", ar:"هل لديك حيوانات؟" },
  { fr:"Oui, j'ai un chat.", ar:"نعم، لدي قط." }, { fr:"Quel est ton sport préféré ?", ar:"ما هو رياضتك المفضلة؟" }, { fr:"J'aime le basketball.", ar:"أحب كرة السلة." },
  { fr:"Où vas-tu demain ?", ar:"إلى أين ستذهب غداً؟" }, { fr:"Je vais au parc.", ar:"سأذهب إلى الحديقة." }, { fr:"Que lis-tu ?", ar:"ماذا تقرأ؟" },
  { fr:"Je lis un livre.", ar:"أقرأ كتاباً." }, { fr:"Quel film aimes-tu ?", ar:"ما هو فيلمك المفضل؟" }, { fr:"J'adore les dessins animés.", ar:"أحب الرسوم المتحركة." },
  { fr:"Où est la bibliothèque ?", ar:"أين المكتبة؟" }, { fr:"Elle est près de l'école.", ar:"إنها قرب المدرسة." }, { fr:"Que veux-tu manger ?", ar:"ماذا تريد أن تأكل؟" },
  { fr:"Je veux des pâtes.", ar:"أريد المعكرونة." }, { fr:"Quel est ton musicien préféré ?", ar:"من هو موسيقيك المفضل؟" }, { fr:"J'aime Mozart.", ar:"أحب موزارت." },
  { fr:"Comment s'appelle ton école ?", ar:"ما اسم مدرستك؟" }, { fr:"Elle s'appelle Lycée Hassan II.", ar:"اسمها ثانوية الحسن الثاني." }, { fr:"Que portes-tu aujourd'hui ?", ar:"ماذا ترتدي اليوم؟" },
  { fr:"Je porte un t-shirt bleu.", ar:"أرتدي قميص أزرق." }, { fr:"Quel est ton animal préféré ?", ar:"ما هو حيوانك المفضل؟" }, { fr:"J'adore les dauphins.", ar:"أحب الدلافين." },
  { fr:"Où vas-tu après l'école ?", ar:"إلى أين تذهب بعد المدرسة؟" }, { fr:"Je vais à la bibliothèque.", ar:"أذهب إلى المكتبة." }, { fr:"Quel est ton fruit préféré ?", ar:"ما هي فاكهتك المفضلة؟" },
  { fr:"J'aime les fraises.", ar:"أحب الفراولة." }, { fr:"Comment vas-tu au travail ?", ar:"كيف تذهب إلى العمل؟" }, { fr:"Je prends le bus.", ar:"أستقل الحافلة." },
  { fr:"Quel est ton chanteur préféré ?", ar:"من هو مغنيك المفضل؟" }, { fr:"J'aime Shakira.", ar:"أحب شاكيرا." }, { fr:"Que fais-tu le week-end ?", ar:"ماذا تفعل في عطلة نهاية الأسبوع؟" },
  { fr:"Je fais du sport.", ar:"أمارس الرياضة." }, { fr:"Quel est ton dessert préféré ?", ar:"ما هو حلوك المفضل؟" }, { fr:"J'adore le chocolat.", ar:"أحب الشوكولاتة." },
  { fr:"Où se trouve le cinéma ?", ar:"أين هو السينما؟" }, { fr:"Il est près du parc.", ar:"إنه قرب الحديقة." }, { fr:"Que bois-tu le matin ?", ar:"ماذا تشرب في الصباح؟" },
  { fr:"Je bois du lait.", ar:"أشرب الحليب." }, { fr:"Quel est ton jeu préféré ?", ar:"ما هي لعبتك المفضلة؟" }, { fr:"J'adore le football.", ar:"أحب كرة القدم." },
  { fr:"Où est la pharmacie ?", ar:"أين الصيدلية؟" }, { fr:"Elle est près du supermarché.", ar:"إنها قرب السوبرماركت." }, { fr:"Quel est ton hobby ?", ar:"ما هي هوايتك؟" },
  { fr:"J'aime peindre.", ar:"أحب الرسم." }, { fr:"Comment est le temps ?", ar:"كيف حال الطقس؟" }, { fr:"Il fait beau.", ar:"الجو جميل." },
  { fr:"Quel est ton légume préféré ?", ar:"ما هو خضارك المفضل؟" }, { fr:"J'aime les carottes.", ar:"أحب الجزر." }, { fr:"Où vas-tu en vacances ?", ar:"أين تذهب في العطلة؟" },
  { fr:"Je vais à la plage.", ar:"أذهب إلى الشاطئ." }, { fr:"Que fais-tu après l'école ?", ar:"ماذا تفعل بعد المدرسة؟" }, { fr:"Je fais mes devoirs.", ar:"أقوم بواجبي المدرسي." },
  { fr:"Quel est ton endroit préféré ?", ar:"ما هو مكانك المفضل؟" }, { fr:"J'adore le parc.", ar:"أحب الحديقة." }, { fr:"Comment voyages-tu ?", ar:"كيف تسافر؟" },
  { fr:"Je prends le train.", ar:"أستقل القطار." }, { fr:"Quel est ton numéro de téléphone ?", ar:"ما هو رقم هاتفك؟" }, { fr:"Mon numéro est 06 12 34 56 78.", ar:"رقمي هو 06 12 34 56 78." },
  { fr:"Que fais-tu le soir ?", ar:"ماذا تفعل في المساء؟" }, { fr:"Je regarde la télévision.", ar:"أشاهد التلفاز." }, { fr:"Quel est ton moyen de transport ?", ar:"ما هي وسيلة النقل الخاصة بك؟" }, 
  { fr:"Je prends le métro.", ar:"أستقل المترو." }, { fr:"Où est le restaurant ?", ar:"أين المطعم؟" }, { fr:"Il est à côté de la gare.", ar:"إنه بجانب المحطة." },
  { fr:"Que portes-tu en hiver ?", ar:"ماذا ترتدي في الشتاء؟" }, { fr:"Je porte un manteau.", ar:"أرتدي معطفاً." }, { fr:"Quel est ton rêve ?", ar:"ما هو حلمك؟" },
  { fr:"Je veux devenir médecin.", ar:"أريد أن أصبح طبيباً." }, { fr:"Où est la banque ?", ar:"أين البنك؟" }, { fr:"Elle est près du café.", ar:"إنها قرب المقهى." },
  { fr:"Comment te sens-tu ?", ar:"كيف تشعر؟" }, { fr:"Je me sens bien.", ar:"أشعر أنني بخير." }, { fr:"Quel est ton magasin préféré ?", ar:"ما هو متجرك المفضل؟" },
  { fr:"J'adore la librairie.", ar:"أحب المكتبة." }, { fr:"Où est la poste ?", ar:"أين مكتب البريد؟" }, { fr:"Elle est au centre-ville.", ar:"إنها في وسط المدينة." },
  { fr:"Que fais-tu demain ?", ar:"ماذا ستفعل غداً؟" }, { fr:"Je vais à la piscine.", ar:"سأذهب إلى المسبح." }, { fr:"Quel est ton cours préféré ?", ar:"ما هو درسك المفضل؟" },
  { fr:"J'aime les mathématiques.", ar:"أحب الرياضيات." }, { fr:"Où est l'hôpital ?", ar:"أين المستشفى؟" }, { fr:"Il est près de la gare.", ar:"إنه قرب المحطة." },
  { fr:"Que fais-tu le matin ?", ar:"ماذا تفعل في الصباح؟" }, { fr:"Je prends mon petit-déjeuner.", ar:"أفطر." }, { fr:"Quel est ton café préféré ?", ar:"ما هو مقهاك المفضل؟" },
  { fr:"J'aime le café au lait.", ar:"أحب قهوة بالحليب." }, { fr:"Où est le cinéma ?", ar:"أين السينما؟" }, { fr:"Il est près du parc.", ar:"إنه قرب الحديقة." }, 
  { fr:"Comment t'appelles-tu ?", ar:"ما اسمك؟" }, { fr:"Je m'appelle Sara.", ar:"اسمي سارة." }, { fr:"Quel est ton plat favori ?", ar:"ما هو طعامك المفضل؟" },
  { fr:"J'adore les crêpes.", ar:"أحب الكريب." }
];

// =====================================
// الحالة الحالية + حفظها في localStorage
// =====================================
let level = parseInt(localStorage.getItem('level')) || 1;
let current = parseInt(localStorage.getItem('current')) || 0;
let currentSound = null;

document.getElementById('total').innerText = dialogues.length;

function loadQuestion() {
  const q = dialogues[current];
  document.getElementById('question').innerText = q.fr;
  document.getElementById('level').innerText = level;
  document.getElementById('current').innerText = current+1;

  const opts = [ q.ar ];
  while(opts.length<4){
    let r = dialogues[Math.floor(Math.random()*dialogues.length)];
    if(!opts.includes(r.ar)) opts.push(r.ar);
  }
  opts.sort(()=>Math.random()-0.5);

  const optionsDiv = document.getElementById('options');
  optionsDiv.innerHTML = '';
  opts.forEach(opt=>{
    const btn = document.createElement('div');
    btn.className = 'opt-btn';
    btn.innerText = opt;
    btn.onclick = ()=>checkAnswer(opt);
    optionsDiv.appendChild(btn);
  });

  const progress = ((current+1)/dialogues.length)*100;
  document.getElementById('progress').style.width = progress+'%';
  document.getElementById('monkey').src = "assets/monkey/neutral.png";
  document.getElementById('msg').innerText = '';

  localStorage.setItem('level', level);
  localStorage.setItem('current', current);
}

function checkAnswer(ans) {
  const correct = dialogues[current].ar;
  if(ans===correct){
    playSound("assets/audio/success.mp3");
    document.getElementById('monkey').src = "assets/monkey/happy.png";
    document.getElementById('msg').innerText = "✔ صحيح!";
    setTimeout(nextQuestion,900);
  } else {
    playSound("assets/audio/fail.mp3");
    document.getElementById('monkey').src = "assets/monkey/sad.png";
    document.getElementById('msg').innerText = "❌ خطأ حاول مرة أخرى";
  }
}

function nextQuestion() {
  current++;
  if(current >= dialogues.length){
    current=0;
    level = (level===1)?2:1;
    alert('🎉 انتهى التمرين! المستوى تم تغييره.');
  }
  stopAllSounds();
  loadQuestion();
}

function playSound(src){
  stopAllSounds();
  currentSound = new Audio(src);
  currentSound.play();
}

function stopAllSounds(){
  if(currentSound){
    currentSound.pause();
    currentSound=null;
  }
  if(window.speechSynthesis) window.speechSynthesis.cancel();
}

function speak(){
  const q = dialogues[current];
  if(window.speechSynthesis) window.speechSynthesis.speak(new SpeechSynthesisUtterance(q.fr));
}

function resetGame() {
    level = 1;
    current = 0;
    stopAllSounds();
    localStorage.removeItem('level');
    localStorage.removeItem('current');
    loadQuestion();
}

// تحميل السؤال الأول عند فتح الصفحة
loadQuestion();
</script>

</body>
</html>
