<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: sans-serif;
            overflow: hidden;
        }

        /* 🌌 PARTICLES */
        #particles {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        /* 🌙 NAVBAR */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 20;
            display: flex;
            justify-content: space-between;
            padding: 20px 40px;
            backdrop-filter: blur(12px);
            background: rgba(255,255,255,0.2);
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
            color: #7c3aed;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-actions {
            display: flex;
            gap: 10px;
        }

        .dark-toggle, .back-btn {
            padding: 8px 14px;
            border-radius: 10px;
            background: rgba(0,0,0,0.7);
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        /* 🌟 MAIN */
        .main-container {
            position: relative;
            z-index: 10;
            min-height: 100vh;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            padding-top: 100px;
        }

        /* 🎯 TITLE */
        .title {
            font-size: 42px;
            font-weight: bold;
            text-align: center;
            background: linear-gradient(to right, #7c3aed, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            text-align: center;
            margin-top: 10px;
            color: #666;
        }

        /* 💎 CARDS STACK */
        .card-container {
            display: flex;
            flex-direction: column; /* 🔥 IMPORTANT CHANGE */
            gap: 25px;
            margin-top: 30px;
        }

        /* 💎 CARD */
        .card {
            width: 350px;
            padding: 30px;
            border-radius: 20px;
            backdrop-filter: blur(15px);
            background: rgba(255,255,255,0.7);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            animation: fadeUp 0.8s ease;
        }

        input {
            width: 100%;
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 10px;
            border: none;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            color: white;
            border: none;
            cursor: pointer;
        }

        .purple { background: linear-gradient(135deg,#7c3aed,#6366f1); }
        .pink { background: linear-gradient(135deg,#9333ea,#ec4899); }

        .success {
            background: #22c55e;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            color: white;
        }

        @keyframes fadeUp {
            from {opacity:0; transform:translateY(30px);}
            to {opacity:1; transform:translateY(0);}
        }

    </style>
</head>
<body>

<div id="app">

    <!-- 🌌 Particles -->
    <canvas id="particles"></canvas>

    <!-- 🌙 Navbar -->
    <nav class="navbar">
        <h1 class="logo">
            <img src="/images/logo.png" width="30">
            Job Portal
        </h1>

        <div class="nav-actions">
            <button onclick="toggleDarkMode()" class="dark-toggle">🌙</button>
            <a href="{{ url('/') }}" class="back-btn">← Home</a>
        </div>
    </nav>

    <!-- 🌟 Main -->
    <div class="main-container">

        <div>
            <h1 class="title">Welcome to Job Portal</h1>
            <p class="subtitle">Login as User or Admin to continue</p>
        </div>

        <div class="card-container">

            <!-- User -->
            <section class="card">
                <h2>User Login 👤</h2>

                @if(session('user_success'))
                    <div class="success">{{ session('user_success') }}</div>
                @endif

                <form method="POST" action="{{ route('user.login') }}">
                    @csrf
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button class="btn purple">Login</button>
                </form>
            </section>

            <!-- Admin -->
            <section class="card">
                <h2>Admin Login 🛡️</h2>

                @if(session('admin_success'))
                    <div class="success">{{ session('admin_success') }}</div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <input type="email" name="email" placeholder="Admin Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button class="btn pink">Admin Login</button>
                </form>
            </section>

        </div>
    </div>
</div>

<script>
function toggleDarkMode() {
    document.body.classList.toggle("dark");
}

// particles
const canvas = document.getElementById("particles");
const ctx = canvas.getContext("2d");

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let particles = [];

for (let i = 0; i < 80; i++) {
    particles.push({
        x: Math.random()*canvas.width,
        y: Math.random()*canvas.height,
        r: 2,
        dx: Math.random()-0.5,
        dy: Math.random()-0.5
    });
}

function connect(){
    for(let a=0;a<particles.length;a++){
        for(let b=a;b<particles.length;b++){
            let dx = particles[a].x - particles[b].x;
            let dy = particles[a].y - particles[b].y;
            let dist = dx*dx + dy*dy;

            if(dist < 10000){
                ctx.strokeStyle="rgba(124,58,237,0.2)";
                ctx.beginPath();
                ctx.moveTo(particles[a].x, particles[a].y);
                ctx.lineTo(particles[b].x, particles[b].y);
                ctx.stroke();
            }
        }
    }
}

function animate(){
    ctx.clearRect(0,0,canvas.width,canvas.height);

    particles.forEach(p=>{
        ctx.beginPath();
        ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
        ctx.fillStyle="#7c3aed";
        ctx.fill();

        p.x+=p.dx;
        p.y+=p.dy;

        if(p.x<0||p.x>canvas.width) p.dx*=-1;
        if(p.y<0||p.y>canvas.height) p.dy*=-1;
    });

    connect();
    requestAnimationFrame(animate);
}

animate();
</script>

</body>
</html>