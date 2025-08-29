<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sahrul ❤️ Rukiah - Cinta yang Tulus</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-pink: #ff6b9d;
            --secondary-pink: #ff9fc7;
            --light-pink: #ffe1f0;
            --purple: #7b68ee;
            --gold: #ffd700;
            --white: #ffffff;
            --text-dark: #2c2c2c;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary-pink) 0%, var(--purple) 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .floating-hearts {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .heart {
            position: absolute;
            color: rgba(255, 255, 255, 0.3);
            font-size: 20px;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10%, 90% { opacity: 1; }
            50% { transform: translateY(-10px) rotate(180deg); }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            text-align: center;
            padding: 60px 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            margin-bottom: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            animation: slideDown 1s ease-out;
        }

        @keyframes slideDown {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .main-title {
            font-family: 'Dancing Script', cursive;
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: heartbeat 2s ease-in-out infinite;
        }

        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .subtitle {
            font-size: 1.2rem;
            color: var(--light-pink);
            margin-bottom: 10px;
        }

        .love-quote {
            font-family: 'Dancing Script', cursive;
            font-size: 1.5rem;
            color: var(--gold);
            font-style: italic;
        }

        .section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 25px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s ease-out;
            transition: transform 0.3s ease;
        }

        .section:hover {
            transform: translateY(-5px);
        }

        @keyframes fadeInUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .section-title {
            font-family: 'Dancing Script', cursive;
            font-size: 2.5rem;
            color: var(--primary-pink);
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .section-title::after {
            content: '💖';
            position: absolute;
            right: -40px;
            top: 50%;
            transform: translateY(-50%);
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(-50%) scale(1); }
            50% { transform: translateY(-70%) scale(1.2); }
        }

        .love-letter {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-dark);
            text-align: justify;
            background: linear-gradient(45deg, #fff, #ffeef7);
            padding: 30px;
            border-radius: 15px;
            border-left: 5px solid var(--primary-pink);
            position: relative;
        }

        .love-letter::before {
            content: '💌';
            position: absolute;
            top: -10px;
            left: -10px;
            font-size: 30px;
            background: white;
            padding: 5px;
            border-radius: 50%;
        }

        .couple-names {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 30px;
            align-items: center;
            margin: 40px 0;
        }

        .name-card {
            background: linear-gradient(45deg, var(--primary-pink), var(--secondary-pink));
            color: white;
            padding: 30px 20px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(255, 107, 157, 0.3);
            transition: all 0.3s ease;
        }

        .name-card:hover {
            transform: scale(1.05) rotate(2deg);
        }

        .name {
            font-family: 'Dancing Script', cursive;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .role {
            font-size: 1rem;
            opacity: 0.9;
        }

        .heart-divider {
            font-size: 3rem;
            color: var(--gold);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.3); }
        }

        .memories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .memory-card {
            background: linear-gradient(135deg, #fff, #ffeef7);
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .memory-card:hover {
            border-color: var(--primary-pink);
            transform: translateY(-5px);
        }

        .memory-emoji {
            font-size: 2.5rem;
            margin-bottom: 15px;
            display: block;
        }

        .memory-title {
            font-weight: 600;
            color: var(--primary-pink);
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .memory-text {
            color: var(--text-dark);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .promises {
            background: linear-gradient(45deg, var(--light-pink), #fff);
            padding: 30px;
            border-radius: 20px;
            margin-top: 30px;
        }

        .promise-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .promise-item:hover {
            transform: translateX(10px);
            box-shadow: 0 8px 25px rgba(255, 107, 157, 0.2);
        }

        .promise-emoji {
            font-size: 1.5rem;
            margin-right: 15px;
        }

        .promise-text {
            color: var(--text-dark);
            font-weight: 500;
        }

        footer {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            text-align: center;
            padding: 40px 20px;
            border-radius: 25px;
            margin-top: 40px;
        }

        .footer-text {
            font-family: 'Dancing Script', cursive;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .date {
            color: var(--gold);
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .main-title {
                font-size: 2.5rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .couple-names {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .heart-divider {
                order: -1;
            }
            
            .container {
                padding: 10px;
            }
            
            .section {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="floating-hearts" id="hearts"></div>
    
    <div class="container">
        <header>
            <h1 class="main-title">Sahrul ❤️ Rukiah</h1>
            <p class="subtitle">Sebuah Cinta yang Tulus & Abadi</p>
            <p class="love-quote">"Kamu adalah alasan aku percaya pada cinta sejati"</p>
        </header>

        <section class="section">
            <h2 class="section-title">Tentang Cinta Kami</h2>
            <div class="couple-names">
                <div class="name-card">
                    <div class="name">Moh Sahrul Alam</div>
                    <div class="role">Yang Mencintai dengan Tulus</div>
                </div>
                <div class="heart-divider">💕</div>
                <div class="name-card">
                    <div class="name">Rukiah Hanum</div>
                    <div class="role">Yang Dicintai Sepenuh Hati</div>
                </div>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Surat Cinta untuk Rukiah</h2>
            <div class="love-letter">
                <p><strong>Rukiah sayang,</strong></p>
                <p>Kamu tahu nggak sih, sejak kamu ada di hidup aku, semuanya berubah jadi lebih indah. Setiap hari bersamamu adalah hari yang paling aku tunggu-tunggu. Senyummu adalah vitamin terbaik buat aku, dan ketawamu adalah musik terindah yang pernah aku dengar.</p>
                <p>Aku mungkin nggak sempurna, tapi satu hal yang pasti: cintaku sama kamu itu 100% tulus dari hati yang paling dalam. Kamu bukan cuma pacar aku, tapi kamu adalah rumah, adalah tempat aku merasa paling nyaman dan bahagia.</p>
                <p>Setiap detik tanpamu rasanya seperti kehilangan setengah jiwa. Makanya aku selalu bucin sama kamu, karena kamu memang layak untuk dicintai sebesar-besarnya. Kamu adalah hadiah terindah yang pernah Tuhan kasih ke aku.</p>
                <p>Terima kasih sudah mau jadi bagian dari hidup aku, sayang. Aku janji akan selalu sayang sama kamu, selalu jaga kamu, dan selalu bikin kamu bahagia. Sampai kapanpun, kamu akan selalu jadi yang utama di hati aku.</p>
                <p><strong>Dengan cinta yang tak terhingga,<br>Sahrul Alam mu ❤️</strong></p>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Kenangan Indah Kita</h2>
            <div class="memories">
                <div class="memory-card">
                    <span class="memory-emoji">💝</span>
                    <div class="memory-title">Pertama Kali Ketemu</div>
                    <div class="memory-text">Saat pertama kali lihat kamu, aku langsung tahu kalau kamu istimewa. Jantung aku langsung berdebar kencang!</div>
                </div>
                <div class="memory-card">
                    <span class="memory-emoji">🥰</span>
                    <div class="memory-title">Chat Pertama</div>
                    <div class="memory-text">Ingat nggak waktu kita chat pertama kali? Aku sampai senyum-senyum sendiri baca pesanmu!</div>
                </div>
                <div class="memory-card">
                    <span class="memory-emoji">💕</span>
                    <div class="memory-title">Jadian</div>
                    <div class="memory-text">Hari paling membahagiakan dalam hidup aku, saat kamu bilang iya jadi pacar aku. Best day ever!</div>
                </div>
                <div class="memory-card">
                    <span class="memory-emoji">🌹</span>
                    <div class="memory-title">Setiap Hari</div>
                    <div class="memory-text">Setiap hari bersamamu adalah kenangan indah yang selalu aku simpan di hati.</div>
                </div>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Janji-Janji Aku</h2>
            <div class="promises">
                <div class="promise-item">
                    <span class="promise-emoji">💖</span>
                    <span class="promise-text">Aku janji akan selalu sayang sama kamu lebih dari apapun</span>
                </div>
                <div class="promise-item">
                    <span class="promise-emoji">🛡️</span>
                    <span class="promise-text">Aku akan selalu jaga kamu dan bela kamu dalam kondisi apapun</span>
                </div>
                <div class="promise-item">
                    <span class="promise-emoji">😊</span>
                    <span class="promise-text">Aku akan selalu usaha bikin kamu bahagia setiap hari</span>
                </div>
                <div class="promise-item">
                    <span class="promise-emoji">🤗</span>
                    <span class="promise-text">Aku akan selalu ada buat kamu di saat senang maupun sedih</span>
                </div>
                <div class="promise-item">
                    <span class="promise-emoji">💍</span>
                    <span class="promise-text">Aku akan selalu setia dan nggak akan pernah nyakitin hati kamu</span>
                </div>
                <div class="promise-item">
                    <span class="promise-emoji">🌟</span>
                    <span class="promise-text">Aku akan selalu dukung semua impian dan cita-cita kamu</span>
                </div>
                <div class="promise-item">
                    <span class="promise-emoji">❤️</span>
                    <span class="promise-text">Yang paling penting: Aku akan cinta kamu sampai kapanpun!</span>
                </div>
            </div>
        </section>

        <footer>
            <p class="footer-text">Dibuat dengan segenap cinta oleh Sahrul untuk Rukiah tercinta</p>
            <p class="date">28 Agustus 2025 💖</p>
            <p style="margin-top: 20px; font-size: 2rem;">💕 LOVE YOU FOREVER 💕</p>
        </footer>
    </div>

    <script>
        // Create floating hearts
        function createHeart() {
            const heart = document.createElement('div');
            heart.className = 'heart';
            heart.innerHTML = '💖';
            heart.style.left = Math.random() * 100 + 'vw';
            heart.style.animationDelay = Math.random() * 3 + 's';
            heart.style.animationDuration = (Math.random() * 3 + 3) + 's';
            document.getElementById('hearts').appendChild(heart);

            setTimeout(() => {
                heart.remove();
            }, 6000);
        }

        // Create hearts periodically
        setInterval(createHeart, 800);

        // Add some interactive effects
        document.addEventListener('click', function(e) {
            const clickHeart = document.createElement('div');
            clickHeart.innerHTML = '💕';
            clickHeart.style.position = 'absolute';
            clickHeart.style.left = e.clientX + 'px';
            clickHeart.style.top = e.clientY + 'px';
            clickHeart.style.fontSize = '20px';
            clickHeart.style.pointerEvents = 'none';
            clickHeart.style.animation = 'bounce 1s ease-out forwards';
            clickHeart.style.zIndex = '1000';
            document.body.appendChild(clickHeart);

            setTimeout(() => {
                clickHeart.remove();
            }, 1000);
        });

        // Add scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationDelay = '0s';
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.section').forEach(section => {
            observer.observe(section);
        });
    </script>
</body>
</html>