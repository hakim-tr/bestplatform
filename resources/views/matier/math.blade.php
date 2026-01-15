<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لعبة الرياضيات</title>
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, sans-serif;
            background: linear-gradient(135deg, #0508ff, #001a7a);
            color: white;
            display: flex;
            flex-direction: column; /* باش اللعبة فوق والقائمة تحت */
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* ===== اللعبة ===== */
        .game {
            width: 600px;
            max-width: 95%;
            background: #0e0e0e;
            padding: 30px;
            border-radius: 25px;
            box-shadow: 0 0 35px rgba(0,255,144,.5);
            text-align: center;
            margin-bottom: 20px; /* مسافة مع القائمة */
        }

        h1 { color: #00ff90; margin-bottom: 10px; font-size: 34px; }
        .level, .score { font-size: 20px; margin-bottom: 8px; }
        .progress { width: 100%; height: 14px; background: #333; border-radius: 10px; overflow: hidden; margin: 20px 0; }
        .progress-bar { height: 100%; width: 0%; background: linear-gradient(90deg, #00ff90, #00ffaa); transition: .4s; }
        .operation { background: #1c1c1c; border: 3px solid #00ff90; border-radius: 18px; padding: 30px; font-size: 56px; font-weight: 900; margin: 25px 0; }
        .options { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; margin-top: 25px; }
        .option { padding: 25px 0; background: #222; border-radius: 18px; font-size: 30px; font-weight: 900; color: #00ff90; cursor: pointer; transition: .2s ease; border: 2px solid transparent; }
        .option:hover { background: #00ff90; color: #000; transform: scale(1.05); border-color: #00ff90; }
        .monkey { width: 120px; margin: 25px auto 10px; }
        .msg { font-size: 26px; font-weight: 900; margin-top: 15px; }

        /* ===== القائمة تحت ===== */
        .menu {
            display: flex;
            justify-content: center;
            gap: 15px;
            background: linear-gradient(135deg, #3f51b5, #5c6bc0);
            padding: 14px;
            flex-wrap: wrap;
            width: 100%;
            max-width: 800px;
            border-radius: 20px;
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

        /* MOBILE */
        @media (max-width: 600px){
            .game { padding: 20px; }
            h1 { font-size: 26px; }
            .operation { font-size: 40px; padding: 20px; }
            .option { font-size: 22px; padding: 18px 0; }
            .monkey { width: 90px; }
            .msg { font-size: 20px; }
            .menu { flex-direction: column; gap: 8px; }
        }
    </style>
</head>
<body>

<div class="game">
    <h1>لعبة الرياضيات 🔢🧠</h1>
    <div class="level">المستوى: <span id="level">1</span></div>
    <div class="score"><span id="score">0</span> / <span id="total">15</span></div>
    <div class="progress"><div class="progress-bar" id="progress"></div></div>
    <div class="operation" id="question">1 + 1</div>
    <div class="options" id="options"></div>
    <img id="monkey" class="monkey" src="/assets/monkey/neutral.png">
    <div class="msg" id="msg"></div>
    <audio id="successSound" src="/assets/audio/success.mp3" preload="auto"></audio>
    <audio id="failSound" src="/assets/audio/fail.mp3" preload="auto"></audio>
</div>

<!-- القائمة تحت -->
<div class="menu">
    <a href="/" class="{{ request()->routeIs('animale') ? 'active' : '' }}">الراسية</a>
    <a href="{{ route('animale') }}" class="{{ request()->routeIs('animale') ? 'active' : '' }}">🐾🐒🦍 الحيوانات</a>
        <a href="{{ route('math') }}">📐📏 الرياضيات </a>
    <a href="{{ route('fruits') }}" class="{{ request()->routeIs('fruits') ? 'active' : '' }}">🍎🍍🍓 الفواكه</a>
    <a href="{{ route('color') }}" class="{{ request()->routeIs('colors') ? 'active' : '' }}">🎨 الألوان</a>
    <a href="{{ route('transport') }}" class="{{ request()->routeIs('transport') ? 'active' : '' }}">🚒🚗🚕 وسائل النقل</a>

</div>

<script>
    const successAudio = document.getElementById("successSound");
    const failAudio = document.getElementById("failSound");

    function playSound(audio) {
        audio.currentTime = 0;
        audio.play();
    }
</script>

<script>
    let level = 1;
    let score = 0;
    let current = 0;
    let questions = [];

    const qEl = document.getElementById("question");
    const optEl = document.getElementById("options");
    const msgEl = document.getElementById("msg");
    const scoreEl = document.getElementById("score");
    const levelEl = document.getElementById("level");
    const progressEl = document.getElementById("progress");
    const monkeyEl = document.getElementById("monkey");

    function rand(min, max){ return Math.floor(Math.random()*(max-min+1))+min; }

    function generateQuestions() {
        questions = [];
        for(let i=0;i<15;i++){
            const ops=["+","-","×"];
            const op=ops[Math.floor(Math.random()*ops.length)];
            let min = level===1?1:10;
            let max = level===1?10:50;
            let a=rand(min,max);
            let b=rand(min,max);
            if(op=="-" && b>a) [a,b]=[b,a];
            let answer = op=="+"? a+b : op=="-"? a-b : a*b;
            questions.push({q:`${a} ${op} ${b}`, answer});
        }
        current=0; score=0;
        updateUI();
    }

    function generateOptions(ans){
        let arr=[ans, ans+rand(1,10), ans-rand(1,10), ans+rand(5,15)];
        return arr.sort(()=>Math.random()-0.5);
    }

    function updateUI(){
        const q=questions[current];
        qEl.textContent=q.q;
        const opts=generateOptions(q.answer);
        optEl.innerHTML="";
        opts.forEach(o=>{
            const btn=document.createElement("div");
            btn.className="option";
            btn.textContent=o;
            btn.onclick=()=>checkAnswer(o);
            optEl.appendChild(btn);
        });
        scoreEl.textContent=score;
        levelEl.textContent=level;
        progressEl.style.width=(score/questions.length)*100+"%";
        msgEl.textContent="";
        monkeyEl.src="/assets/monkey/neutral.png";
    }

    function checkAnswer(ans){
        const q=questions[current];
        if(ans===q.answer){
            playSound(successAudio);
            score++;
            msgEl.textContent="✔ صحيح!";
            monkeyEl.src="/assets/monkey/happy.png";
            current++;
            setTimeout(next,700);
        }else{
            playSound(failAudio);
            msgEl.textContent="❌ خطأ حاول مرة أخرى";
            monkeyEl.src="/assets/monkey/sad.png";
        }
    }

    function next(){
        if(current<questions.length){
            updateUI();
        }else{
            level = level===1?2:1;
            generateQuestions();
        }
    }

    generateQuestions();
</script>

</body>
</html>
