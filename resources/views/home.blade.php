<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ale_dev - Solusi Digital Revolusioner</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes glow {
            0%, 100% { box-shadow: 0 0 40px rgba(138, 43, 226, 0.5), 0 0 80px rgba(0, 255, 255, 0.3); }
            50% { box-shadow: 0 0 60px rgba(138, 43, 226, 0.8), 0 0 120px rgba(0, 255, 255, 0.5); }
        }

        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #000;
            color: #fff;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #000000, #0a0a2e, #16213e, #0f3460, #000000);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            z-index: -2;
        }

        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .star {
            position: absolute;
            background: white;
            border-radius: 50%;
            animation: twinkle 3s infinite;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 1; }
        }

        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            padding: 20px 5%;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-logo {
            font-size: 28px;
            font-weight: 900;
            background: linear-gradient(135deg, #00ffff, #8a2be2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-menu {
            display: flex;
            gap: 40px;
            list-style: none;
        }

        .nav-menu a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-menu a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, #00ffff, #8a2be2);
            transition: width 0.3s ease;
        }

        .nav-menu a:hover::after {
            width: 100%;
        }

        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(138, 43, 226, 0.4), transparent);
            border-radius: 50%;
            top: -200px;
            right: -200px;
            animation: float 6s ease-in-out infinite;
        }

        .hero::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(0, 255, 255, 0.3), transparent);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
            animation: float 8s ease-in-out infinite;
        }

        .hero-content {
            text-align: center;
            z-index: 1;
            animation: fadeInScale 1.2s ease;
        }

        .logo {
            font-size: 120px;
            font-weight: 900;
            letter-spacing: -5px;
            background: linear-gradient(135deg, #00ffff, #8a2be2, #ff00ff, #00ffff);
            background-size: 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientShift 5s ease infinite;
            text-shadow: 0 0 80px rgba(138, 43, 226, 0.5);
            margin-bottom: 20px;
        }

        .tagline {
            font-size: 32px;
            font-weight: 300;
            letter-spacing: 8px;
            text-transform: uppercase;
            margin-bottom: 20px;
            opacity: 0.9;
        }

        .hero-description {
            font-size: 18px;
            max-width: 700px;
            margin: 0 auto 40px;
            line-height: 1.8;
            opacity: 0.8;
        }

        .cta-button {
            display: inline-block;
            padding: 20px 60px;
            font-size: 18px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #fff;
            background: linear-gradient(135deg, #8a2be2, #00ffff);
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            animation: glow 2s ease-in-out infinite;
            text-decoration: none;
            margin: 10px;
        }

        .cta-button:hover {
            transform: scale(1.05);
            letter-spacing: 4px;
        }

        .cta-button.secondary {
            background: transparent;
            border: 2px solid #00ffff;
            animation: none;
        }

        .section {
            padding: 120px 5%;
            position: relative;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 72px;
            font-weight: 900;
            text-align: center;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #00ffff, #8a2be2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -2px;
        }

        .section-subtitle {
            text-align: center;
            font-size: 20px;
            opacity: 0.7;
            max-width: 800px;
            margin: 0 auto 80px;
            line-height: 1.8;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
            margin-top: 60px;
        }

        .about-text h3 {
            font-size: 36px;
            margin-bottom: 30px;
            color: #00ffff;
        }

        .about-text p {
            font-size: 18px;
            line-height: 1.8;
            opacity: 0.8;
            margin-bottom: 20px;
        }

        .about-features {
            display: grid;
            gap: 20px;
        }

        .feature-item {
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 15px;
            border-left: 4px solid #8a2be2;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: rgba(138, 43, 226, 0.2);
            transform: translateX(10px);
        }

        .feature-item h4 {
            color: #00ffff;
            margin-bottom: 10px;
            font-size: 20px;
        }

        .stats-section {
            background: linear-gradient(135deg, rgba(138, 43, 226, 0.2), rgba(0, 255, 255, 0.2));
            backdrop-filter: blur(20px);
            border-radius: 50px;
            padding: 80px 60px;
            margin: 80px 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 60px;
            text-align: center;
        }

        .stat-item {
            position: relative;
        }

        .stat-number {
            font-size: 64px;
            font-weight: 900;
            background: linear-gradient(135deg, #00ffff, #8a2be2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0.7;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .service-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 50px;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(138, 43, 226, 0.1), rgba(0, 255, 255, 0.1));
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .service-card:hover {
            transform: translateY(-15px) scale(1.02);
            border-color: rgba(138, 43, 226, 0.5);
            box-shadow: 0 30px 80px rgba(138, 43, 226, 0.4);
        }

        .service-card:hover::before {
            opacity: 1;
        }

        .service-icon {
            font-size: 60px;
            margin-bottom: 30px;
            display: block;
        }

        .service-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #00ffff;
        }

        .service-desc {
            font-size: 16px;
            line-height: 1.8;
            opacity: 0.8;
            margin-bottom: 20px;
        }

        .service-features {
            list-style: none;
            padding-left: 0;
        }

        .service-features li {
            padding: 8px 0;
            padding-left: 25px;
            position: relative;
            opacity: 0.7;
        }

        .service-features li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #00ffff;
            font-weight: bold;
        }

        .vision-mission {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 60px;
        }

        .vm-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 50px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .vm-card h3 {
            font-size: 36px;
            color: #00ffff;
            margin-bottom: 30px;
        }

        .vm-card p, .vm-card li {
            font-size: 18px;
            line-height: 1.8;
            opacity: 0.8;
        }

        .vm-card ul {
            list-style: none;
            padding-left: 0;
        }

        .vm-card li {
            padding: 15px 0;
            padding-left: 35px;
            position: relative;
        }

        .vm-card li::before {
            content: '→';
            position: absolute;
            left: 0;
            color: #8a2be2;
            font-weight: bold;
            font-size: 24px;
        }

        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
            margin-top: 60px;
        }

        .portfolio-item {
            position: relative;
            height: 400px;
            border-radius: 30px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.5s ease;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
        }

        .portfolio-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(138, 43, 226, 0.8), rgba(0, 255, 255, 0.6));
            opacity: 0;
            transition: opacity 0.5s ease;
            z-index: 1;
        }

        .portfolio-item:hover::before {
            opacity: 1;
        }

        .portfolio-item:hover {
            transform: scale(1.05);
            box-shadow: 0 30px 80px rgba(138, 43, 226, 0.5);
        }

        .portfolio-bg {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 80px;
        }

        .portfolio-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 40px;
            z-index: 2;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.9));
        }

        .portfolio-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .portfolio-desc {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 15px;
        }

        .portfolio-tags {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .tag {
            background: rgba(0, 255, 255, 0.2);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            border: 1px solid rgba(0, 255, 255, 0.3);
        }

        .process-section {
            position: relative;
        }

        .process-timeline {
            position: relative;
            padding: 40px 0;
            max-width: 1000px;
            margin: 0 auto;
        }

        .timeline-item {
            display: flex;
            align-items: center;
            margin-bottom: 80px;
            position: relative;
        }

        .timeline-item:nth-child(odd) {
            flex-direction: row;
        }

        .timeline-item:nth-child(even) {
            flex-direction: row-reverse;
        }

        .timeline-content {
            background: rgba(255, 255, 255, 0.05);
            padding: 30px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            flex: 1;
            transition: all 0.3s ease;
        }

        .timeline-content:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(138, 43, 226, 0.3);
        }

        .timeline-content h3 {
            color: #00ffff;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .timeline-content p {
            opacity: 0.8;
            line-height: 1.8;
        }

        .timeline-marker {
            width: 100px;
            height: 100px;
            min-width: 100px;
            background: linear-gradient(135deg, #8a2be2, #00ffff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            font-weight: bold;
            position: relative;
            margin: 0 40px;
            box-shadow: 0 0 30px rgba(138, 43, 226, 0.5);
            z-index: 2;
        }

        .timeline-item:not(:last-child) .timeline-marker::after {
            content: '';
            position: absolute;
            width: 4px;
            height: 120px;
            background: linear-gradient(180deg, #8a2be2, rgba(138, 43, 226, 0.3));
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            z-index: -1;
        }

        .timeline-item:last-child .timeline-marker::after {
            display: none;
        }

        .team-section {
            background: linear-gradient(135deg, rgba(138, 43, 226, 0.1), transparent);
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .team-card {
            text-align: center;
            background: rgba(255, 255, 255, 0.03);
            padding: 40px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .team-card:hover {
            transform: translateY(-10px);
            border-color: rgba(138, 43, 226, 0.5);
            box-shadow: 0 20px 60px rgba(138, 43, 226, 0.3);
        }

        .team-avatar {
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, #8a2be2, #00ffff);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
        }

        .team-name {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #00ffff;
        }

        .team-position {
            font-size: 16px;
            opacity: 0.7;
            margin-bottom: 15px;
        }

        .team-desc {
            font-size: 14px;
            line-height: 1.6;
            opacity: 0.6;
        }

        .pricing-section {
            position: relative;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .pricing-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 50px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
        }

        .pricing-card.featured {
            background: linear-gradient(135deg, rgba(138, 43, 226, 0.2), rgba(0, 255, 255, 0.2));
            border-color: #8a2be2;
            transform: scale(1.05);
        }

        .pricing-card.featured::before {
            content: 'POPULER';
            position: absolute;
            top: -15px;
            right: 30px;
            background: linear-gradient(135deg, #8a2be2, #00ffff);
            padding: 8px 25px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            border-color: rgba(138, 43, 226, 0.5);
        }

        .pricing-name {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #00ffff;
        }

        .pricing-price {
            font-size: 48px;
            font-weight: 900;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #00ffff, #8a2be2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .pricing-period {
            font-size: 16px;
            opacity: 0.6;
            margin-bottom: 30px;
        }

        .pricing-features {
            list-style: none;
            padding: 0;
            margin: 30px 0;
            text-align: left;
        }

        .pricing-features li {
            padding: 12px 0;
            padding-left: 30px;
            position: relative;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .pricing-features li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #00ffff;
            font-weight: bold;
        }

        .testimonial-section {
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.1), transparent);
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .testimonial-card {
            background: rgba(255, 255, 255, 0.03);
            padding: 40px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: 20px;
            left: 30px;
            font-size: 100px;
            color: rgba(138, 43, 226, 0.2);
            font-family: Georgia, serif;
            line-height: 1;
        }

        .testimonial-text {
            font-size: 16px;
            line-height: 1.8;
            opacity: 0.8;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .author-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #8a2be2, #00ffff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .author-info h4 {
            color: #00ffff;
            margin-bottom: 5px;
        }

        .author-info p {
            font-size: 14px;
            opacity: 0.6;
        }

        .contact-section {
            text-align: center;
            padding: 120px 5%;
        }

        .contact-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .contact-title {
            font-size: 56px;
            font-weight: 900;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #00ffff, #8a2be2, #ff00ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .contact-desc {
            font-size: 20px;
            margin-bottom: 50px;
            opacity: 0.8;
            line-height: 1.8;
        }

        .contact-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .contact-item {
            background: rgba(255, 255, 255, 0.03);
            padding: 40px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            transform: translateY(-10px);
            border-color: rgba(138, 43, 226, 0.5);
            box-shadow: 0 20px 60px rgba(138, 43, 226, 0.3);
        }

        .contact-icon {
            font-size: 48px;
            margin-bottom: 20px;
            display: block;
        }

        .contact-label {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0.6;
            margin-bottom: 15px;
        }

        .contact-value {
            font-size: 18px;
            font-weight: 600;
            color: #00ffff;
            margin-bottom: 10px;
        }

        .contact-form {
            max-width: 800px;
            margin: 80px auto 0;
            text-align: left;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            margin-bottom: 10px;
            color: #00ffff;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 15px 20px;
            color: #fff;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #8a2be2;
            box-shadow: 0 0 20px rgba(138, 43, 226, 0.3);
        }

        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }

        .form-submit {
            text-align: center;
        }

        footer {
            text-align: center;
            padding: 60px 5%;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 60px;
            margin-bottom: 60px;
            text-align: left;
        }

        .footer-section h3 {
            color: #00ffff;
            margin-bottom: 20px;
            font-size: 20px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            padding: 8px 0;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: #00ffff;
            padding-left: 10px;
        }

        .social-links {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .social-links a {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: linear-gradient(135deg, #8a2be2, #00ffff);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(138, 43, 226, 0.4);
        }

        .footer-bottom {
            padding-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.6;
        }

        .scroll-indicator {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            animation: float 2s ease-in-out infinite;
        }

        .mouse {
            width: 30px;
            height: 50px;
            border: 2px solid #fff;
            border-radius: 15px;
            position: relative;
        }

        .mouse::before {
            content: '';
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 10px;
            background: #fff;
            border-radius: 2px;
            animation: scroll 2s infinite;
        }

        @keyframes scroll {
            0% { opacity: 1; top: 10px; }
            100% { opacity: 0; top: 30px; }
        }

        /* Desktop & Large Screens */
        @media (min-width: 1400px) {
            .container {
                max-width: 1600px;
            }
            
            .section-title {
                font-size: 80px;
            }
            
            .logo {
                font-size: 140px;
            }
        }

        /* Laptop & Medium Desktop */
        @media (max-width: 1400px) {
            .timeline-marker {
                width: 90px;
                height: 90px;
                font-size: 32px;
                margin: 0 35px;
            }
            
            .timeline-item:not(:last-child) .timeline-marker::after {
                height: 110px;
            }
        }

        /* Tablet Landscape & Small Desktop */
        @media (max-width: 1200px) {
            .container {
                padding: 0 20px;
            }
            
            .section-title {
                font-size: 56px;
            }
            
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .timeline-marker {
                width: 80px;
                height: 80px;
                font-size: 28px;
                margin: 0 30px;
            }
            
            .timeline-content {
                padding: 25px;
            }
            
            .timeline-item:not(:last-child) .timeline-marker::after {
                height: 100px;
            }
        }

        /* Tablet Portrait */
        @media (max-width: 1024px) {
            .nav-menu {
                gap: 20px;
                font-size: 14px;
            }
            
            .logo {
                font-size: 80px;
            }
            
            .tagline {
                font-size: 24px;
                letter-spacing: 6px;
            }
            
            .hero-description {
                font-size: 16px;
                padding: 0 20px;
            }
            
            .section {
                padding: 80px 5%;
            }
            
            .section-title {
                font-size: 48px;
            }
            
            .section-subtitle {
                font-size: 18px;
            }
            
            .about-content,
            .vision-mission {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            /* Timeline for Tablet - Vertical Layout */
            .process-timeline {
                max-width: 600px;
            }
            
            .timeline-item {
                flex-direction: column !important;
                margin-bottom: 60px;
            }
            
            .timeline-marker {
                margin: 20px 0 !important;
            }
            
            .timeline-content {
                width: 100%;
                text-align: center;
            }
            
            .timeline-item:not(:last-child) .timeline-marker::after {
                height: 80px;
            }
            
            .services-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 40px;
            }
            
            .portfolio-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .pricing-card.featured {
                transform: scale(1);
            }
            
            .contact-info {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Mobile Landscape & Large Phones */
        @media (max-width: 768px) {
            nav {
                padding: 15px 5%;
            }
            
            .nav-logo {
                font-size: 24px;
            }
            
            .nav-menu {
                display: none;
                position: fixed;
                top: 70px;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.98);
                backdrop-filter: blur(20px);
                flex-direction: column;
                padding: 30px 5%;
                gap: 25px;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                z-index: 999;
                max-height: calc(100vh - 70px);
                overflow-y: auto;
            }
            
            .nav-menu.active {
                display: flex;
            }
            
            .nav-menu a {
                font-size: 18px;
                padding: 15px 0;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }
            
            .hero {
                min-height: 100vh;
                padding: 100px 20px 80px;
            }
            
            .logo { 
                font-size: 56px;
                letter-spacing: -3px;
            }
            
            .tagline { 
                font-size: 16px;
                letter-spacing: 3px;
                margin-bottom: 15px;
            }
            
            .hero-description {
                font-size: 14px;
                line-height: 1.6;
                margin-bottom: 30px;
            }
            
            .cta-button {
                padding: 15px 40px;
                font-size: 14px;
                letter-spacing: 1px;
                margin: 5px;
            }
            
            .section {
                padding: 60px 5%;
            }
            
            .section-title { 
                font-size: 36px;
                margin-bottom: 20px;
                letter-spacing: -1px;
            }
            
            .section-subtitle {
                font-size: 16px;
                margin-bottom: 40px;
            }
            
            .stats-section {
                padding: 40px 30px;
                border-radius: 30px;
                margin: 40px 0;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .stat-number {
                font-size: 48px;
            }
            
            .stat-label {
                font-size: 16px;
            }
            
            .about-text h3 {
                font-size: 28px;
                margin-bottom: 20px;
            }
            
            .about-text p {
                font-size: 16px;
            }
            
            .feature-item {
                padding: 15px;
            }
            
            .feature-item h4 {
                font-size: 18px;
            }
            
            .vm-card {
                padding: 30px 20px;
            }
            
            .vm-card h3 {
                font-size: 28px;
                margin-bottom: 20px;
            }
            
            .vm-card p, .vm-card li {
                font-size: 16px;
            }
            
            .services-grid, 
            .portfolio-grid, 
            .team-grid, 
            .pricing-grid, 
            .testimonial-grid { 
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .service-card,
            .pricing-card {
                padding: 30px 20px;
            }
            
            .service-icon {
                font-size: 48px;
                margin-bottom: 20px;
            }
            
            .service-title {
                font-size: 24px;
            }
            
            .service-desc {
                font-size: 15px;
            }
            
            .portfolio-item {
                height: 350px;
            }
            
            .portfolio-bg {
                font-size: 60px;
            }
            
            .portfolio-content {
                padding: 25px;
            }
            
            .portfolio-title {
                font-size: 22px;
            }
            
            .portfolio-desc {
                font-size: 14px;
            }
            
            .timeline-content {
                padding: 20px;
            }
            
            .timeline-content h3 {
                font-size: 20px;
            }
            
            .timeline-marker {
                width: 60px;
                height: 60px;
                font-size: 24px;
            }
            
            .team-card {
                padding: 30px 20px;
            }
            
            .team-avatar {
                width: 120px;
                height: 120px;
                font-size: 50px;
            }
            
            .team-name {
                font-size: 20px;
            }
            
            .pricing-name {
                font-size: 24px;
            }
            
            .pricing-price {
                font-size: 36px;
            }
            
            .testimonial-card {
                padding: 30px 20px;
            }
            
            .testimonial-text {
                font-size: 15px;
            }
            
            .contact-title { 
                font-size: 32px;
                margin-bottom: 20px;
            }
            
            .contact-desc {
                font-size: 16px;
                margin-bottom: 40px;
            }
            
            .contact-info {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .contact-item {
                padding: 30px 20px;
            }
            
            .contact-icon {
                font-size: 40px;
            }
            
            .contact-value {
                font-size: 16px;
            }
            
            .contact-form {
                margin-top: 60px;
            }
            
            .contact-form h3 {
                font-size: 24px;
                margin-bottom: 30px;
            }
            
            .form-grid { 
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .form-group input,
            .form-group textarea {
                padding: 12px 15px;
                font-size: 14px;
            }
            
            .footer-grid { 
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .footer-section h3 {
                font-size: 18px;
            }
            
            .social-links {
                justify-content: center;
            }
            
            .scroll-indicator {
                display: none;
            }
        }

        /* Small Mobile */
        @media (max-width: 480px) {
            .logo {
                font-size: 42px;
            }
            
            .tagline {
                font-size: 14px;
                letter-spacing: 2px;
            }
            
            .hero-description {
                font-size: 13px;
            }
            
            .cta-button {
                padding: 12px 30px;
                font-size: 13px;
                display: block;
                margin: 10px auto;
                width: 100%;
                max-width: 300px;
            }
            
            .section-title {
                font-size: 28px;
            }
            
            .stats-section {
                padding: 30px 20px;
            }
            
            .stat-number {
                font-size: 36px;
            }
            
            .stat-label {
                font-size: 14px;
            }
            
            .service-card,
            .pricing-card,
            .testimonial-card,
            .contact-item {
                padding: 25px 15px;
            }
            
            .portfolio-item {
                height: 300px;
            }
            
            .portfolio-content {
                padding: 20px;
            }
            
            .portfolio-title {
                font-size: 18px;
            }
            
            .portfolio-tags {
                gap: 5px;
            }
            
            .tag {
                font-size: 11px;
                padding: 4px 10px;
            }
            
            .pricing-card.featured::before {
                right: 15px;
                font-size: 11px;
                padding: 6px 20px;
            }
            
            .contact-title {
                font-size: 26px;
            }
            
            .contact-form h3 {
                font-size: 20px;
            }
            
            .hero::before,
            .hero::after {
                width: 300px;
                height: 300px;
            }
        }

        /* Extra Small Mobile */
        @media (max-width: 360px) {
            .logo {
                font-size: 36px;
            }
            
            .section-title {
                font-size: 24px;
            }
            
            .section {
                padding: 50px 5%;
            }
            
            .stats-section {
                padding: 25px 15px;
            }
            
            .service-card,
            .team-card,
            .pricing-card {
                padding: 20px 12px;
            }
        }
    </style>
</head>
<body>
    <div class="stars" id="stars"></div>

    <nav>
        <div class="nav-container">
            <div class="nav-logo">ale_dev</div>
            <ul class="nav-menu">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#about">Tentang</a></li>
                <li><a href="#services">Layanan</a></li>
                <li><a href="#portfolio">Portofolio</a></li>
                <li><a href="#pricing">Harga</a></li>
                <li><a href="#contact">Kontak</a></li>
            </ul>
        </div>
    </nav>

    <section class="hero" id="home">
        <div class="hero-content">
            <h1 class="logo">ale_dev</h1>
            <p class="tagline">Solusi Digital Revolusioner</p>
            <p class="hero-description">Kami adalah perusahaan teknologi terdepan yang menghadirkan inovasi digital untuk mentransformasi bisnis Anda ke era digital dengan solusi yang powerful, scalable, dan future-ready.</p>
            <div>
                <a href="#contact" class="cta-button">Mulai Proyek Anda</a>
                <a href="#about" class="cta-button secondary">Pelajari Lebih Lanjut</a>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="mouse"></div>
        </div>
    </section>

    <section class="section" id="about">
        <div class="container">
            <h2 class="section-title">Tentang Kami</h2>
            <p class="section-subtitle">ale_dev adalah perusahaan teknologi yang berdedikasi untuk menciptakan solusi digital yang mengubah cara bisnis beroperasi di era modern.</p>
            
            <div class="about-content">
                <div class="about-text">
                    <h3>Mengapa Memilih ale_dev?</h3>
                    <p>Dengan pengalaman lebih dari 10 tahun di industri teknologi, kami telah membantu ratusan perusahaan dari berbagai skala untuk bertransformasi digital. Tim kami terdiri dari para ahli yang berpengalaman dan bersertifikat internasional.</p>
                    <p>Kami tidak hanya membangun produk, tetapi juga membangun partnership jangka panjang dengan klien. Setiap proyek adalah komitmen kami untuk memberikan nilai maksimal dan ROI yang terukur.</p>
                </div>
                <div class="about-features">
                    <div class="feature-item">
                        <h4>🎯 Fokus pada Hasil</h4>
                        <p>Kami mengutamakan pencapaian tujuan bisnis Anda dengan solusi yang terukur dan berdampak langsung pada bottom line.</p>
                    </div>
                    <div class="feature-item">
                        <h4>⚡ Teknologi Terkini</h4>
                        <p>Menggunakan stack teknologi terbaru dan best practices industry untuk memastikan solusi yang modern dan sustainable.</p>
                    </div>
                    <div class="feature-item">
                        <h4>🤝 Kolaborasi Transparan</h4>
                        <p>Komunikasi terbuka dan regular updates untuk memastikan project berjalan sesuai ekspektasi dan timeline.</p>
                    </div>
                    <div class="feature-item">
                        <h4>🔒 Keamanan Premium</h4>
                        <p>Security-first approach dengan enkripsi end-to-end dan compliance dengan standar internasional.</p>
                    </div>
                </div>
            </div>

            <div class="stats-section">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Proyek Selesai</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">250+</div>
                        <div class="stat-label">Klien Puas</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Tim Ahli</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">99%</div>
                        <div class="stat-label">Tingkat Kepuasan</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Support</div>
                    </div>
                </div>
            </div>

            <div class="vision-mission">
                <div class="vm-card">
                    <h3>Visi Kami</h3>
                    <p>Menjadi perusahaan teknologi terdepan di Indonesia yang dikenal sebagai partner terpercaya dalam transformasi digital, menghadirkan solusi inovatif yang memberdayakan bisnis untuk berkembang pesat di era digital dan menciptakan dampak positif bagi masyarakat luas.</p>
                </div>
                <div class="vm-card">
                    <h3>Misi Kami</h3>
                    <ul>
                        <li>Mengembangkan produk dan layanan teknologi berkualitas tinggi yang memenuhi kebutuhan spesifik setiap klien</li>
                        <li>Memberikan customer experience yang exceptional dengan support 24/7 dan respon time yang cepat</li>
                        <li>Berinovasi secara berkelanjutan dengan mengadopsi teknologi terbaru dan best practices</li>
                        <li>Membangun tim profesional yang kompeten melalui training berkelanjutan dan pengembangan karir</li>
                        <li>Berkontribusi pada ekosistem teknologi Indonesia melalui knowledge sharing dan community building</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="services">
        <div class="container">
            <h2 class="section-title">Layanan Kami</h2>
            <p class="section-subtitle">Solusi komprehensif yang disesuaikan dengan kebutuhan bisnis Anda, dari konsep hingga implementasi dan maintenance.</p>

            <div class="services-grid">
                <div class="service-card">
                    <span class="service-icon">🚀</span>
                    <h3 class="service-title">Pengembangan Web</h3>
                    <p class="service-desc">Membangun website dan aplikasi web yang modern, responsif, dan high-performance menggunakan framework terkini seperti React, Vue, Angular, dan Next.js.</p>
                    <ul class="service-features">
                        <li>Custom Web Application Development</li>
                        <li>E-Commerce Platform</li>
                        <li>Content Management System (CMS)</li>
                        <li>Progressive Web Apps (PWA)</li>
                        <li>API Development & Integration</li>
                        <li>Website Redesign & Modernization</li>
                    </ul>
                </div>

                <div class="service-card">
                    <span class="service-icon">📱</span>
                    <h3 class="service-title">Pengembangan Mobile</h3>
                    <p class="service-desc">Menciptakan aplikasi mobile native dan cross-platform yang intuitif dengan user experience terbaik untuk iOS dan Android.</p>
                    <ul class="service-features">
                        <li>Native iOS & Android Development</li>
                        <li>React Native & Flutter Apps</li>
                        <li>Mobile UI/UX Design</li>
                        <li>App Store Optimization</li>
                        <li>Mobile Backend Development</li>
                        <li>Push Notification Integration</li>
                    </ul>
                </div>

                <div class="service-card">
                    <span class="service-icon">🤖</span>
                    <h3 class="service-title">AI & Machine Learning</h3>
                    <p class="service-desc">Mengimplementasikan solusi kecerdasan buatan untuk automasi, prediksi, dan optimisasi proses bisnis dengan teknologi terdepan.</p>
                    <ul class="service-features">
                        <li>Chatbot & Virtual Assistant</li>
                        <li>Computer Vision & Image Recognition</li>
                        <li>Natural Language Processing (NLP)</li>
                        <li>Predictive Analytics</li>
                        <li>Recommendation Systems</li>
                        <li>AI Model Training & Deployment</li>
                    </ul>
                </div>

                <div class="service-card">
                    <span class="service-icon">☁️</span>
                    <h3 class="service-title">Cloud Infrastructure</h3>
                    <p class="service-desc">Merancang dan mengelola infrastruktur cloud yang scalable, secure, dan cost-effective dengan uptime 99.9%.</p>
                    <ul class="service-features">
                        <li>AWS, Google Cloud, Azure Setup</li>
                        <li>Cloud Migration Services</li>
                        <li>DevOps & CI/CD Pipeline</li>
                        <li>Kubernetes & Docker Deployment</li>
                        <li>Cloud Security & Compliance</li>
                        <li>24/7 Monitoring & Maintenance</li>
                    </ul>
                </div>

                <div class="service-card">
                    <span class="service-icon">🔐</span>
                    <h3 class="service-title">Cybersecurity</h3>
                    <p class="service-desc">Melindungi aset digital Anda dengan solusi keamanan enterprise-grade dan penetration testing komprehensif.</p>
                    <ul class="service-features">
                        <li>Security Audit & Assessment</li>
                        <li>Penetration Testing</li>
                        <li>DDoS Protection</li>
                        <li>Data Encryption & SSL/TLS</li>
                        <li>Firewall & Intrusion Detection</li>
                        <li>Security Training & Awareness</li>
                    </ul>
                </div>

                <div class="service-card">
                    <span class="service-icon">⚡</span>
                    <h3 class="service-title">Optimisasi Performa</h3>
                    <p class="service-desc">Meningkatkan kecepatan dan efisiensi aplikasi hingga 10x lebih cepat dengan teknik optimisasi advanced.</p>
                    <ul class="service-features">
                        <li>Code Optimization & Refactoring</li>
                        <li>Database Query Optimization</li>
                        <li>CDN Integration & Caching</li>
                        <li>Load Balancing & Scaling</li>
                        <li>Performance Monitoring</li>
                        <li>SEO Technical Optimization</li>
                    </ul>
                </div>

                <div class="service-card">
                    <span class="service-icon">🎨</span>
                    <h3 class="service-title">UI/UX Design</h3>
                    <p class="service-desc">Menciptakan desain interface yang beautiful, intuitive, dan conversion-focused dengan research mendalam.</p>
                    <ul class="service-features">
                        <li>User Research & Testing</li>
                        <li>Wireframing & Prototyping</li>
                        <li>Visual Design & Branding</li>
                        <li>Responsive Design</li>
                        <li>Design System Development</li>
                        <li>Usability Testing & Iteration</li>
                    </ul>
                </div>

                <div class="service-card">
                    <span class="service-icon">📊</span>
                    <h3 class="service-title">Data Analytics</h3>
                    <p class="service-desc">Mengubah data menjadi insights actionable dengan dashboard interaktif dan reporting komprehensif.</p>
                    <ul class="service-features">
                        <li>Business Intelligence Dashboard</li>
                        <li>Data Visualization</li>
                        <li>Big Data Processing</li>
                        <li>Real-time Analytics</li>
                        <li>Custom Report Generation</li>
                        <li>Data Warehouse Setup</li>
                    </ul>
                </div>

                <div class="service-card">
                    <span class="service-icon">🔧</span>
                    <h3 class="service-title">Konsultasi IT</h3>
                    <p class="service-desc">Mendampingi strategi digital transformation Anda dengan expertise dan best practices industry.</p>
                    <ul class="service-features">
                        <li>Digital Strategy Planning</li>
                        <li>Technology Stack Selection</li>
                        <li>Architecture Design Review</li>
                        <li>Project Management</li>
                        <li>Team Training & Mentoring</li>
                        <li>Technical Due Diligence</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section process-section">
        <div class="container">
            <h2 class="section-title">Proses Kerja Kami</h2>
            <p class="section-subtitle">Metodologi yang terstruktur dan transparan untuk memastikan kesuksesan setiap proyek.</p>

            <div class="process-timeline">
                <div class="timeline-item">
                    <div class="timeline-content">
                        <h3>1. Discovery & Research</h3>
                        <p>Kami memulai dengan memahami bisnis, target audience, kompetitor, dan goals Anda secara mendalam. Fase ini mencakup stakeholder interview, market research, dan technical feasibility study.</p>
                    </div>
                    <div class="timeline-marker">1</div>
                    <div style="flex: 1;"></div>
                </div>

                <div class="timeline-item">
                    <div style="flex: 1;"></div>
                    <div class="timeline-marker">2</div>
                    <div class="timeline-content">
                        <h3>2. Planning & Strategy</h3>
                        <p>Merancang roadmap detail, technology stack, architecture, dan timeline. Kami juga membuat project proposal lengkap dengan estimasi budget dan resource allocation.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-content">
                        <h3>3. Design & Prototype</h3>
                        <p>Tim design kami membuat wireframe, mockup, dan interactive prototype. Kami iterasi berdasarkan feedback hingga mendapat approval final sebelum development.</p>
                    </div>
                    <div class="timeline-marker">3</div>
                    <div style="flex: 1;"></div>
                </div>

                <div class="timeline-item">
                    <div style="flex: 1;"></div>
                    <div class="timeline-marker">4</div>
                    <div class="timeline-content">
                        <h3>4. Development</h3>
                        <p>Fase development dengan metodologi Agile, sprint mingguan, dan regular demo. Anda dapat melihat progress real-time dan memberikan feedback di setiap sprint.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-content">
                        <h3>5. Testing & QA</h3>
                        <p>Quality assurance menyeluruh meliputi functional testing, performance testing, security testing, dan user acceptance testing untuk memastikan bug-free launch.</p>
                    </div>
                    <div class="timeline-marker">5</div>
                    <div style="flex: 1;"></div>
                </div>

                <div class="timeline-item">
                    <div style="flex: 1;"></div>
                    <div class="timeline-marker">6</div>
                    <div class="timeline-content">
                        <h3>6. Launch & Deployment</h3>
                        <p>Deployment ke production environment dengan zero-downtime strategy. Kami handle domain setup, SSL certificate, monitoring tools, dan post-launch optimization.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-content">
                        <h3>7. Maintenance & Support</h3>
                        <p>Support 24/7 untuk bug fixes, updates, performance monitoring, dan continuous improvement. Kami juga menyediakan training untuk tim internal Anda.</p>
                    </div>
                    <div class="timeline-marker">7</div>
                    <div style="flex: 1;"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="portfolio">
        <div class="container">
            <h2 class="section-title">Portofolio Kami</h2>
            <p class="section-subtitle">Proyek-proyek yang telah kami kerjakan dengan hasil yang membanggakan dan kepuasan klien 100%.</p>

            <div class="portfolio-grid">
                <div class="portfolio-item">
                    <div class="portfolio-bg">🏦</div>
                    <div class="portfolio-content">
                        <h3 class="portfolio-title">Platform FinTech BankKu</h3>
                        <p class="portfolio-desc">Aplikasi mobile banking dengan 500K+ users dan rating 4.8 bintang di App Store</p>
                        <div class="portfolio-tags">
                            <span class="tag">React Native</span>
                            <span class="tag">Node.js</span>
                            <span class="tag">AWS</span>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item">
                    <div class="portfolio-bg">🛍️</div>
                    <div class="portfolio-content">
                        <h3 class="portfolio-title">E-Commerce TokoOnline</h3>
                        <p class="portfolio-desc">Platform marketplace dengan 1M+ transaksi/bulan dan 99.9% uptime</p>
                        <div class="portfolio-tags">
                            <span class="tag">Next.js</span>
                            <span class="tag">PostgreSQL</span>
                            <span class="tag">Redis</span>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item">
                    <div class="portfolio-bg">🎓</div>
                    <div class="portfolio-content">
                        <h3 class="portfolio-title">EduTech BelajarPintar</h3>
                        <p class="portfolio-desc">Learning Management System dengan AI-powered personalization</p>
                        <div class="portfolio-tags">
                            <span class="tag">Vue.js</span>
                            <span class="tag">Python</span>
                            <span class="tag">TensorFlow</span>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item">
                    <div class="portfolio-bg">🏥</div>
                    <div class="portfolio-content">
                        <h3 class="portfolio-title">HealthTech SehatKu</h3>
                        <p class="portfolio-desc">Telemedicine platform dengan video consultation dan e-prescription</p>
                        <div class="portfolio-tags">
                            <span class="tag">React</span>
                            <span class="tag">WebRTC</span>
                            <span class="tag">MongoDB</span>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item">
                    <div class="portfolio-bg">🏨</div>
                    <div class="portfolio-content">
                        <h3 class="portfolio-title">Booking System HotelKeren</h3>
                        <p class="portfolio-desc">Hotel management system dengan automated check-in/out</p>
                        <div class="portfolio-tags">
                            <span class="tag">Angular</span>
                            <span class="tag">GraphQL</span>
                            <span class="tag">Docker</span>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item">
                    <div class="portfolio-bg">🍔</div>
                    <div class="portfolio-content">
                        <h3 class="portfolio-title">Food Delivery MakanYuk</h3>
                        <p class="portfolio-desc">On-demand food delivery dengan real-time tracking dan rider app</p>
                        <div class="portfolio-tags">
                            <span class="tag">Flutter</span>
                            <span class="tag">Firebase</span>
                            <span class="tag">Google Maps</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section team-section">
        <div class="container">
            <h2 class="section-title">Tim Ahli Kami</h2>
            <p class="section-subtitle">Profesional berpengalaman dan bersertifikat yang siap mewujudkan visi digital Anda.</p>

            <div class="team-grid">
                <div class="team-card">
                    <div class="team-avatar">👨‍💼</div>
                    <h3 class="team-name">Ahmad Rivaldi</h3>
                    <p class="team-position">CEO & Founder</p>
                    <p class="team-desc">15+ tahun pengalaman di industri teknologi, ex-CTO startup unicorn</p>
                </div>

                <div class="team-card">
                    <div class="team-avatar">👨‍💻</div>
                    <h3 class="team-name">Budi Santoso</h3>
                    <p class="team-position">Lead Full-Stack Developer</p>
                    <p class="team-desc">Expert React, Node.js, AWS Certified Solutions Architect</p>
                </div>

                <div class="team-card">
                    <div class="team-avatar">👩‍💻</div>
                    <h3 class="team-name">Citra Wijaya</h3>
                    <p class="team-position">Senior Mobile Developer</p>
                    <p class="team-desc">Specialist React Native & Flutter, 50+ apps published</p>
                </div>

                <div class="team-card">
                    <div class="team-avatar">👨‍🎨</div>
                    <h3 class="team-name">Doni Prasetyo</h3>
                    <p class="team-position">Lead UI/UX Designer</p>
                    <p class="team-desc">Award-winning designer, expert Figma & Adobe Creative Suite</p>
                </div>

                <div class="team-card">
                    <div class="team-avatar">👩‍🔬</div>
                    <h3 class="team-name">Eka Putri</h3>
                    <p class="team-position">AI/ML Engineer</p>
                    <p class="team-desc">PhD in Computer Science, specialist TensorFlow & PyTorch</p>
                </div>

                <div class="team-card">
                    <div class="team-avatar">👨‍🔧</div>
                    <h3 class="team-name">Fajar Hidayat</h3>
                    <p class="team-position">DevOps Engineer</p>
                    <p class="team-desc">Kubernetes expert, AWS & Google Cloud certified</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section pricing-section" id="pricing">
        <div class="container">
            <h2 class="section-title">Paket Layanan</h2>
            <p class="section-subtitle">Pilih paket yang sesuai dengan kebutuhan dan budget bisnis Anda. Semua paket include maintenance 3 bulan gratis.</p>

            <div class="pricing-grid">
                <div class="pricing-card">
                    <h3 class="pricing-name">Starter</h3>
                    <div class="pricing-price">25 Jt</div>
                    <p class="pricing-period">Perfect untuk startup & UKM</p>
                    <ul class="pricing-features">
                        <li>Landing Page / Company Profile</li>
                        <li>Responsive Design (5 Pages)</li>
                        <li>CMS Integration</li>
                        <li>Basic SEO</li>
                        <li>SSL Certificate</li>
                        <li>3 Bulan Maintenance</li>
                        <li>Email Support</li>
                        <li>Google Analytics Setup</li>
                    </ul>
                    <a href="#contact" class="cta-button" style="margin-top: 30px;">Pilih Paket</a>
                </div>

                <div class="pricing-card featured">
                    <h3 class="pricing-name">Professional</h3>
                    <div class="pricing-price">75 Jt</div>
                    <p class="pricing-period">Ideal untuk bisnis berkembang</p>
                    <ul class="pricing-features">
                        <li>Custom Web Application</li>
                        <li>Advanced Features & Integrations</li>
                        <li>Admin Panel / Dashboard</li>
                        <li>Payment Gateway Integration</li>
                        <li>API Development</li>
                        <li>Advanced SEO & Performance</li>
                        <li>6 Bulan Maintenance</li>
                        <li>Priority Support 24/7</li>
                        <li>Monthly Analytics Report</li>
                        <li>Security Audit</li>
                    </ul>
                    <a href="#contact" class="cta-button" style="margin-top: 30px;">Pilih Paket</a>
                </div>

                <div class="pricing-card">
                    <h3 class="pricing-name">Enterprise</h3>
                    <div class="pricing-price">150 Jt+</div>
                    <p class="pricing-period">Solusi korporat skala besar</p>
                    <ul class="pricing-features">
                        <li>Full-Scale Platform Development</li>
                        <li>Mobile App (iOS & Android)</li>
                        <li>AI/ML Integration</li>
                        <li>Cloud Infrastructure Setup</li>
                        <li>Microservices Architecture</li>
                        <li>Load Balancing & Auto-scaling</li>
                        <li>12 Bulan Maintenance</li>
                        <li>Dedicated Team & Project Manager</li>
                        <li>White-label Solution</li>
                        <li>Unlimited Revisions</li>
                        <li>Penetration Testing</li>
                        <li>Training & Documentation</li>
                    </ul>
                    <a href="#contact" class="cta-button" style="margin-top: 30px;">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section testimonial-section">
        <div class="container">
            <h2 class="section-title">Testimoni Klien</h2>
            <p class="section-subtitle">Kepercayaan klien adalah aset terbesar kami. Berikut adalah pengalaman mereka bekerja dengan ale_dev.</p>

            <div class="testimonial-grid">
                <div class="testimonial-card">
                    <p class="testimonial-text">ale_dev benar-benar mengubah cara kami berbisnis. Platform e-commerce yang mereka bangun meningkatkan sales kami 300% dalam 6 bulan pertama. Tim yang profesional dan responsif!</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">👨‍💼</div>
                        <div class="author-info">
                            <h4>Bambang Wijaya</h4>
                            <p>CEO TokoOnline.id</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <p class="testimonial-text">Aplikasi mobile banking yang dikembangkan ale_dev sangat stabil dan user-friendly. User retention kami naik signifikan. Highly recommended untuk fintech projects!</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">👩‍💼</div>
                        <div class="author-info">
                            <h4>Siti Nurhaliza</h4>
                            <p>Product Manager BankKu</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <p class="testimonial-text">Proses development sangat transparan dengan update rutin setiap sprint. Hasil akhirnya melebihi ekspektasi kami. Tim ale_dev benar-benar partner yang bisa diandalkan.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">👨‍🏫</div>
                        <div class="author-info">
                            <h4>Dr. Agus Setiawan</h4>
                            <p>Founder BelajarPintar</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <p class="testimonial-text">Infrastructure cloud yang mereka setup sangat reliable dengan uptime 99.9%. Response time untuk handling issues juga sangat cepat. Worth every penny!</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">👩‍⚕️</div>
                        <div class="author-info">
                            <h4>dr. Linda Kusuma</h4>
                            <p>CTO SehatKu Clinic</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <p class="testimonial-text">UI/UX design dari ale_dev sangat modern dan conversion rate website kami meningkat drastis. Mereka benar-benar memahami user behavior dan business goals kami.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">👨‍💻</div>
                        <div class="author-info">
                            <h4>Rudi Hartono</h4>
                            <p>Marketing Director HotelKeren</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <p class="testimonial-text">Implementasi AI untuk recommendation system kami luar biasa. Customer engagement naik 250%. ale_dev adalah yang terbaik untuk ML projects di Indonesia.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">👩‍🍳</div>
                        <div class="author-info">
                            <h4>Chef Melissa</h4>
                            <p>Owner MakanYuk Delivery</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-section" id="contact">
        <div class="contact-content">
            <h2 class="contact-title">Mari Wujudkan Proyek Digital Anda</h2>
            <p class="contact-desc">Siap untuk mentransformasi bisnis Anda? Tim ahli kami siap membantu mewujudkan visi digital Anda menjadi kenyataan. Konsultasi gratis untuk proyek pertama!</p>
            
            <div class="contact-info">
                <div class="contact-item">
                    <span class="contact-icon">📍</span>
                    <div class="contact-label">Alamat Kantor</div>
                    <div class="contact-value">Jl. Teknologi No. 123</div>
                    <p style="opacity: 0.6; margin-top: 10px;">Pekalongan, Jawa Tengah 51122<br>Indonesia</p>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">📧</span>
                    <div class="contact-label">Email</div>
                    <div class="contact-value">hello@aledev.com</div>
                    <p style="opacity: 0.6; margin-top: 10px;">info@aledev.com<br>support@aledev.com</p>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">📞</span>
                    <div class="contact-label">Telepon</div>
                    <div class="contact-value">+62 812-3456-7890</div>
                    <p style="opacity: 0.6; margin-top: 10px;">Senin - Jumat: 09.00 - 18.00 WIB<br>Sabtu: 09.00 - 14.00 WIB</p>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">💬</span>
                    <div class="contact-label">WhatsApp Business</div>
                    <div class="contact-value">+62 821-9876-5432</div>
                    <p style="opacity: 0.6; margin-top: 10px;">Fast Response<br>Available 24/7</p>
                </div>
            </div>

            <div class="contact-form">
                <h3 style="text-align: center; font-size: 32px; margin-bottom: 40px; color: #00ffff;">Formulir Konsultasi Gratis</h3>
                <form id="contactForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Nama Lengkap *</label>
                            <input type="text" id="name" name="name" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div class="form-group">
                            <label for="company">Nama Perusahaan *</label>
                            <input type="text" id="company" name="company" placeholder="Nama perusahaan Anda" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" placeholder="email@perusahaan.com" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Nomor Telepon *</label>
                            <input type="tel" id="phone" name="phone" placeholder="+62 xxx xxxx xxxx" required>
                        </div>
                        <div class="form-group full-width">
                            <label for="service">Layanan yang Diminati *</label>
                            <input type="text" id="service" name="service" placeholder="Contoh: Web Development, Mobile App, AI Integration" required>
                        </div>
                        <div class="form-group full-width">
                            <label for="budget">Estimasi Budget</label>
                            <input type="text" id="budget" name="budget" placeholder="Contoh: 50 - 100 Juta">
                        </div>
                        <div class="form-group full-width">
                            <label for="message">Deskripsi Proyek *</label>
                            <textarea id="message" name="message" placeholder="Ceritakan tentang proyek Anda, tujuan bisnis, fitur yang diinginkan, dan timeline yang diharapkan..." required></textarea>
                        </div>
                    </div>
                    <div class="form-submit">
                        <button type="submit" class="cta-button">Kirim Permintaan Konsultasi</button>
                        <p style="margin-top: 20px; opacity: 0.6; font-size: 14px;">* Kami akan merespon dalam 24 jam</p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-grid">
                <div class="footer-section">
                    <h3>ale_dev</h3>
                    <p style="opacity: 0.7; line-height: 1.8; margin-top: 20px;">Perusahaan teknologi terdepan yang menghadirkan solusi digital inovatif untuk transformasi bisnis di era digital.</p>
                    <div class="social-links">
                        <a href="#" title="Facebook">📘</a>
                        <a href="#" title="Instagram">📷</a>
                        <a href="#" title="LinkedIn">💼</a>
                        <a href="#" title="Twitter">🐦</a>
                        <a href="#" title="YouTube">📹</a>
                    </div>
                </div>

                <div class="footer-section">
                    <h3>Layanan</h3>
                    <ul class="footer-links">
                        <li><a href="#services">Pengembangan Web</a></li>
                        <li><a href="#services">Pengembangan Mobile</a></li>
                        <li><a href="#services">AI & Machine Learning</a></li>
                        <li><a href="#services">Cloud Infrastructure</a></li>
                        <li><a href="#services">Cybersecurity</a></li>
                        <li><a href="#services">UI/UX Design</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Perusahaan</h3>
                    <ul class="footer-links">
                        <li><a href="#about">Tentang Kami</a></li>
                        <li><a href="#portfolio">Portofolio</a></li>
                        <li><a href="#pricing">Harga</a></li>
                        <li><a href="#contact">Kontak</a></li>
                        <li><a href="#">Karir</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Legal</h3>
                    <ul class="footer-links">
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                        <li><a href="#">SLA Agreement</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Newsletter</h3>
                    <p style="opacity: 0.7; margin-bottom: 20px;">Dapatkan update terbaru tentang teknologi dan tips digital transformation.</p>
                    <form style="display: flex; gap: 10px;">
                        <input type="email" placeholder="Email Anda" style="flex: 1; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); padding: 12px; border-radius: 10px; color: #fff;">
                        <button type="submit" class="cta-button" style="padding: 12px 30px; animation: none; margin: 0;">Subscribe</button>
                    </form>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 ale_dev. All Rights Reserved.</p>
                <p style="margin-top: 15px;">Crafted with 💜 in Pekalongan, Indonesia</p>
                <p style="margin-top: 10px; font-size: 14px;">Transforming Ideas Into Digital Masterpieces Since 2015</p>
            </div>
        </div>
    </footer>

    <script>
        // Generate stars
        const starsContainer = document.getElementById('stars');
        for (let i = 0; i < 150; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            star.style.width = Math.random() * 3 + 'px';
            star.style.height = star.style.width;
            star.style.left = Math.random() * 100 + '%';
            star.style.top = Math.random() * 100 + '%';
            star.style.animationDelay = Math.random() * 3 + 's';
            starsContainer.appendChild(star);
        }

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Contact form handling
        const contactForm = document.getElementById('contactForm');
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = {
                name: document.getElementById('name').value,
                company: document.getElementById('company').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                service: document.getElementById('service').value,
                budget: document.getElementById('budget').value,
                message: document.getElementById('message').value
            };
            
            // Show success message
            alert('Terima kasih! Permintaan konsultasi Anda telah diterima. Tim kami akan segera menghubungi Anda dalam 24 jam.');
            
            // Reset form
            contactForm.reset();
            
            // In production, you would send this to your backend
            console.log('Form submitted:', formData);
        });

        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements
        document.querySelectorAll('.service-card, .portfolio-item, .team-card, .pricing-card, .testimonial-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });

        // Active navigation highlight
        window.addEventListener('scroll', () => {
            const sections = document.querySelectorAll('section[id]');
            const scrollY = window.pageYOffset;

            sections.forEach(section => {
                const sectionHeight = section.offsetHeight;
                const sectionTop = section.offsetTop - 100;
                const sectionId = section.getAttribute('id');
                const navLink = document.querySelector(`.nav-menu a[href="#${sectionId}"]`);

                if (navLink && scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                    navLink.style.color = '#00ffff';
                } else if (navLink) {
                    navLink.style.color = '#fff';
                }
            });
        });

        // Parallax effect for hero
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroContent = document.querySelector('.hero-content');
            if (heroContent && scrolled < window.innerHeight) {
                heroContent.style.transform = `translateY(${scrolled * 0.5}px)`;
                heroContent.style.opacity = 1 - (scrolled / window.innerHeight);
            }
        });

        // Counter animation for stats
        const animateCounter = (element, target, duration = 2000) => {
            let current = 0;
            const increment = target / (duration / 16);
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target + (element.dataset.suffix || '');
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current) + (element.dataset.suffix || '');
                }
            }, 16);
        };

        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumber = entry.target.querySelector('.stat-number');
                    if (statNumber && !statNumber.classList.contains('animated')) {
                        statNumber.classList.add('animated');
                        const text = statNumber.textContent;
                        const number = parseInt(text.replace(/\D/g, ''));
                        statNumber.dataset.suffix = text.replace(/\d/g, '');
                        animateCounter(statNumber, number);
                    }
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.stat-item').forEach(stat => {
            statsObserver.observe(stat);
        });

        // Add loading animation
        window.addEventListener('load', () => {
            document.body.style.opacity = '0';
            setTimeout(() => {
                document.body.style.transition = 'opacity 0.5s ease';
                document.body.style.opacity = '1';
            }, 100);
        });

        // Mobile menu functionality
        const createMobileMenu = () => {
            const nav = document.querySelector('nav .nav-container');
            let menuBtn = nav.querySelector('.mobile-menu-btn');
            
            if (window.innerWidth <= 768) {
                if (!menuBtn) {
                    menuBtn = document.createElement('button');
                    menuBtn.className = 'mobile-menu-btn';
                    menuBtn.innerHTML = '☰';
                    menuBtn.style.cssText = `
                        background: none;
                        border: none;
                        color: #fff;
                        font-size: 32px;
                        cursor: pointer;
                        display: block;
                        padding: 5px 10px;
                        transition: transform 0.3s ease;
                    `;
                    nav.appendChild(menuBtn);
                    
                    menuBtn.addEventListener('click', () => {
                        const menu = document.querySelector('.nav-menu');
                        menu.classList.toggle('active');
                        menuBtn.innerHTML = menu.classList.contains('active') ? '✕' : '☰';
                        menuBtn.style.transform = menu.classList.contains('active') ? 'rotate(90deg)' : 'rotate(0)';
                    });
                    
                    // Close menu when clicking on a link
                    document.querySelectorAll('.nav-menu a').forEach(link => {
                        link.addEventListener('click', () => {
                            const menu = document.querySelector('.nav-menu');
                            menu.classList.remove('active');
                            menuBtn.innerHTML = '☰';
                            menuBtn.style.transform = 'rotate(0)';
                        });
                    });
                    
                    // Close menu when clicking outside
                    document.addEventListener('click', (e) => {
                        const menu = document.querySelector('.nav-menu');
                        if (!nav.contains(e.target) && menu.classList.contains('active')) {
                            menu.classList.remove('active');
                            menuBtn.innerHTML = '☰';
                            menuBtn.style.transform = 'rotate(0)';
                        }
                    });
                }
            } else {
                if (menuBtn) {
                    menuBtn.remove();
                    document.querySelector('.nav-menu').classList.remove('active');
                }
            }
        };

        createMobileMenu();
        
        // Debounced resize handler
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                createMobileMenu();
            }, 250);
        });
    </script>
</body>
</html>