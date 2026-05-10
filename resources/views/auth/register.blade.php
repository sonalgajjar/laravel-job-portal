<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- 🔥 Reset -->
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
    </style>

</head>
<body>

<div class="wrapper">

    <!-- 🌈 Gradient Background -->
    <div class="bg"></div>

    <!-- 🌌 Particles -->
    <canvas id="particles"></canvas>

    <!-- 🔙 Back Button -->
    <a href="{{ url('/') }}" class="back-btn">← Back to Home</a>

    <!-- 💎 CENTER CONTAINER -->
    <div class="center-box">

        <!-- 💎 Register Card -->
        <div class="card">

            <h2 class="title">Create Account ✨</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="input-group">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                    @error('name') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                    @error('email') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                    @error('password') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" required>
                </div>

                <div class="actions">
                    <a href="{{ route('login') }}">Already registered?</a>
                    <button type="submit" class="btn">Register</button>
                </div>

            </form>
        </div>

    </div>
</div>

<style>

/* 🌌 MAIN WRAPPER */
.wrapper {
    position: relative;
    width: 100%;
    height: 100vh;
}

/* 🌈 BACKGROUND */
.bg {
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 0;
    background: linear-gradient(-45deg, #f5f3ff, #ffffff, #ede9fe, #faf5ff);
    background-size: 400% 400%;
    animation: gradientBG 10s ease infinite;
}

@keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* 🌌 PARTICLES */
#particles {
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 1;
}

/* 🔙 BACK BUTTON */
.back-btn {
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 20;
    padding: 10px 16px;
    background: rgba(0,0,0,0.7);
    color: white;
    border-radius: 10px;
    text-decoration: none;
    transition: 0.3s;
}
.back-btn:hover {
    transform: scale(1.05);
}

/* 🎯 CENTER FIX */
.center-box {
    position: relative;
    z-index: 10;

    width: 100%;
    height: 100vh;

    display: flex;
    justify-content: center;
    align-items: center;
}

/* 💎 CARD */
.card {
    width: 400px;
    padding: 35px;
    border-radius: 20px;
    backdrop-filter: blur(15px);
    background: rgba(255,255,255,0.75);
    box-shadow: 0 10px 40px rgba(124,58,237,0.25);
    animation: fadeUp 0.8s ease;
}

/* 🎯 TITLE */
.title {
    text-align: center;
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 20px;
    background: linear-gradient(to right, #7c3aed, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* 🧾 INPUT */
.input-group {
    margin-bottom: 15px;
}

.input-group label {
    font-size: 14px;
    color: #555;
}

.input-group input {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: none;
    margin-top: 5px;
    outline: none;
}

/* ✨ FOCUS */
input:focus {
    box-shadow: 0 0 0 2px rgba(124,58,237,0.3);
}

/* ❌ ERROR */
.error {
    color: red;
    font-size: 12px;
}

/* 🚀 BUTTON */
.btn {
    padding: 12px 20px;
    border-radius: 10px;
    border: none;
    color: white;
    background: linear-gradient(135deg, #7c3aed, #6366f1);
    cursor: pointer;
    transition: 0.3s;
}
.btn:hover {
    transform: scale(1.05);
}

/* 🔗 ACTIONS */
.actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
}

/* 🎬 ANIMATION */
@keyframes fadeUp {
    from {opacity:0; transform: translateY(30px);}
    to {opacity:1; transform: translateY(0);}
}

</style>

<script>

const canvas = document.getElementById("particles");
const ctx = canvas.getContext("2d");

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let particles = [];

// 🎯 CREATE PARTICLES
for (let i = 0; i < 80; i++) {
    particles.push({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        r: 2,
        dx: Math.random() - 0.5,
        dy: Math.random() - 0.5
    });
}

// 🔗 CONNECT
function connect() {
    for (let a = 0; a < particles.length; a++) {
        for (let b = a; b < particles.length; b++) {

            let dx = particles[a].x - particles[b].x;
            let dy = particles[a].y - particles[b].y;
            let dist = dx * dx + dy * dy;

            if (dist < 12000) {
                ctx.strokeStyle = "rgba(124,58,237,0.15)";
                ctx.beginPath();
                ctx.moveTo(particles[a].x, particles[a].y);
                ctx.lineTo(particles[b].x, particles[b].y);
                ctx.stroke();
            }
        }
    }
}

// 🎬 ANIMATION
function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    particles.forEach(p => {
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fillStyle = "#7c3aed";
        ctx.fill();

        p.x += p.dx;
        p.y += p.dy;

        if (p.x < 0 || p.x > canvas.width) p.dx *= -1;
        if (p.y < 0 || p.y > canvas.height) p.dy *= -1;
    });

    connect();
    requestAnimationFrame(animate);
}

animate();

</script>

</body>
</html>