<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Profile - Dashboard Editor</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            background: #0a0a0a;
            color: #ffffff;
            overflow-x: hidden;
        }

        /* Dashboard Styles */
        .dashboard {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100vh;
            background: rgba(20, 20, 20, 0.95);
            backdrop-filter: blur(20px);
            border-left: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 1000;
            transition: right 0.3s ease;
            overflow-y: auto;
        }

        .dashboard.active {
            right: 0;
        }

        .dashboard-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-header h3 {
            color: #00d4aa;
            font-weight: 600;
        }

        .close-dashboard {
            background: none;
            border: none;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
        }

        .dashboard-content {
            padding: 20px;
        }

        .edit-section {
            margin-bottom: 30px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .edit-section h4 {
            color: #00d4aa;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #ccc;
            font-size: 14px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .color-picker {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .color-option {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .color-option.active {
            border-color: #00d4aa;
            transform: scale(1.1);
        }

        /* Toggle Dashboard Button */
        .dashboard-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #00d4aa;
            color: #000;
            border: none;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            font-size: 24px;
            cursor: pointer;
            z-index: 999;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 212, 170, 0.3);
        }

        .dashboard-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 30px rgba(0, 212, 170, 0.5);
        }

        /* Header */
        .header {
            background: rgba(10, 10, 10, 0.9);
            backdrop-filter: blur(20px);
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 998;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: #00d4aa;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links a:hover {
            color: #00d4aa;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #00d4aa;
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-circle at center, rgba(0, 212, 170, 0.1) 0%, transparent 70%;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                linear-gradient(45deg, transparent 49%, rgba(255, 255, 255, 0.01) 50%, transparent 51%),
                linear-gradient(-45deg, transparent 49%, rgba(255, 255, 255, 0.01) 50%, transparent 51%);
            background-size: 60px 60px;
            animation: grid-move 20s linear infinite;
        }

        @keyframes grid-move {
            0% { transform: translate(0, 0); }
            100% { transform: translate(60px, 60px); }
        }

        .hero-content {
            text-align: center;
            max-width: 800px;
            padding: 0 2rem;
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: #ccc;
            line-height: 1.6;
        }

        .cta-button {
            display: inline-block;
            padding: 15px 30px;
            background: #00d4aa;
            color: #000;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 212, 170, 0.3);
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 212, 170, 0.5);
        }

        /* Sections */
        .section {
            padding: 100px 0;
            max-width: 1200px;
            margin: 0 auto;
            padding-left: 2rem;
            padding-right: 2rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 3rem;
            color: #00d4aa;
        }

        .about-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
            align-items: center;
        }

        .about-text h3 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .about-text p {
            color: #ccc;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .stat-item {
            text-align: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.08);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #00d4aa;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #ccc;
            font-weight: 500;
        }

        /* Services */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .service-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 2.5rem 2rem;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(0, 212, 170, 0.3);
        }

        .service-icon {
            font-size: 3rem;
            color: #00d4aa;
            margin-bottom: 1.5rem;
        }

        .service-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .service-card p {
            color: #ccc;
            line-height: 1.6;
        }

        /* Team */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .team-member {
            text-align: center;
            background: rgba(255, 255, 255, 0.05);
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .team-member:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.08);
        }

        .team-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(0, 212, 170, 0.2);
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #00d4aa;
        }

        .team-name {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #fff;
        }

        .team-role {
            color: #00d4aa;
            font-weight: 500;
        }

        /* Contact */
        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
        }

        .contact-info {
            background: rgba(255, 255, 255, 0.05);
            padding: 2.5rem;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background: rgba(0, 212, 170, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #00d4aa;
            margin-right: 1rem;
        }

        /* Footer */
        .footer {
            background: rgba(255, 255, 255, 0.05);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem 0;
            text-align: center;
            color: #ccc;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard {
                width: 100%;
                right: -100%;
            }

            .nav-links {
                display: none;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .section {
                padding: 60px 0;
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(0, 212, 170, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
    </style>
</head>
<body>
    <div class="floating-elements">
        <div class="floating-circle" style="width: 100px; height: 100px; top: 10%; left: 10%; animation-delay: 0s;"></div>
        <div class="floating-circle" style="width: 60px; height: 60px; top: 20%; right: 20%; animation-delay: 2s;"></div>
        <div class="floating-circle" style="width: 80px; height: 80px; bottom: 30%; left: 15%; animation-delay: 4s;"></div>
        <div class="floating-circle" style="width: 40px; height: 40px; bottom: 10%; right: 10%; animation-delay: 1s;"></div>
    </div>

    <button class="dashboard-toggle" onclick="toggleDashboard()">
        <i class="fas fa-edit"></i>
    </button>

    <div class="dashboard" id="dashboard">
        <div class="dashboard-header">
            <h3>Edit Company Profile</h3>
            <button class="close-dashboard" onclick="toggleDashboard()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="dashboard-content">
            <div class="edit-section">
                <h4>Company Info</h4>
                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" id="companyName" value="TechInnovate Solutions" onchange="updateContent()">
                </div>
                <div class="form-group">
                    <label>Tagline</label>
                    <input type="text" id="tagline" value="Inovasi Digital untuk Masa Depan" onchange="updateContent()">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea id="description" onchange="updateContent()">Kami adalah perusahaan teknologi terdepan yang menghadirkan solusi digital inovatif untuk transformasi bisnis modern.</textarea>
                </div>
            </div>

            <div class="edit-section">
                <h4>About Section</h4>
                <div class="form-group">
                    <label>About Title</label>
                    <input type="text" id="aboutTitle" value="Tentang Perusahaan" onchange="updateContent()">
                </div>
                <div class="form-group">
                    <label>About Content</label>
                    <textarea id="aboutContent" onchange="updateContent()">Dengan pengalaman lebih dari 10 tahun dalam industri teknologi, kami telah membantu ratusan perusahaan dalam transformasi digital mereka. Tim ahli kami terdiri dari developer, designer, dan consultant berpengalaman yang siap memberikan solusi terbaik.</textarea>
                </div>
            </div>

            <div class="edit-section">
                <h4>Statistics</h4>
                <div class="form-group">
                    <label>Projects Completed</label>
                    <input type="text" id="projects" value="500+" onchange="updateContent()">
                </div>
                <div class="form-group">
                    <label>Happy Clients</label>
                    <input type="text" id="clients" value="250+" onchange="updateContent()">
                </div>
                <div class="form-group">
                    <label>Years Experience</label>
                    <input type="text" id="experience" value="10+" onchange="updateContent()">
                </div>
                <div class="form-group">
                    <label>Team Members</label>
                    <input type="text" id="team" value="50+" onchange="updateContent()">
                </div>
            </div>

            <div class="edit-section">
                <h4>Contact Information</h4>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" id="email" value="info@techinnovate.com" onchange="updateContent()">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" id="phone" value="+62 21 1234 5678" onchange="updateContent()">
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" id="address" value="Jakarta, Indonesia" onchange="updateContent()">
                </div>
            </div>

            <div class="edit-section">
                <h4>Accent Color</h4>
                <div class="color-picker">
                    <div class="color-option active" style="background: #00d4aa;" onclick="changeAccentColor('#00d4aa')"></div>
                    <div class="color-option" style="background: #ff6b6b;" onclick="changeAccentColor('#ff6b6b')"></div>
                    <div class="color-option" style="background: #4ecdc4;" onclick="changeAccentColor('#4ecdc4')"></div>
                    <div class="color-option" style="background: #45b7d1;" onclick="changeAccentColor('#45b7d1')"></div>
                    <div class="color-option" style="background: #f9ca24;" onclick="changeAccentColor('#f9ca24')"></div>
                    <div class="color-option" style="background: #6c5ce7;" onclick="changeAccentColor('#6c5ce7')"></div>
                </div>
            </div>
        </div>
    </div>

    <header class="header">
        <nav class="nav-container">
            <a href="#" class="logo" id="logoText">TechInnovate</a>
            <ul class="nav-links">
                <li><a href="#hero">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#team">Team</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero" id="hero">
        <div class="hero-content">
            <h1 id="heroTitle">TechInnovate Solutions</h1>
            <p id="heroSubtitle">Inovasi Digital untuk Masa Depan</p>
            <p id="heroDescription">Kami adalah perusahaan teknologi terdepan yang menghadirkan solusi digital inovatif untuk transformasi bisnis modern.</p>
            <a href="#contact" class="cta-button">Hubungi Kami</a>
        </div>
    </section>

    <section class="section" id="about">
        <h2 class="section-title" id="aboutSectionTitle">Tentang Perusahaan</h2>
        <div class="about-grid">
            <div class="about-text">
                <h3>Visi & Misi</h3>
                <p id="aboutText">Dengan pengalaman lebih dari 10 tahun dalam industri teknologi, kami telah membantu ratusan perusahaan dalam transformasi digital mereka. Tim ahli kami terdiri dari developer, designer, dan consultant berpengalaman yang siap memberikan solusi terbaik.</p>
            </div>
            <div class="stats">
                <div class="stat-item">
                    <div class="stat-number" id="projectsNumber">500+</div>
                    <div class="stat-label">Projects Completed</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="clientsNumber">250+</div>
                    <div class="stat-label">Happy Clients</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="experienceNumber">10+</div>
                    <div class="stat-label">Years Experience</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="teamNumber">50+</div>
                    <div class="stat-label">Team Members</div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="services">
        <h2 class="section-title">Our Services</h2>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-code"></i></div>
                <h3>Web Development</h3>
                <p>Pengembangan website modern dan responsive dengan teknologi terdepan untuk kebutuhan bisnis Anda.</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-mobile-alt"></i></div>
                <h3>Mobile App Development</h3>
                <p>Aplikasi mobile native dan cross-platform untuk iOS dan Android dengan performa optimal.</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-cloud"></i></div>
                <h3>Cloud Solutions</h3>
                <p>Migrasi dan pengelolaan infrastruktur cloud untuk skalabilitas dan efisiensi maksimal.</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-chart-line"></i></div>
                <h3>Digital Marketing</h3>
                <p>Strategi pemasaran digital yang terintegrasi untuk meningkatkan visibility dan konversi.</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-shield-alt"></i></div>
                <h3>Cybersecurity</h3>
                <p>Solusi keamanan siber komprehensif untuk melindungi aset digital perusahaan Anda.</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-brain"></i></div>
                <h3>AI & Machine Learning</h3>
                <p>Implementasi kecerdasan buatan untuk otomatisasi dan optimalisasi proses bisnis.</p>
            </div>
        </div>
    </section>

    <section class="section" id="team">
        <h2 class="section-title">Our Team</h2>
        <div class="team-grid">
            <div class="team-member">
                <div class="team-avatar"><i class="fas fa-user"></i></div>
                <div class="team-name">John Doe</div>
                <div class="team-role">CEO & Founder</div>
            </div>
            <div class="team-member">
                <div class="team-avatar"><i class="fas fa-user"></i></div>
                <div class="team-name">Jane Smith</div>
                <div class="team-role">CTO</div>
            </div>
            <div class="team-member">
                <div class="team-avatar"><i class="fas fa-user"></i></div>
                <div class="team-name">Mike Johnson</div>
                <div class="team-role">Lead Developer</div>
            </div>
            <div class="team-member">
                <div class="team-avatar"><i class="fas fa-user"></i></div>
                <div class="team-name">Sarah Wilson</div>
                <div class="team-role">UI/UX Designer</div>
            </div>
        </div>
    </section>

    <section class="section" id="contact">
        <h2 class="section-title">Contact Us</h2>
        <div class="contact-grid">
            <div class="contact-info">
                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <h4>Email</h4>
                        <p id="contactEmail">info@techinnovate.com</p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <h4>Phone</h4>
                        <p id="contactPhone">+62 21 1234 5678</p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <h4>Address</h4>
                        <p id="contactAddress">Jakarta, Indonesia</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2024 <span id="footerCompany">TechInnovate Solutions</span>. All rights reserved.</p>
    </footer>

    <script>
        let currentAccentColor = '#00d4aa';

        function toggleDashboard() {
            const dashboard = document.getElementById('dashboard');
            dashboard.classList.toggle('active');
        }

        function updateContent() {
            // Company Info
            const companyName = document.getElementById('companyName').value;
            const tagline = document.getElementById('tagline').value;
            const description = document.getElementById('description').value;

            document.getElementById('logoText').textContent = companyName;
            document.getElementById('heroTitle').textContent = companyName;
            document.getElementById('heroSubtitle').textContent = tagline;
            document.getElementById('heroDescription').textContent = description;
            document.getElementById('footerCompany').textContent = companyName;

            // About Section
            const aboutTitle = document.getElementById('aboutTitle').value;
            const aboutContent = document.getElementById('aboutContent').value;

            document.getElementById('aboutSectionTitle').textContent = aboutTitle;
            document.getElementById('aboutText').textContent = aboutContent;

            // Statistics
            document.getElementById('projectsNumber').textContent = document.getElementById('projects').value;
            document.getElementById('clientsNumber').textContent = document.getElementById('clients').value;
            document.getElementById('experienceNumber').textContent = document.getElementById('experience').value;
            document.getElementById('teamNumber').textContent = document.getElementById('team').value;

            // Contact Information
            document.getElementById('contactEmail').textContent = document.getElementById('email').value;
            document.getElementById('contactPhone').textContent = document.getElementById('phone').value;
            document.getElementById('contactAddress').textContent = document.getElementById('address').value;
        }

        function changeAccentColor(color) {
            currentAccentColor = color;
            
            // Update active color picker
            document.querySelectorAll('.color-option').forEach(option => {
                option.classList.remove('active');
            });
            event.target.classList.add('active');

            // Update CSS variables
            const root = document.documentElement;
            document.querySelectorAll('.section-title, .logo, .nav-links a:hover, .team-role, .stat-number, .service-icon').forEach(element => {
                element.style.color = color;
            });

            document.querySelectorAll('.cta-button, .dashboard-toggle').forEach(element => {
                element.style.backgroundColor = color;
            });

            document.querySelectorAll('.nav-links a::after').forEach(element => {
                element.style.backgroundColor = color;
            });

            // Update floating circles and other accent elements
            document.querySelectorAll('.floating-circle').forEach(circle => {
                circle.style.background = color.replace(')', ', 0.1)').replace('rgb', 'rgba').replace('#', 'rgba(') + 
                    parseInt(color.slice(1, 3), 16) + ',' + 
                    parseInt(color.slice(3, 5), 16) + ',' + 
                    parseInt(color.slice(5, 7), 16) + ', 0.1)';
            });

            document.querySelectorAll('.team-avatar, .contact-icon').forEach(element => {
                element.style.background = color.replace(')', ', 0.2)').replace('rgb', 'rgba').replace('#', 'rgba(') + 
                    parseInt(color.slice(1, 3), 16) + ',' + 
                    parseInt(color.slice(3, 5), 16) + ',' + 
                    parseInt(color.slice(5, 7), 16) + ', 0.2)';
                element.style.color = color;
            });

            // Update hover effects dynamically
            const style = document.createElement('style');
            style.innerHTML = `
                .nav-links a:hover { color: ${color} !important; }
                .nav-links a::after { background: ${color} !important; }
                .service-card:hover { border-color: ${color}33 !important; }
                .cta-button:hover { box-shadow: 0 8px 30px ${color}80 !important; }
                .dashboard-toggle { box-shadow: 0 4px 20px ${color}4d !important; }
                .dashboard-toggle:hover { box-shadow: 0 6px 30px ${color}80 !important; }
                .color-option.active { border-color: ${color} !important; }
            `;
            document.head.appendChild(style);
        }

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Close dashboard when clicking outside
        document.addEventListener('click', function(e) {
            const dashboard = document.getElementById('dashboard');
            const toggleButton = document.querySelector('.dashboard-toggle');
            
            if (!dashboard.contains(e.target) && !toggleButton.contains(e.target) && dashboard.classList.contains('active')) {
                dashboard.classList.remove('active');
            }
        });

        // Parallax effect for floating elements
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = scrolled * 0.5;
            
            document.querySelectorAll('.floating-circle').forEach((circle, index) => {
                const speed = 0.5 + (index * 0.1);
                circle.style.transform = `translateY(${scrolled * speed}px) rotate(${scrolled * 0.1}deg)`;
            });
        });

        // Initialize content on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateContent();
            
            // Add some interactive animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all sections for scroll animations
            document.querySelectorAll('.section, .service-card, .team-member, .stat-item').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });
        });

        // Add typing effect to hero title
        function typeWriter(element, text, speed = 50) {
            let i = 0;
            element.textContent = '';
            
            function type() {
                if (i < text.length) {
                    element.textContent += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                }
            }
            
            type();
        }

        // Add some dynamic interactions
        document.addEventListener('mousemove', (e) => {
            const cursor = { x: e.clientX, y: e.clientY };
            const floatingElements = document.querySelectorAll('.floating-circle');
            
            floatingElements.forEach((element, index) => {
                const rect = element.getBoundingClientRect();
                const elementCenter = {
                    x: rect.left + rect.width / 2,
                    y: rect.top + rect.height / 2
                };
                
                const distance = Math.sqrt(
                    Math.pow(cursor.x - elementCenter.x, 2) + 
                    Math.pow(cursor.y - elementCenter.y, 2)
                );
                
                if (distance < 200) {
                    const angle = Math.atan2(cursor.y - elementCenter.y, cursor.x - elementCenter.x);
                    const force = (200 - distance) / 200;
                    const moveX = Math.cos(angle) * force * 20;
                    const moveY = Math.sin(angle) * force * 20;
                    
                    element.style.transform += ` translate(${moveX}px, ${moveY}px)`;
                }
            });
        });

        // Add click ripple effect to buttons
        function createRipple(event) {
            const button = event.currentTarget;
            const rect = button.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = event.clientX - rect.left - size / 2;
            const y = event.clientY - rect.top - size / 2;
            
            const ripple = document.createElement('span');
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                background: rgba(255, 255, 255, 0.3);
                left: ${x}px;
                top: ${y}px;
                width: ${size}px;
                height: ${size}px;
            `;
            
            const rippleStyle = document.createElement('style');
            rippleStyle.innerHTML = `
                @keyframes ripple {
                    to { transform: scale(2); opacity: 0; }
                }
            `;
            document.head.appendChild(rippleStyle);
            
            button.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        }

        document.querySelectorAll('.cta-button, .dashboard-toggle').forEach(button => {
            button.addEventListener('click', createRipple);
        });
    </script>
</body>
</html>