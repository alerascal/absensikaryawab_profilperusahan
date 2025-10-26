<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@sahrul.dev - Portfolio</title>
    <style>
        :root {
            --bg-primary: #000;
            --bg-secondary: #111;
            --bg-tertiary: #1a1a1a;
            --text-primary: #fff;
            --text-secondary: #888;
            --text-muted: #666;
            --accent-color: #00d4aa;
            --accent-secondary: #00ffcc;
            --border-color: #333;
            --hover-bg: #222;
            --card-bg: #111;
            --success-color: #22c55e;
            --warning-color: #f59e0b;
        }

        [data-theme="light"] {
            --bg-primary: #fff;
            --bg-secondary: #f8f9fa;
            --bg-tertiary: #e9ecef;
            --text-primary: #000;
            --text-secondary: #666;
            --text-muted: #999;
            --accent-color: #00b894;
            --accent-secondary: #00cec9;
            --border-color: #e1e5e9;
            --hover-bg: #f1f3f4;
            --card-bg: #fff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            overflow-x: hidden;
            transition: all 0.3s ease;
        }

        .container {
            max-width: 430px;
            margin: 0 auto;
            min-height: 100vh;
            position: relative;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--bg-primary);
        }

        .username {
            font-size: 18px;
            font-weight: 700;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: var(--bg-secondary);
            color: var(--text-primary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            transform: scale(1.1);
            background: var(--hover-bg);
        }

        .menu-icon {
            display: flex;
            flex-direction: column;
            gap: 3px;
            cursor: pointer;
            padding: 5px;
        }

        .menu-line {
            width: 20px;
            height: 2px;
            background: var(--text-primary);
            transition: 0.3s ease;
        }

        .profile-section {
            padding: 30px 20px;
            text-align: center;
            background: var(--bg-primary);
        }

        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--accent-color), var(--accent-secondary));
            margin: 0 auto 20px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease;
            border: 4px solid var(--bg-primary);
            box-shadow: 0 0 20px rgba(0, 212, 170, 0.3);
        }

        .profile-pic:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .profile-pic::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            background: var(--bg-primary);
            border-radius: 50%;
        }

        .profile-pic::after {
            content: '👨‍💻';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 35px;
            z-index: 1;
        }

        .name {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .title {
            font-size: 16px;
            color: var(--text-secondary);
            margin-bottom: 15px;
        }

        .location {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .stats {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-bottom: 25px;
        }

        .stat {
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .stat:hover {
            transform: translateY(-2px);
        }

        .stat-number {
            font-size: 22px;
            font-weight: 700;
            background: linear-gradient(45deg, var(--accent-color), var(--accent-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .bio {
            font-size: 15px;
            line-height: 1.6;
            color: var(--text-primary);
            margin-bottom: 25px;
            padding: 0 10px;
        }

        .hashtags {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin-bottom: 25px;
        }

        .hashtag {
            background: var(--bg-secondary);
            color: var(--accent-color);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .hashtag:hover {
            background: var(--accent-color);
            color: var(--bg-primary);
            transform: translateY(-2px);
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 30px;
        }

        .btn {
            padding: 14px 32px;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: var(--accent-color);
            color: #fff;
        }

        .btn-secondary {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border: 2px solid var(--border-color);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .btn-primary:hover {
            background: var(--accent-secondary);
            box-shadow: 0 10px 20px rgba(0, 212, 170, 0.3);
        }

        .btn-secondary:hover {
            background: var(--hover-bg);
        }

        .tabs {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            background: var(--bg-primary);
            position: sticky;
            top: 81px;
            z-index: 99;
        }

        .tab {
            flex: 1;
            padding: 18px;
            text-align: center;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            color: var(--text-secondary);
            transition: all 0.3s ease;
            position: relative;
        }

        .tab.active {
            color: var(--text-primary);
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 3px;
            background: var(--accent-color);
            border-radius: 3px;
        }

        .content {
            padding: 20px;
            background: var(--bg-primary);
        }

        .projects-content {
            display: none;
        }

        .projects-content.active {
            display: block;
        }

        .project-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 3px;
            margin-bottom: 30px;
        }

        .project-item {
            aspect-ratio: 1;
            background: var(--bg-secondary);
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .project-item:hover {
            transform: scale(1.05);
            z-index: 2;
        }

        .project-item:nth-child(1) { background: linear-gradient(45deg, var(--accent-color), var(--accent-secondary)); }
        .project-item:nth-child(2) { background: linear-gradient(45deg, #ff6b6b, #ee5a52); }
        .project-item:nth-child(3) { background: linear-gradient(45deg, #4ecdc4, #44a08d); }
        .project-item:nth-child(4) { background: linear-gradient(45deg, #45b7d1, #96c93d); }
        .project-item:nth-child(5) { background: linear-gradient(45deg, #f093fb, #f5576c); }
        .project-item:nth-child(6) { background: linear-gradient(45deg, #ffeaa7, #fab1a0); }

        .project-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            padding: 10px;
        }

        .project-item:hover .project-overlay {
            opacity: 1;
        }

        .project-title {
            color: #fff;
            font-weight: 700;
            font-size: 13px;
            text-align: center;
            margin-bottom: 5px;
        }

        .project-tech {
            color: #ccc;
            font-size: 10px;
            text-align: center;
        }

        .featured-projects {
            margin-top: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--text-primary);
        }

        .featured-project {
            background: var(--card-bg);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .featured-project:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .project-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .project-name {
            font-size: 16px;
            font-weight: 700;
        }

        .project-status {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
        }

        .status-live {
            background: var(--success-color);
            color: white;
        }

        .status-development {
            background: var(--warning-color);
            color: white;
        }

        .project-description {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.4;
            margin-bottom: 15px;
        }

        .project-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 15px;
        }

        .project-tag {
            background: var(--bg-secondary);
            color: var(--text-secondary);
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 11px;
        }

        .project-links {
            display: flex;
            gap: 10px;
        }

        .project-link {
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .link-demo {
            background: var(--accent-color);
            color: white;
        }

        .link-github {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .skills-content {
            display: none;
        }

        .skills-content.active {
            display: block;
        }

        .skills-category {
            margin-bottom: 30px;
        }

        .category-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .skill-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            margin-bottom: 10px;
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .skill-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .skill-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .skill-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            background: var(--bg-secondary);
        }

        .skill-details h4 {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 14px;
        }

        .skill-details p {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .skill-level {
            text-align: right;
        }

        .skill-percentage {
            font-size: 14px;
            color: var(--accent-color);
            font-weight: 700;
        }

        .skill-bar {
            width: 60px;
            height: 4px;
            background: var(--bg-secondary);
            border-radius: 2px;
            margin-top: 5px;
            overflow: hidden;
        }

        .skill-progress {
            height: 100%;
            background: linear-gradient(90deg, var(--accent-color), var(--accent-secondary));
            border-radius: 2px;
            transition: width 0.3s ease;
        }

        .about-content {
            display: none;
        }

        .about-content.active {
            display: block;
        }

        .about-section {
            margin-bottom: 30px;
        }

        .about-text {
            font-size: 15px;
            line-height: 1.7;
            color: var(--text-primary);
            margin-bottom: 20px;
        }

        .experience-item {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid var(--border-color);
        }

        .exp-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .exp-title {
            font-weight: 700;
            font-size: 16px;
        }

        .exp-company {
            color: var(--accent-color);
            font-size: 14px;
            margin-top: 2px;
        }

        .exp-date {
            font-size: 12px;
            color: var(--text-secondary);
            text-align: right;
        }

        .exp-description {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .contact-content {
            display: none;
        }

        .contact-content.active {
            display: block;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            margin-bottom: 10px;
            background: var(--card-bg);
            border-radius: 15px;
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .contact-icon.email { background: linear-gradient(45deg, var(--accent-color), var(--accent-secondary)); }
        .contact-icon.github { background: linear-gradient(45deg, #333, #555); }
        .contact-icon.whatsapp { background: linear-gradient(45deg, #25d366, #128c7e); }
        .contact-icon.location { background: linear-gradient(45deg, #ff6b6b, #ee5a52); }

        .contact-info h4 {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 2px;
        }

        .contact-info p {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .achievement-badges {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 20px;
        }

        .badge {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 15px 10px;
            text-align: center;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .badge:hover {
            transform: scale(1.05);
        }

        .badge-icon {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .badge-title {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .badge-subtitle {
            font-size: 10px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .floating-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1000;
        }

        .particle {
            position: absolute;
            font-size: 16px;
            animation: float 4s ease-in-out infinite;
            opacity: 0;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }

        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--bg-primary);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.5s ease;
        }

        .loading.hide {
            opacity: 0;
            pointer-events: none;
        }

        .loader {
            width: 50px;
            height: 50px;
            border: 3px solid var(--border-color);
            border-top: 3px solid var(--accent-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .loading-text {
            margin-top: 20px;
            font-size: 14px;
            color: var(--text-secondary);
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (min-width: 768px) {
            .container {
                max-width: 500px;
            }
            
            .project-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
            }

            .stats {
                gap: 50px;
            }
        }
    </style>
</head>
<body data-theme="dark">
    <div class="loading" id="loading">
        <div class="loader"></div>
        <div class="loading-text">Loading Portfolio...</div>
    </div>

    <div class="floating-particles" id="particlesContainer"></div>
    
    <div class="container">
        <div class="header">
            <div class="username">@sahrul.dev</div>
            <div class="header-actions">
                <button class="theme-toggle" onclick="toggleTheme()">
                    <span id="themeIcon">🌙</span>
                </button>
                <div class="menu-icon" onclick="createParticles()">
                    <div class="menu-line"></div>
                    <div class="menu-line"></div>
                    <div class="menu-line"></div>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <div class="profile-pic" onclick="createParticles()"></div>
            <div class="name">Moh Sahrul Alamsyah</div>
            <div class="title">Fullstack Developer • UI/UX Enthusiast</div>
            <div class="location">📍 Tegal, Jawa Tengah, Indonesia</div>
            
            <div class="stats">
                <div class="stat" onclick="createParticles()">
                    <div class="stat-number">3.57</div>
                    <div class="stat-label">IPK/4.0</div>
                </div>
                <div class="stat" onclick="createParticles()">
                    <div class="stat-number">15+</div>
                    <div class="stat-label">Projects</div>
                </div>
                <div class="stat" onclick="createParticles()">
                    <div class="stat-number">2+</div>
                    <div class="stat-label">Tahun Exp</div>
                </div>
            </div>

            <div class="bio">
                ⚡ Fullstack Developer dengan passion untuk problem solving<br>
                🚀 Spesialis Laravel, JavaScript & Database Management<br>
                🎨 Mengubah ide menjadi solusi digital yang modern<br>
                📧 Siap untuk proyek menarik & kolaborasi!
            </div>

            <div class="hashtags">
                <div class="hashtag">#Laravel</div>
                <div class="hashtag">#JavaScript</div>
                <div class="hashtag">#PHP</div>
                <div class="hashtag">#MySQL</div>
                <div class="hashtag">#ReactJS</div>
                <div class="hashtag">#SystemAnalysis</div>
            </div>

            <div class="action-buttons">
                <a href="mailto:12221479@bsi.ac.id" class="btn btn-primary">Hire Me</a>
                <a href="https://wa.me/6282220668915" class="btn btn-secondary">WhatsApp</a>
            </div>
        </div>

        <div class="tabs">
            <div class="tab active" onclick="showTab('projects')">Projects</div>
            <div class="tab" onclick="showTab('skills')">Skills</div>
            <div class="tab" onclick="showTab('about')">About</div>
            <div class="tab" onclick="showTab('contact')">Contact</div>
        </div>

        <div class="content">
            <!-- Projects Tab -->
            <div class="projects-content active" id="projects">
                <div class="project-grid">
                    <div class="project-item" onclick="createParticles()">
                        <div class="project-overlay">
                            <div class="project-title">Sistem Absensi Digital</div>
                            <div class="project-tech">Laravel, MySQL</div>
                        </div>
                    </div>
                    <div class="project-item" onclick="createParticles()">
                        <div class="project-overlay">
                            <div class="project-title">Dashboard Manajemen</div>
                            <div class="project-tech">PHP, Bootstrap</div>
                        </div>
                    </div>
                    <div class="project-item" onclick="createParticles()">
                        <div class="project-overlay">
                            <div class="project-title">Website Layanan Publik</div>
                            <div class="project-tech">PHP, JavaScript</div>
                        </div>
                    </div>
                    <div class="project-item" onclick="createParticles()">
                        <div class="project-overlay">
                            <div class="project-title">E-Commerce Platform</div>
                            <div class="project-tech">Laravel, React</div>
                        </div>
                    </div>
                    <div class="project-item" onclick="createParticles()">
                        <div class="project-overlay">
                            <div class="project-title">API Integration System</div>
                            <div class="project-tech">PHP, RESTful API</div>
                        </div>
                    </div>
                    <div class="project-item" onclick="createParticles()">
                        <div class="project-overlay">
                            <div class="project-title">Data Analytics Tool</div>
                            <div class="project-tech">Python, MySQL</div>
                        </div>
                    </div>
                </div>

                <div class="featured-projects">
                    <div class="section-title">🌟 Featured Projects</div>
                    
                    <div class="featured-project">
                        <div class="project-header">
                            <div class="project-name">Sistem Absensi Digital</div>
                            <div class="project-status status-live">Live</div>
                        </div>
                        <div class="project-description">
                            Sistem absensi berbasis web dengan fitur capture kamera real-time, geolocation tracking, dan dashboard admin lengkap. Mengelola data pegawai dan menghasilkan laporan otomatis.
                        </div>
                        <div class="project-tags">
                            <div class="project-tag">Laravel</div>
                            <div class="project-tag">MySQL</div>
                            <div class="project-tag">JavaScript</div>
                            <div class="project-tag">Bootstrap</div>
                        </div>
                        <div class="project-links">
                            <a href="#" class="project-link link-demo">Demo</a>
                            <a href="#" class="project-link link-github">GitHub</a>
                        </div>
                    </div>

                    <div class="featured-project">
                        <div class="project-header">
                            <div class="project-name">Dashboard Manajemen Data</div>
                            <div class="project-status status-development">Development</div>
                        </div>
                        <div class="project-description">
                            Dashboard comprehensive untuk monitoring data pegawai, laporan harian, dan sistem manajemen dokumen dengan interface yang user-friendly dan responsive.
                        </div>
                        <div class="project-tags">
                            <div class="project-tag">PHP</div>
                            <div class="project-tag">Bootstrap</div>
                            <div class="project-tag">MySQL</div>
                            <div class="project-tag">Chart.js</div>
                        </div>
                        <div class="project-links">
                            <a href="#" class="project-link link-demo">Demo</a>
                            <a href="#" class="project-link link-github">GitHub</a>
                        </div>
                    </div>
                </div>

                <div class="achievement-badges">
                    <div class="badge">
                        <div class="badge-icon">🏆</div>
                        <div class="badge-title">IPK 3.57</div>
                        <div class="badge-subtitle">BSI University</div>
                    </div>
                    <div class="badge">
                        <div class="badge-icon">💼</div>
                        <div class="badge-title">Magang DPRD</div>
                        <div class="badge-subtitle">Tegal 2024</div>
                    </div>
                    <div class="badge">
                        <div class="badge-icon">🎯</div>
                        <div class="badge-title">5+ Sertifikat</div>
                        <div class="badge-subtitle">Professional</div>
                    </div>
                    <div class="badge">
                        <div class="badge-icon">📱</div>
                        <div class="badge-title">Live Host</div>
                        <div class="badge-subtitle">Shopee Affiliate</div>
                    </div>
                </div>
            </div>

            <!-- Skills Tab -->
            <div class="skills-content" id="skills">
                <div class="skills-category">
                    <div class="category-title">💻 Backend Development</div>
                    
                    <div class="skill-item">
                        <div class="skill-info">
                            <div class="skill-icon" style="background: #777bb4;">🐘</div>
                            <div class="skill-details">
                                <h4>PHP</h4>
                                <p>3+ tahun pengalaman</p>
                            </div>
                        </div>
                        <div class="skill-level">
                            <div class="skill-percentage">90%</div>
                            <div class="skill-bar">
                                <div class="skill-progress" style="width: 90%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="skill-item">
                        <div class="skill-info">
                            <div class="skill-icon" style="background: #ff2d20;">🚀</div>
                            <div class="skill-details">
                                <h4>Laravel</h4>
                                <p>Framework utama</p>
                            </div>
                        </div>
                        <div class="skill-level">
                            <div class="skill-percentage">88%</div>
                            <div class="skill-bar">
                                <div class="skill-progress" style="width: 88%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="skill-item">
                        <div class="skill-info">
                            <div class="skill-icon" style="background: #336791;">🗄️</div>
                            <div class="skill-details">
                                <h4>MySQL</h4>
                                <p>Database management</p>
                            </div>
                        </div>
                        <div class="skill-level">
                            <div class="skill-percentage">85%</div>
                            <div class="skill-bar">
                                <div class="skill-progress" style="width: 85%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="skill-item">
                        <div class="skill-info">
                            <div class="skill-icon" style="background: #3776ab;">🐍</div>
                            <div class="skill-details">
                                <h4>Python</h4>
                                <p>Data analysis & automation</p>
                            </div>
                        </div>
                        <div class="skill-level">
                            <div class="skill-percentage">75%</div>
                            <div class="skill-bar">
                                <div class="skill-progress" style="width: 75%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="skills-category">
                    <div class="category-title">🎨 Frontend Development</div>
                    
                    <div class="skill-item">
                        <div class="skill-info">
                            <div class="skill-icon" style="background: #f7df1e;">💛</div>
                            <div class="skill-details">
                                <h4>JavaScript</h4>
                                <p>Vanilla JS & ES6+</p>
                            </div>
                        </div>
                        <div class="skill-level">
                            <div class="skill-percentage">82%</div>
                            <div class="skill-bar">
                                <div class="skill-progress" style="width: 82%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="skill-item">
                        <div class="skill-info">
                            <div class="skill-icon" style="background: #61dafb;">⚛️</div>
                            <div class="skill-details">
                                <h4>React.js</h4>
                                <p>Modern UI development</p>
                            </div>
                        </div>
                        <div class="skill-level">
                            <div class="skill-percentage">78%</div>
                            <div class="skill-bar">
                                <div class="skill-progress" style="width: 78%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="skill-item">
                        <div class="skill-info">
                            <div class="skill-icon" style="background: #e34f26;">🌐</div>
                            <div class="skill-details">
                                <h4>HTML & CSS</h4>
                                <p>Semantic & responsive</p>
                            </div>
                        </div>
                        <div class="skill-level">
                            <div class="skill-percentage">92%</div>
                            <div class="skill-bar">
                                <div class="skill-progress" style="width: 92%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="skill-item">
                        <div class="skill-info">
                            <div class="skill-icon" style="background: #563d7c;">🎨</div>
                            <div class="skill-details">
                                <h4>Bootstrap</h4>
                                <p>CSS framework</p>
                            </div>
                        </div>
                        <div class="skill-level">
                            <div class="skill-percentage">88%</div>
                            <div class="skill-bar">
                                <div class="skill-progress" style="width: 88%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="skills-category">
                    <div class="category-title">🛠️ Tools & Technologies</div>
                    
                    <div class="skill-item">
                        <div class="skill-info">
                            <div class="skill-icon" style="background: #f05032;">🔧</div>
                            <div class="skill-details">
                                <h4>Git & GitHub</h4>
                                <p>Version control</p>
                            </div>
                        </div>
                        <div class="skill-level">
                            <div class="skill-percentage">80%</div>
                            <div class="skill-bar">
                                <div class="skill-progress" style="width: 80%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="skill-item">
                        <div class="skill-info">
                            <div class="skill-icon" style="background: #0078d4;">💼</div>
                            <div class="skill-details">
                                <h4>Microsoft Office</h4>
                                <p>Professional suite</p>
                            </div>
                        </div>
                        <div class="skill-level">
                            <div class="skill-percentage">95%</div>
                            <div class="skill-bar">
                                <div class="skill-progress" style="width: 95%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="skill-item">
                        <div class="skill-info">
                            <div class="skill-icon" style="background: #ff6b35;">🌐</div>
                            <div class="skill-details">
                                <h4>REST API</h4>
                                <p>Integration & development</p>
                            </div>
                        </div>
                        <div class="skill-level">
                            <div class="skill-percentage">83%</div>
                            <div class="skill-bar">
                                <div class="skill-progress" style="width: 83%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="skills-category">
                    <div class="category-title">🌟 Soft Skills</div>
                    
                    <div class="skill-item">
                        <div class="skill-info">
                            <div class="skill-icon" style="background: #28a745;">🔍</div>
                            <div class="skill-details">
                                <h4>Problem Solving</h4>
                                <p>Analytical thinking</p>
                            </div>
                        </div>
                        <div class="skill-level">
                            <div class="skill-percentage">90%</div>
                            <div class="skill-bar">
                                <div class="skill-progress" style="width: 90%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="skill-item">
                        <div class="skill-info">
                            <div class="skill-icon" style="background: #17a2b8;">💬</div>
                            <div class="skill-details">
                                <h4>Communication</h4>
                                <p>Team collaboration</p>
                            </div>
                        </div>
                        <div class="skill-level">
                            <div class="skill-percentage">87%</div>
                            <div class="skill-bar">
                                <div class="skill-progress" style="width: 87%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="skill-item">
                        <div class="skill-info">
                            <div class="skill-icon" style="background: #6f42c1;">📊</div>
                            <div class="skill-details">
                                <h4>System Analysis</h4>
                                <p>Business requirements</p>
                            </div>
                        </div>
                        <div class="skill-level">
                            <div class="skill-percentage">85%</div>
                            <div class="skill-bar">
                                <div class="skill-progress" style="width: 85%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="skill-item">
                        <div class="skill-info">
                            <div class="skill-icon" style="background: #ffc107;">🌐</div>
                            <div class="skill-details">
                                <h4>English</h4>
                                <p>Technical communication</p>
                            </div>
                        </div>
                        <div class="skill-level">
                            <div class="skill-percentage">75%</div>
                            <div class="skill-bar">
                                <div class="skill-progress" style="width: 75%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- About Tab -->
            <div class="about-content" id="about">
                <div class="about-section">
                    <div class="section-title">👨‍💻 Tentang Saya</div>
                    <div class="about-text">
                        Saya Moh Sahrul Alamsyah, seorang Fullstack Developer yang passionate dalam menciptakan solusi digital inovatif. Dengan latar belakang pendidikan Sistem Informasi di Universitas Bina Sarana Informatika (IPK 3.57), saya memiliki fondasi yang kuat dalam pengembangan aplikasi web end-to-end.
                    </div>
                    <div class="about-text">
                        Saya menguasai teknologi modern seperti Laravel, JavaScript, dan MySQL dengan fokus pada problem solving dan system analysis. Pengalaman saya mencakup pengembangan sistem absensi digital, dashboard manajemen data, dan berbagai aplikasi web untuk keperluan bisnis maupun layanan publik.
                    </div>
                </div>

                <div class="about-section">
                    <div class="section-title">💼 Pengalaman Kerja</div>
                    
                    <div class="experience-item">
                        <div class="exp-header">
                            <div>
                                <div class="exp-title">Host Live / Shopee Affiliate</div>
                                <div class="exp-company">Shopee Platform</div>
                            </div>
                            <div class="exp-date">2024 - Sekarang</div>
                        </div>
                        <div class="exp-description">
                            Menjadi Host Live di platform Shopee untuk mempromosikan produk affiliate. Meningkatkan interaksi penonton dan konversi penjualan melalui strategi presentasi yang menarik serta mengelola konten live dan memantau performa penjualan.
                        </div>
                    </div>

                    <div class="experience-item">
                        <div class="exp-header">
                            <div>
                                <div class="exp-title">Magang</div>
                                <div class="exp-company">Sekretariat DPRD Kota Tegal</div>
                            </div>
                            <div class="exp-date">Sep - Nov 2024</div>
                        </div>
                        <div class="exp-description">
                            Bertanggung jawab dalam pengarsipan surat masuk dan keluar serta memberikan layanan pelanggan terkait status pengiriman dan penyelesaian masalah. Memperoleh pengalaman dalam administrasi pemerintahan dan pelayanan publik.
                        </div>
                    </div>

                    <div class="experience-item">
                        <div class="exp-header">
                            <div>
                                <div class="exp-title">Freelance</div>
                                <div class="exp-company">Kantor Pos Indonesia</div>
                            </div>
                            <div class="exp-date">Jun - Ags 2022</div>
                        </div>
                        <div class="exp-description">
                            Membantu menyalurkan bantuan sosial uang tunai kepada warga miskin yang terdaftar sebagai penerima bantuan. Memberikan layanan pelanggan dengan membantu pelanggan dalam menanyakan status pengiriman dan menyelesaikan masalah terkait.
                        </div>
                    </div>
                </div>

                <div class="about-section">
                    <div class="section-title">🎓 Pendidikan & Sertifikasi</div>
                    
                    <div class="experience-item">
                        <div class="exp-header">
                            <div>
                                <div class="exp-title">D3 Sistem Informasi</div>
                                <div class="exp-company">Universitas Bina Sarana Informatika</div>
                            </div>
                            <div class="exp-date">2022 - 2025</div>
                        </div>
                        <div class="exp-description">
                            IPK: 3.57/4.00. Fokus pada Web Programming, Database Management, System Analysis, dan Entrepreneurship. Memperoleh pemahaman mendalam tentang pengembangan sistem informasi dan teknologi web.
                        </div>
                    </div>

                    <div class="experience-item">
                        <div class="exp-header">
                            <div>
                                <div class="exp-title">Sertifikasi Professional</div>
                                <div class="exp-company">Berbagai Institusi</div>
                            </div>
                            <div class="exp-date">2022 - 2024</div>
                        </div>
                        <div class="exp-description">
                            • Sertifikat Profiensi Database System<br>
                            • Sertifikat Magang DPRD Kota Tegal<br>
                            • Sertifikat Serkom<br>
                            • TOEFL Certificate<br>
                            • Sertifikat Pelatihan Teknis
                        </div>
                    </div>
                </div>

                <div class="about-section">
                    <div class="section-title">🎯 Fokus & Keahlian</div>
                    <div class="about-text">
                        <strong>Spesialisasi:</strong><br>
                        • Fullstack Web Development (Laravel, PHP, JavaScript)<br>
                        • Database Design & Management (MySQL)<br>
                        • System Analysis & Requirements Engineering<br>
                        • API Development & Integration<br>
                        • Responsive Web Design (HTML, CSS, Bootstrap)
                    </div>
                    <div class="about-text">
                        <strong>Keunggulan:</strong><br>
                        • Problem Solving dengan pendekatan analytical<br>
                        • Communication skills untuk kolaborasi tim<br>
                        • Pemahaman bisnis dan kebutuhan user<br>
                        • Adaptif terhadap teknologi dan framework baru
                    </div>
                </div>
            </div>

            <!-- Contact Tab -->
            <div class="contact-content" id="contact">
                <div class="section-title">📬 Hubungi Saya</div>
                
                <div class="contact-item" onclick="window.open('mailto:12221479@bsi.ac.id')">
                    <div class="contact-icon email">📧</div>
                    <div class="contact-info">
                        <h4>Email</h4>
                        <p>12221479@bsi.ac.id</p>
                    </div>
                </div>

                <div class="contact-item" onclick="window.open('https://wa.me/6282220668915')">
                    <div class="contact-icon whatsapp">📱</div>
                    <div class="contact-info">
                        <h4>WhatsApp</h4>
                        <p>+62 822-2066-8915</p>
                    </div>
                </div>

                <div class="contact-item" onclick="window.open('https://github.com/sahrul-dev')">
                    <div class="contact-icon github">🐙</div>
                    <div class="contact-info">
                        <h4>GitHub</h4>
                        <p>@sahrul-dev • Projects & Code</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon location">📍</div>
                    <div class="contact-info">
                        <h4>Lokasi</h4>
                        <p>Jl. Ruslani hs no 21, Kemandungan, Tegal</p>
                    </div>
                </div>

                <div class="about-section" style="margin-top: 30px;">
                    <div class="section-title">💼 Mari Berkolaborasi</div>
                    <div class="about-text">
                        Saya terbuka untuk mendiskusikan peluang kerja baru, proyek menarik, atau sekadar berbagi pengalaman tentang teknologi. Baik Anda mencari developer untuk ide besar berikutnya atau ingin berkolaborasi dalam proyek open-source, jangan ragu untuk menghubungi saya!
                    </div>
                    <div class="about-text">
                        <strong>Saat ini tersedia untuk:</strong><br>
                        • Proyek freelance & contract work<br>
                        • Peluang kerja full-time<br>
                        • Konsultasi & mentoring<br>
                        • Kolaborasi proyek teknologi<br>
                        • Speaking di acara tech
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Theme Toggle Functionality
        function toggleTheme() {
            const body = document.body;
            const themeIcon = document.getElementById('themeIcon');
            
            if (body.getAttribute('data-theme') === 'dark') {
                body.setAttribute('data-theme', 'light');
                themeIcon.textContent = '☀️';
            } else {
                body.setAttribute('data-theme', 'dark');
                themeIcon.textContent = '🌙';
            }
        }

        // Tab Navigation
        function showTab(tabName) {
            // Hide all content
            document.querySelectorAll('.projects-content, .skills-content, .about-content, .contact-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Show selected content
            document.getElementById(tabName).classList.add('active');
            
            // Add active class to clicked tab
            event.target.classList.add('active');
        }

        // Floating Particles Animation
        function createParticles() {
            const container = document.getElementById('particlesContainer');
            const particles = ['💻', '⚡', '🚀', '🎯', '💡', '🔧', '📱', '🌟', '💼', '🎨'];
            
            for(let i = 0; i < 6; i++) {
                setTimeout(() => {
                    const particle = document.createElement('div');
                    particle.className = 'particle';
                    particle.textContent = particles[Math.floor(Math.random() * particles.length)];
                    particle.style.left = Math.random() * 100 + 'vw';
                    particle.style.animationDuration = (Math.random() * 3 + 2) + 's';
                    particle.style.opacity = Math.random() * 0.8 + 0.3;
                    particle.style.fontSize = (Math.random() * 8 + 12) + 'px';
                    
                    container.appendChild(particle);
                    
                    setTimeout(() => {
                        particle.remove();
                    }, 5000);
                }, i * 200);
            }
        }

        // Auto-create particles periodically
        setInterval(createParticles, 20000);

        // Add click animations
        document.querySelectorAll('.project-item, .skill-item, .contact-item').forEach(item => {
            item.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'scale(1.05)';
                }, 100);
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 200);
            });
        });

        // Animate skill bars on scroll
        function animateSkillBars() {
            const skillBars = document.querySelectorAll('.skill-progress');
            skillBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            });
        }

        // Stats counter animation
        function animateStats() {
            const stats = document.querySelectorAll('.stat-number');
            const finalValues = ['3.57', '15+', '2+'];
            
            stats.forEach((stat, index) => {
                if (index === 0) {
                    // Animate GPA
                    let current = 0;
                    const target = 3.57;
                    const timer = setInterval(() => {
                        current += 0.1;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        stat.textContent = current.toFixed(2);
                    }, 50);
                } else {
                    // Animate other numbers
                    let current = 0;
                    const target = parseInt(finalValues[index]);
                    const timer = setInterval(() => {
                        current += 1;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        stat.textContent = current + (index === 1 ? '+' : '+');
                    }, 100);
                }
            });
        }

        // Loading screen
        function hideLoading() {
            const loading = document.getElementById('loading');
            setTimeout(() => {
                loading.classList.add('hide');
                animateStats();
            }, 2000);
        }

        // Initialize everything when page loads
        document.addEventListener('DOMContentLoaded', function() {
            hideLoading();
            
            // Animate skill bars when skills tab is opened
            document.querySelector('[onclick="showTab(\'skills\')"]').addEventListener('click', () => {
                setTimeout(animateSkillBars, 100);
            });

            // Create initial particles
            setTimeout(createParticles, 3000);
        });

        // Smooth scroll for better UX
        document.documentElement.style.scrollBehavior = 'smooth';

        // Add parallax effect to profile pic
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const profilePic = document.querySelector('.profile-pic');
            if (profilePic && scrolled < 500) {
                profilePic.style.transform = `translateY(${scrolled * 0.1}px) scale(1)`;
            }
        });

        // Add typing effect to bio
        function typeWriter(element, text, speed = 50) {
            let i = 0;
            element.innerHTML = '';
            function type() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                }
            }
            type();
        }

        // Initialize typing effect after loading
        setTimeout(() => {
            const bio = document.querySelector('.bio');
            const originalText = bio.innerHTML;
            typeWriter(bio, originalText, 30);
        }, 3000);
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Portfolio</title>
    <style>
        :root {
            --bg-primary: #000;
            --bg-secondary: #111;
            --bg-tertiary: #1a1a1a;
            --text-primary: #fff;
            --text-secondary: #888;
            --text-muted: #666;
            --accent-color: #00d4aa;
            --accent-secondary: #00ffcc;
            --border-color: #333;
            --hover-bg: #222;
            --card-bg: #111;
            --success-color: #22c55e;
            --warning-color: #f59e0b;
        }

        [data-theme="light"] {
            --bg-primary: #fff;
            --bg-secondary: #f8f9fa;
            --bg-tertiary: #e9ecef;
            --text-primary: #000;
            --text-secondary: #666;
            --text-muted: #999;
            --accent-color: #00b894;
            --accent-secondary: #00cec9;
            --border-color: #e1e5e9;
            --hover-bg: #f1f3f4;
            --card-bg: #fff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            overflow-x: hidden;
            transition: all 0.3s ease;
            line-height: 1.6;
        }

        .container {
            max-width: 430px;
            margin: 0 auto;
            min-height: 100vh;
            position: relative;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
            background: var(--bg-primary);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--bg-primary);
        }

        .username {
            font-size: 18px;
            font-weight: 700;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: var(--bg-secondary);
            color: var(--text-primary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            transform: scale(1.1);
            background: var(--hover-bg);
        }

        .menu-icon {
            display: flex;
            flex-direction: column;
            gap: 3px;
            cursor: pointer;
            padding: 5px;
        }

        .menu-line {
            width: 20px;
            height: 2px;
            background: var(--text-primary);
            transition: 0.3s ease;
        }

        .profile-section {
            padding: 30px 20px;
            text-align: center;
            background: var(--bg-primary);
        }

        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--accent-color), var(--accent-secondary));
            margin: 0 auto 20px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease;
            border: 4px solid var(--bg-primary);
            box-shadow: 0 0 20px rgba(0, 212, 170, 0.3);
        }

        .profile-pic:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .profile-pic::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            background: var(--bg-primary);
            border-radius: 50%;
        }

        .profile-pic::after {
            content: '👨‍💻';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 35px;
            z-index: 1;
        }

        .name {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .title {
            font-size: 16px;
            color: var(--text-secondary);
            margin-bottom: 15px;
        }

        .location {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .stats {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-bottom: 25px;
        }

        .stat {
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .stat:hover {
            transform: translateY(-2px);
        }

        .stat-number {
            font-size: 22px;
            font-weight: 700;
            background: linear-gradient(45deg, var(--accent-color), var(--accent-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .bio {
            font-size: 15px;
            line-height: 1.6;
            color: var(--text-primary);
            margin-bottom: 25px;
            padding: 0 10px;
        }

        .hashtags {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin-bottom: 25px;
        }

        .hashtag {
            background: var(--bg-secondary);
            color: var(--accent-color);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .hashtag:hover {
            background: var(--accent-color);
            color: var(--bg-primary);
            transform: translateY(-2px);
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 14px 32px;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            min-width: 120px;
        }

        .btn-primary {
            background: var(--accent-color);
            color: #fff;
        }

        .btn-secondary {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border: 2px solid var(--border-color);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .btn-primary:hover {
            background: var(--accent-secondary);
            box-shadow: 0 10px 20px rgba(0, 212, 170, 0.3);
        }

        .btn-secondary:hover {
            background: var(--hover-bg);
        }

        .tabs {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            background: var(--bg-primary);
            position: sticky;
            top: 71px;
            z-index: 99;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .tabs::-webkit-scrollbar {
            display: none;
        }

        .tab {
            flex: 1;
            padding: 18px 10px;
            text-align: center;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            color: var(--text-secondary);
            transition: all 0.3s ease;
            position: relative;
            white-space: nowrap;
            min-width: 80px;
        }

        .tab.active {
            color: var(--text-primary);
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 3px;
            background: var(--accent-color);
            border-radius: 3px;
        }

        .content {
            padding: 20px;
            background: var(--bg-primary);
        }

        .projects-content,
        .skills-content,
        .about-content,
        .contact-content {
            display: none;
        }

        .projects-content.active,
        .skills-content.active,
        .about-content.active,
        .contact-content.active {
            display: block;
        }

        .project-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 3px;
            margin-bottom: 30px;
        }

        .project-item {
            aspect-ratio: 1;
            background: var(--bg-secondary);
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .project-item:hover {
            transform: scale(1.05);
            z-index: 2;
        }

        .project-item:nth-child(1) { background: linear-gradient(45deg, var(--accent-color), var(--accent-secondary)); }
        .project-item:nth-child(2) { background: linear-gradient(45deg, #ff6b6b, #ee5a52); }
        .project-item:nth-child(3) { background: linear-gradient(45deg, #4ecdc4, #44a08d); }
        .project-item:nth-child(4) { background: linear-gradient(45deg, #45b7d1, #96c93d); }
        .project-item:nth-child(5) { background: linear-gradient(45deg, #f093fb, #f5576c); }
        .project-item:nth-child(6) { background: linear-gradient(45deg, #ffeaa7, #fab1a0); }

        .project-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            padding: 10px;
        }

        .project-item:hover .project-overlay {
            opacity: 1;
        }

        .project-title {
            color: #fff;
            font-weight: 700;
            font-size: 13px;
            text-align: center;
            margin-bottom: 5px;
        }

        .project-tech {
            color: #ccc;
            font-size: 10px;
            text-align: center;
        }

        .featured-projects {
            margin-top: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--text-primary);
        }

        .featured-project {
            background: var(--card-bg);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .featured-project:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .project-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .project-name {
            font-size: 16px;
            font-weight: 700;
        }

        .project-status {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
        }

        .status-live {
            background: var(--success-color);
            color: white;
        }

        .status-development {
            background: var(--warning-color);
            color: white;
        }

        .project-description {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.4;
            margin-bottom: 15px;
        }

        .project-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 15px;
        }

        .project-tag {
            background: var(--bg-secondary);
            color: var(--text-secondary);
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 11px;
        }

        .project-links {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .project-link {
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .link-demo {
            background: var(--accent-color);
            color: white;
        }

        .link-github {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .skills-category {
            margin-bottom: 30px;
        }

        .category-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .skill-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            margin-bottom: 10px;
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .skill-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .skill-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .skill-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            background: var(--bg-secondary);
        }

        .skill-details h4 {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 14px;
        }

        .skill-details p {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .skill-level {
            text-align: right;
        }

        .skill-percentage {
            font-size: 14px;
            color: var(--accent-color);
            font-weight: 700;
        }

        .skill-bar {
            width: 60px;
            height: 4px;
            background: var(--bg-secondary);
            border-radius: 2px;
            margin-top: 5px;
            overflow: hidden;
        }

        .skill-progress {
            height: 100%;
            background: linear-gradient(90deg, var(--accent-color), var(--accent-secondary));
            border-radius: 2px;
            transition: width 0.3s ease;
        }

        .about-section {
            margin-bottom: 30px;
        }

        .about-text {
            font-size: 15px;
            line-height: 1.7;
            color: var(--text-primary);
            margin-bottom: 20px;
        }

        .experience-item {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid var(--border-color);
        }

        .exp-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .exp-title {
            font-weight: 700;
            font-size: 16px;
        }

        .exp-company {
            color: var(--accent-color);
            font-size: 14px;
            margin-top: 2px;
        }

        .exp-date {
            font-size: 12px;
            color: var(--text-secondary);
            text-align: right;
        }

        .exp-description {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            margin-bottom: 10px;
            background: var(--card-bg);
            border-radius: 15px;
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .contact-icon.email { background: linear-gradient(45deg, var(--accent-color), var(--accent-secondary)); }
        .contact-icon.github { background: linear-gradient(45deg, #333, #555); }
        .contact-icon.whatsapp { background: linear-gradient(45deg, #25d366, #128c7e); }
        .contact-icon.location { background: linear-gradient(45deg, #ff6b6b, #ee5a52); }

        .contact-info {
            flex: 1;
        }

        .contact-info h4 {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 2px;
        }

        .contact-info p {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .achievement-badges {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 20px;
        }

        .badge {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 15px 10px;
            text-align: center;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .badge:hover {
            transform: scale(1.05);
        }

        .badge-icon {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .badge-title {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .badge-subtitle {
            font-size: 10px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .floating-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1000;
        }

        .particle {
            position: absolute;
            font-size: 16px;
            animation: float 4s ease-in-out infinite;
            opacity: 0;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }

        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--bg-primary);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.5s ease;
        }

        .loading.hide {
            opacity: 0;
            pointer-events: none;
        }

        .loader {
            width: 50px;
            height: 50px;
            border: 3px solid var(--border-color);
            border-top: 3px solid var(--accent-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .loading-text {
            margin-top: 20px;
            font-size: 14px;
            color: var(--text-secondary);
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ========== RESPONSIVE DESIGN ========== */

        /* Tablet Portrait (768px - 1024px) */
        @media (min-width: 768px) and (max-width: 1024px) {
            .container {
                max-width: 600px;
                box-shadow: 0 0 30px rgba(0,0,0,0.2);
            }
            
            .header {
                padding: 20px 30px;
            }
            
            .username {
                font-size: 20px;
            }
            
            .profile-section {
                padding: 40px 30px;
            }
            
            .profile-pic {
                width: 140px;
                height: 140px;
            }
            
            .profile-pic::after {
                font-size: 40px;
            }
            
            .name {
                font-size: 30px;
            }
            
            .title {
                font-size: 18px;
            }
            
            .stats {
                gap: 60px;
            }
            
            .stat-number {
                font-size: 26px;
            }
            
            .stat-label {
                font-size: 14px;
            }
            
            .bio {
                font-size: 16px;
                max-width: 500px;
                margin: 0 auto 25px;
            }
            
            .project-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 8px;
            }
            
            .content {
                padding: 30px;
            }
            
            .featured-project {
                padding: 25px;
            }
            
            .skill-item {
                padding: 18px 25px;
            }
            
            .contact-item {
                padding: 25px;
            }
            
            .achievement-badges {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* Laptop (1025px - 1440px) */
        @media (min-width: 1025px) and (max-width: 1440px) {
            .container {
                max-width: 800px;
                box-shadow: 0 0 40px rgba(0,0,0,0.15);
                border-radius: 20px;
                overflow: hidden;
                margin: 20px auto;
            }
            
            .header {
                padding: 25px 40px;
                border-radius: 20px 20px 0 0;
            }
            
            .username {
                font-size: 22px;
            }
            
            .theme-toggle {
                width: 45px;
                height: 45px;
                font-size: 18px;
            }
            
            .profile-section {
                padding: 50px 40px;
            }
            
            .profile-pic {
                width: 160px;
                height: 160px;
            }
            
            .profile-pic::before {
                width: 60px;
                height: 60px;
            }
            
            .profile-pic::after {
                font-size: 45px;
            }
            
            .name {
                font-size: 34px;
                margin-bottom: 12px;
            }
            
            .title {
                font-size: 20px;
                margin-bottom: 18px;
            }
            
            .location {
                font-size: 16px;
                margin-bottom: 25px;
            }
            
            .stats {
                gap: 80px;
                margin-bottom: 35px;
            }
            
            .stat-number {
                font-size: 28px;
            }
            
            .stat-label {
                font-size: 15px;
            }
            
            .bio {
                font-size: 17px;
                max-width: 600px;
                margin: 0 auto 30px;
                line-height: 1.7;
            }
            
            .hashtags {
                gap: 12px;
                margin-bottom: 35px;
            }
            
            .hashtag {
                padding: 8px 16px;
                font-size: 13px;
            }
            
            .action-buttons {
                gap: 15px;
                margin-bottom: 40px;
            }
            
            .btn {
                padding: 16px 40px;
                font-size: 15px;
                min-width: 140px;
            }
            
            .tab {
                padding: 20px 15px;
                font-size: 15px;
                min-width: 100px;
            }
            
            .content {
                padding: 40px;
            }
            
            .project-grid {
                grid-template-columns: repeat(5, 1fr);
                gap: 12px;
                margin-bottom: 40px;
            }
            
            .project-title {
                font-size: 14px;
            }
            
            .project-tech {
                font-size: 11px;
            }
            
            .section-title {
                font-size: 20px;
                margin-bottom: 20px;
            }
            
            .featured-project {
                padding: 30px;
                margin-bottom: 20px;
            }
            
            .project-name {
                font-size: 18px;
            }
            
            .project-description {
                font-size: 15px;
                line-height: 1.5;
            }
            
            .project-links {
                gap: 15px;
            }
            
            .project-link {
                padding: 10px 20px;
                font-size: 13px;
            }
            
            .skills-category {
                margin-bottom: 40px;
            }
            
            .category-title {
                font-size: 18px;
                margin-bottom: 20px;
            }
            
            .skill-item {
                padding: 20px 25px;
                margin-bottom: 12px;
            }
            
            .skill-icon {
                width: 45px;
                height: 45px;
                font-size: 20px;
            }
            
            .skill-details h4 {
                font-size: 15px;
            }
            
            .skill-details p {
                font-size: 13px;
            }
            
            .skill-bar {
                width: 80px;
                height: 5px;
            }
            
            .skill-percentage {
                font-size: 15px;
            }
            
            .about-text {
                font-size: 16px;
                line-height: 1.8;
            }
            
            .experience-item {
                padding: 25px;
                margin-bottom: 20px;
            }
            
            .exp-title {
                font-size: 17px;
            }
            
            .exp-company {
                font-size: 15px;
            }
            
            .exp-date {
                font-size: 13px;
            }
            
            .exp-description {
                font-size: 15px;
                line-height: 1.6;
            }
            
            .contact-item {
                padding: 25px 30px;
                margin-bottom: 15px;
            }
            
            .contact-icon {
                width: 55px;
                height: 55px;
                font-size: 22px;
            }
            
            .contact-info h4 {
                font-size: 17px;
            }
            
            .contact-info p {
                font-size: 14px;
            }
            
            .achievement-badges {
                grid-template-columns: repeat(4, 1fr);
                gap: 15px;
            }
            
            .badge {
                padding: 20px 15px;
            }
            
            .badge-icon {
                font-size: 28px;
                margin-bottom: 10px;
            }
            
            .badge-title {
                font-size: 13px;
            }
            
            .badge-subtitle {
                font-size: 11px;
            }
        }

        /* Desktop (1441px - 1920px) */
        @media (min-width: 1441px) and (max-width: 1920px) {
            body {
                background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
                min-height: 100vh;
                padding: 30px 0;
            }
            
            .container {
                max-width: 1000px;
                box-shadow: 0 0 60px rgba(0,0,0,0.1);
                border-radius: 25px;
                overflow: hidden;
                margin: 0 auto;
                background: var(--bg-primary);
            }
            
            .header {
                padding: 30px 50px;
                border-radius: 25px 25px 0 0;
            }
            
            .username {
                font-size: 24px;
            }
            
            .theme-toggle {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
            
            .header-actions {
                gap: 20px;
            }
            
            .profile-section {
                padding: 60px 50px;
                background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
            }
            
            .profile-pic {
                width: 180px;
                height: 180px;
                margin-bottom: 25px;
                box-shadow: 0 0 30px rgba(0, 212, 170, 0.4);
            }
            
            .profile-pic::before {
                width: 70px;
                height: 70px;
            }
            
            .profile-pic::after {
                font-size: 50px;
            }
            
            .name {
                font-size: 38px;
                margin-bottom: 15px;
            }
            
            .title {
                font-size: 22px;
                margin-bottom: 20px;
            }
            
            .location {
                font-size: 18px;
                margin-bottom: 30px;
            }
            
            .stats {
                gap: 100px;
                margin-bottom: 40px;
            }
            
            .stat-number {
                font-size: 32px;
            }
            
            .stat-label {
                font-size: 16px;
            }
            
            .bio {
                font-size: 18px;
                max-width: 700px;
                margin: 0 auto 35px;
                line-height: 1.8;
            }
            
            .hashtags {
                gap: 15px;
                margin-bottom: 40px;
            }
            
            .hashtag {
                padding: 10px 20px;
                font-size: 14px;
                border-radius: 25px;
            }
            
            .action-buttons {
                gap: 20px;
                margin-bottom: 50px;
            }
            
            .btn {
                padding: 18px 50px;
                font-size: 16px;
                min-width: 160px;
                border-radius: 30px;
            }
            
            .tabs {
                top: 111px;
            }
            
            .tab {
                padding: 25px 20px;
                font-size: 16px;
                min-width: 120px;
            }
            
            .tab.active::after {
                width: 50px;
                height: 4px;
            }
            
            .content {
                padding: 50px;
            }
            
            .project-grid {
                grid-template-columns: repeat(6, 1fr);
                gap: 15px;
                margin-bottom: 50px;
            }
            
            .project-item {
                border-radius: 12px;
            }
            
            .project-title {
                font-size: 15px;
                margin-bottom: 8px;
            }
            
            .project-tech {
                font-size: 12px;
            }
            
            .section-title {
                font-size: 22px;
                margin-bottom: 25px;
            }
            
            .featured-project {
                padding: 35px;
                margin-bottom: 25px;
                border-radius: 20px;
            }
            
            .project-name {
                font-size: 20px;
            }
            
            .project-status {
                padding: 6px 12px;
                font-size: 11px;
            }
            
            .project-description {
                font-size: 16px;
                line-height: 1.6;
                margin-bottom: 20px;
            }
            
            .project-tag {
                padding: 6px 10px;
                font-size: 12px;
                border-radius: 10px;
            }
            
            .project-links {
                gap: 18px;
            }
            
            .project-link {
                padding: 12px 24px;
                font-size: 14px;
                border-radius: 25px;
            }
            
            .skills-category {
                margin-bottom: 45px;
            }
            
            .category-title {
                font-size: 20px;
                margin-bottom: 25px;
            }
            
            .skill-item {
                padding: 25px 30px;
                margin-bottom: 15px;
                border-radius: 15px;
            }
            
            .skill-icon {
                width: 50px;
                height: 50px;
                font-size: 22px;
                border-radius: 12px;
            }
            
            .skill-details h4 {
                font-size: 16px;
            }
            
            .skill-details p {
                font-size: 14px;
            }
            
            .skill-bar {
                width: 100px;
                height: 6px;
            }
            
            .skill-percentage {
                font-size: 16px;
            }
            
            .about-section {
                margin-bottom: 40px;
            }
            
            .about-text {
                font-size: 17px;
                line-height: 1.9;
                margin-bottom: 25px;
            }
            
            .experience-item {
                padding: 30px;
                margin-bottom: 25px;
                border-radius: 15px;
            }
            
            .exp-title {
                font-size: 18px;
            }
            
            .exp-company {
                font-size: 16px;
            }
            
            .exp-date {
                font-size: 14px;
            }
            
            .exp-description {
                font-size: 16px;
                line-height: 1.7;
            }
            
            .contact-item {
                padding: 30px 35px;
                margin-bottom: 18px;
                border-radius: 20px;
            }
            
            .contact-icon {
                width: 60px;
                height: 60px;
                font-size: 24px;
                border-radius: 18px;
            }
            
            .contact-info h4 {
                font-size: 18px;
                margin-bottom: 5px;
            }
            
            .contact-info p {
                font-size: 15px;
            }
            
            .achievement-badges {
                grid-template-columns: repeat(4, 1fr);
                gap: 20px;
                margin-top: 30px;
            }
            
            .badge {
                padding: 25px 20px;
                border-radius: 15px;
            }
            
            .badge-icon {
                font-size: 32px;
                margin-bottom: 12px;
            }
            
            .badge-title {
                font-size: 14px;
            }
            
            .badge-subtitle {
                font-size: 12px;
            }
        }

        /* Large Desktop (1921px+) */
        @media (min-width: 1921px) {
            body {
                padding: 40px 0;
            }
            
            .container {
                max-width: 1200px;
                border-radius: 30px;
                box-shadow: 0 0 80px rgba(0,0,0,0.1);
            }
            
            .header {
                padding: 35px 60px;
                border-radius: 30px 30px 0 0;
            }
            
            .username {
                font-size: 26px;
            }
            
            .theme-toggle {
                width: 55px;
                height: 55px;
                font-size: 22px;
            }
            
            .profile-section {
                padding: 70px 60px;
            }
            
            .profile-pic {
                width: 200px;
                height: 200px;
                margin-bottom: 30px;
            }
            
            .profile-pic::before {
                width: 80px;
                height: 80px;
            }
            
            .profile-pic::after {
                font-size: 55px;
            }
            
            .name {
                font-size: 42px;
                margin-bottom: 18px;
            }
            
            .title {
                font-size: 24px;
                margin-bottom: 25px;
            }
            
            .location {
                font-size: 20px;
                margin-bottom: 35px;
            }
            
            .stats {
                gap: 120px;
                margin-bottom: 45px;
            }
            
            .stat-number {
                font-size: 36px;
            }
            
            .stat-label {
                font-size: 18px;
            }
            
            .bio {
                font-size: 20px;
                max-width: 800px;
                margin: 0 auto 40px;
                line-height: 1.9;
            }
            
            .hashtag {
                padding: 12px 24px;
                font-size: 15px;
            }
            
            .btn {
                padding: 20px 60px;
                font-size: 17px;
                min-width: 180px;
            }
            
            .tab {
                padding: 28px 25px;
                font-size: 17px;
                min-width: 140px;
            }
            
            .content {
                padding: 60px;
            }
            
            .project-grid {
                grid-template-columns: repeat(6, 1fr);
                gap: 18px;
            }
            
            .section-title {
                font-size: 24px;
                margin-bottom: 30px;
            }
            
            .featured-project {
                padding: 40px;
                margin-bottom: 30px;
            }
            
            .project-name {
                font-size: 22px;
            }
            
            .project-description {
                font-size: 17px;
                line-height: 1.7;
            }
            
            .skill-item {
                padding: 30px 35px;
                margin-bottom: 18px;
            }
            
            .skill-icon {
                width: 55px;
                height: 55px;
                font-size: 24px;
            }
            
            .contact-item {
                padding: 35px 40px;
                margin-bottom: 20px;
            }
            
            .contact-icon {
                width: 65px;
                height: 65px;
                font-size: 26px;
            }
        }

        /* Small Mobile Improvements */
        @media (max-width: 375px) {
            .header {
                padding: 12px 15px;
            }
            
            .username {
                font-size: 16px;
            }
            
            .theme-toggle {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }
            
            .profile-section {
                padding: 25px 15px;
            }
            
            .profile-pic {
                width: 100px;
                height: 100px;
            }
            
            .profile-pic::after {
                font-size: 28px;
            }
            
            .name {
                font-size: 22px;
            }
            
            .title {
                font-size: 14px;
            }
            
            .stats {
                gap: 30px;
            }
            
            .stat-number {
                font-size: 18px;
            }
            
            .stat-label {
                font-size: 11px;
            }
            
            .bio {
                font-size: 13px;
                padding: 0 5px;
            }
            
            .hashtag {
                padding: 5px 10px;
                font-size: 11px;
            }
            
            .btn {
                padding: 12px 24px;
                font-size: 12px;
                min-width: 100px;
            }
            
            .tab {
                padding: 15px 8px;
                font-size: 12px;
                min-width: 60px;
            }
            
            .content {
                padding: 15px;
            }
            
            .project-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 5px;
            }
            
            .project-title {
                font-size: 11px;
            }
            
            .project-tech {
                font-size: 9px;
            }
            
            .featured-project {
                padding: 15px;
            }
            
            .project-name {
                font-size: 14px;
            }
            
            .project-description {
                font-size: 12px;
            }
            
            .project-tag {
                font-size: 10px;
            }
            
            .skill-item {
                padding: 12px 15px;
            }
            
            .skill-icon {
                width: 35px;
                height: 35px;
                font-size: 16px;
            }
            
            .skill-details h4 {
                font-size: 12px;
            }
            
            .skill-details p {
                font-size: 10px;
            }
            
            .contact-item {
                padding: 15px;
            }
            
            .contact-icon {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }
            
            .contact-info h4 {
                font-size: 14px;
            }
            
            .contact-info p {
                font-size: 11px;
            }
            
            .achievement-badges {
                grid-template-columns: repeat(1, 1fr);
            }
        }

        /* Landscape Mobile */
        @media (max-height: 500px) and (orientation: landscape) {
            .profile-section {
                padding: 20px;
            }
            
            .profile-pic {
                width: 80px;
                height: 80px;
            }
            
            .profile-pic::after {
                font-size: 24px;
            }
            
            .name {
                font-size: 20px;
                margin-bottom: 5px;
            }
            
            .title {
                font-size: 13px;
                margin-bottom: 10px;
            }
            
            .stats {
                gap: 25px;
                margin-bottom: 15px;
            }
            
            .bio {
                font-size: 12px;
                margin-bottom: 15px;
            }
            
            .hashtags {
                margin-bottom: 15px;
            }
            
            .action-buttons {
                margin-bottom: 20px;
            }
        }

        /* Print Styles */
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
            
            body {
                background: white !important;
                color: black !important;
            }
            
            .container {
                box-shadow: none !important;
                max-width: none !important;
                margin: 0 !important;
            }
            
            .header {
                border-bottom: 2px solid #333 !important;
            }
            
            .theme-toggle,
            .menu-icon,
            .floating-particles,
            .loading {
                display: none !important;
            }
            
            .tabs {
                display: none !important;
            }
            
            .content {
                display: block !important;
            }
            
            .projects-content,
            .skills-content,
            .about-content,
            .contact-content {
                display: block !important;
                page-break-inside: avoid;
            }
            
            .featured-project,
            .skill-item,
            .experience-item,
            .contact-item {
                page-break-inside: avoid;
                border: 1px solid #333 !important;
            }
        }

        /* High Contrast Mode */
        @media (prefers-contrast: high) {
            :root {
                --border-color: #555;
                --text-secondary: #ccc;
            }
            
            .project-item,
            .featured-project,
            .skill-item,
            .experience-item,
            .contact-item,
            .badge {
                border: 2px solid var(--border-color) !important;
            }
        }

        /* Reduced Motion */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
            
            .floating-particles {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <!-- Demo content for visualization -->
    <div class="container">
        <div class="header">
            <div class="username">@portfolio</div>
            <div class="header-actions">
                <button class="theme-toggle">🌙</button>
                <div class="menu-icon">
                    <div class="menu-line"></div>
                    <div class="menu-line"></div>
                    <div class="menu-line"></div>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <div class="profile-pic"></div>
            <div class="name">John Developer</div>
            <div class="title">Full Stack Developer</div>
            <div class="location">📍 Jakarta, Indonesia</div>
            
            <div class="stats">
                <div class="stat">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Projects</div>
                </div>
                <div class="stat">
                    <div class="stat-number">3</div>
                    <div class="stat-label">Years Exp</div>
                </div>
                <div class="stat">
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Clients</div>
                </div>
            </div>

            <div class="bio">
                Passionate developer creating amazing digital experiences with modern technologies. 
                Always eager to learn and implement cutting-edge solutions.
            </div>

            <div class="hashtags">
                <span class="hashtag">#JavaScript</span>
                <span class="hashtag">#React</span>
                <span class="hashtag">#Node.js</span>
                <span class="hashtag">#Python</span>
            </div>

            <div class="action-buttons">
                <button class="btn btn-primary">Follow</button>
                <button class="btn btn-secondary">Message</button>
            </div>
        </div>

        <div class="tabs">
            <div class="tab active">Projects</div>
            <div class="tab">Skills</div>
            <div class="tab">About</div>
            <div class="tab">Contact</div>
        </div>

        <div class="content">
            <div class="projects-content active">
                <div class="project-grid">
                    <div class="project-item">
                        <div class="project-overlay">
                            <div class="project-title">E-Commerce App</div>
                            <div class="project-tech">React, Node.js</div>
                        </div>
                    </div>
                    <div class="project-item">
                        <div class="project-overlay">
                            <div class="project-title">Portfolio Site</div>
                            <div class="project-tech">HTML, CSS, JS</div>
                        </div>
                    </div>
                    <div class="project-item">
                        <div class="project-overlay">
                            <div class="project-title">Mobile App</div>
                            <div class="project-tech">React Native</div>
                        </div>
                    </div>
                    <div class="project-item">
                        <div class="project-overlay">
                            <div class="project-title">Dashboard</div>
                            <div class="project-tech">Vue.js</div>
                        </div>
                    </div>
                    <div class="project-item">
                        <div class="project-overlay">
                            <div class="project-title">API Service</div>
                            <div class="project-tech">Python, FastAPI</div>
                        </div>
                    </div>
                    <div class="project-item">
                        <div class="project-overlay">
                            <div class="project-title">Chat App</div>
                            <div class="project-tech">Socket.io</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Theme toggle functionality
        const themeToggle = document.querySelector('.theme-toggle');
        const body = document.body;

        themeToggle.addEventListener('click', () => {
            body.dataset.theme = body.dataset.theme === 'light' ? 'dark' : 'light';
            themeToggle.textContent = body.dataset.theme === 'light' ? '🌞' : '🌙';
        });

        // Tab functionality
        const tabs = document.querySelectorAll('.tab');
        const contents = document.querySelectorAll('[class$="-content"]');

        tabs.forEach((tab, index) => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                contents.forEach(c => c.classList.remove('active'));
                
                tab.classList.add('active');
                contents[index].classList.add('active');
            });
        });
    </script>
</body>
</html>