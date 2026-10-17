<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio MUA ULVA — Makeup Artist Profesional Pekanbaru</title>
    <meta name="description" content="Studio MUA ULVA: Jasa Makeup Artist profesional di Pekanbaru untuk pernikahan, wisuda, lamaran, dan berbagai acara spesial. Book sekarang!">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,400&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
/* ===== LANDING PAGE SPECIFIC STYLES ===== */
:root {
    --clr-cream: #FDF8F5; --clr-cream-2: #F9F1EC;
    --clr-rose: #E8C4C4; --clr-rose-dark: #C9A0A0; --clr-rose-deeper: #A87070;
    --clr-gold: #C9A87C; --clr-gold-light: #E8D5B5;
    --clr-brown: #6B4C3B; --clr-brown-deep: #3D2B1F; --clr-dark: #1A0F0A;
    --clr-white: #FFFFFF; --clr-muted: #9C7E70;
    --font-display: 'Cormorant Garamond', Georgia, serif;
    --font-body: 'Jost', system-ui, sans-serif;
    --r-pill: 9999px; --r-lg: 24px; --r-md: 16px;
    --shadow-md: 0 8px 30px rgba(107,76,59,0.12);
    --shadow-lg: 0 20px 60px rgba(107,76,59,0.15);
    --ease: cubic-bezier(0.25,0.46,0.45,0.94);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body { font-family: var(--font-body); background: var(--clr-cream); color: var(--clr-brown-deep); overflow-x: hidden; -webkit-font-smoothing: antialiased; }
h1,h2,h3,h4,h5 { font-family: var(--font-display); line-height: 1.15; }
a { text-decoration: none; color: inherit; }
img { max-width: 100%; display: block; }

/* NAVBAR */
.navbar {
    position: fixed; top: 0; left: 0; right: 0; z-index: 999;
    padding: 1.25rem 0;
    transition: all 0.4s ease;
}
.navbar.scrolled {
    background: rgba(253,248,245,0.95);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    box-shadow: 0 2px 20px rgba(107,76,59,0.08);
    padding: 0.75rem 0;
}
.nav-inner { max-width: 1200px; margin: 0 auto; padding: 0 2rem; display: flex; align-items: center; justify-content: space-between; }
.nav-brand { font-family: var(--font-display); font-size: 1.7rem; font-weight: 600; color: var(--clr-brown-deep); display: flex; align-items: center; gap: 0.6rem; }
.nav-brand i { color: var(--clr-gold); font-size: 1.4rem; }
.nav-links { display: flex; align-items: center; gap: 2.5rem; list-style: none; }
.nav-links a { font-size: 0.9rem; font-weight: 500; color: var(--clr-brown); transition: color 0.3s; position: relative; }
.nav-links a::after { content: ''; position: absolute; bottom: -3px; left: 0; width: 0; height: 1.5px; background: var(--clr-gold); transition: width 0.3s; }
.nav-links a:hover { color: var(--clr-gold); }
.nav-links a:hover::after { width: 100%; }
.nav-btns { display: flex; gap: 0.75rem; }
.btn-nav { padding: 0.55rem 1.5rem; border-radius: var(--r-pill); font-family: var(--font-body); font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all 0.3s; border: none; }
.btn-nav-outline { background: transparent; border: 1.5px solid var(--clr-brown-deep); color: var(--clr-brown-deep); }
.btn-nav-outline:hover { background: var(--clr-brown-deep); color: #fff; }
.btn-nav-solid { background: var(--clr-gold); color: var(--clr-brown-deep); box-shadow: 0 4px 15px rgba(201,168,124,0.35); }
.btn-nav-solid:hover { background: var(--clr-brown-deep); color: var(--clr-gold); transform: translateY(-2px); }
.hamburger-nav { display: none; background: none; border: none; cursor: pointer; flex-direction: column; gap: 5px; padding: 5px; }
.hamburger-nav span { width: 24px; height: 2px; background: var(--clr-brown-deep); border-radius: 2px; transition: all 0.3s; display: block; }
.mobile-menu { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(253,248,245,0.98); backdrop-filter: blur(20px); z-index: 998; flex-direction: column; align-items: center; justify-content: center; gap: 2rem; }
.mobile-menu.open { display: flex; }
.mobile-menu a { font-family: var(--font-display); font-size: 2rem; color: var(--clr-brown-deep); font-weight: 300; }
.mobile-close { position: absolute; top: 1.5rem; right: 2rem; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--clr-brown); }

/* HERO */
.hero {
    min-height: 100vh;
    background: linear-gradient(160deg, #FDF0EC 0%, #F5E6E0 40%, #EDD5CC 100%);
    display: flex; align-items: center; position: relative; overflow: hidden;
    padding-top: 80px;
}
.hero-bg-circle { position: absolute; border-radius: 50%; pointer-events: none; }
.hero-bg-circle-1 { width: 600px; height: 600px; background: radial-gradient(circle, rgba(232,196,196,0.25) 0%, transparent 70%); top: -100px; right: -100px; }
.hero-bg-circle-2 { width: 400px; height: 400px; background: radial-gradient(circle, rgba(201,168,124,0.15) 0%, transparent 70%); bottom: 50px; left: -50px; }
.hero-inner { max-width: 1200px; margin: 0 auto; padding: 4rem 2rem; display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; width: 100%; }
.hero-tag { display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(201,168,124,0.12); border: 1px solid rgba(201,168,124,0.3); padding: 0.4rem 1rem; border-radius: var(--r-pill); font-size: 0.78rem; font-weight: 600; color: var(--clr-brown); letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1.5rem; }
.hero-title { font-size: clamp(3rem, 5.5vw, 5.2rem); font-weight: 300; color: var(--clr-brown-deep); line-height: 1.0; margin-bottom: 1.5rem; }
.hero-title .accent { color: var(--clr-gold); font-style: italic; }
.hero-desc { font-size: 1.05rem; color: var(--clr-brown); line-height: 1.8; max-width: 440px; margin-bottom: 2.5rem; }
.hero-btns { display: flex; gap: 1rem; flex-wrap: wrap; }
.btn-hero-primary { background: var(--clr-brown-deep); color: #fff; padding: 0.9rem 2.2rem; border-radius: var(--r-pill); font-weight: 600; font-size: 0.9rem; font-family: var(--font-body); border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s; text-decoration: none; }
.btn-hero-primary:hover { background: var(--clr-gold); color: var(--clr-brown-deep); transform: translateY(-3px); box-shadow: 0 12px 30px rgba(201,168,124,0.4); }
.btn-hero-outline { background: transparent; color: var(--clr-brown-deep); padding: 0.9rem 2.2rem; border-radius: var(--r-pill); font-weight: 600; font-size: 0.9rem; font-family: var(--font-body); border: 1.5px solid rgba(61,43,31,0.3); cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s; text-decoration: none; }
.btn-hero-outline:hover { border-color: var(--clr-brown-deep); background: var(--clr-brown-deep); color: #fff; transform: translateY(-3px); }
.hero-stats { display: flex; gap: 2.5rem; margin-top: 3rem; padding-top: 2rem; border-top: 1px solid rgba(201,168,124,0.2); }
.hero-stat-num { font-family: var(--font-display); font-size: 2rem; font-weight: 600; color: var(--clr-brown-deep); line-height: 1; }
.hero-stat-label { font-size: 0.78rem; color: var(--clr-muted); margin-top: 4px; }

.hero-img-wrap { position: relative; }
.hero-img-main { width: 100%; aspect-ratio: 3/4; object-fit: cover; border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; box-shadow: 0 30px 80px rgba(107,76,59,0.2); }
.hero-img-badge { position: absolute; bottom: 30px; left: -30px; background: #fff; border-radius: 20px; padding: 1rem 1.25rem; box-shadow: 0 10px 30px rgba(107,76,59,0.12); display: flex; align-items: center; gap: 0.75rem; }
.hero-img-badge-icon { width: 44px; height: 44px; background: linear-gradient(135deg, #C9A87C, #E8D5B5); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--clr-brown-deep); font-size: 1.1rem; }
.hero-img-badge-text { font-size: 0.78rem; font-weight: 600; color: var(--clr-brown-deep); line-height: 1.4; }
.hero-img-badge-text small { font-weight: 400; color: var(--clr-muted); display: block; }
.hero-img-float { position: absolute; top: 20px; right: -15px; background: linear-gradient(135deg, #C9A87C, #E8D5B5); border-radius: 20px; padding: 0.9rem 1.2rem; box-shadow: 0 10px 25px rgba(201,168,124,0.4); text-align: center; }
.hero-img-float-num { font-family: var(--font-display); font-size: 1.5rem; font-weight: 600; color: var(--clr-brown-deep); }
.hero-img-float-label { font-size: 0.68rem; font-weight: 600; color: var(--clr-brown); }

/* SECTION */
.section { padding: 6rem 0; }
.section-alt { background: var(--clr-cream-2); }
.container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }
.section-tag { display: inline-flex; align-items: center; gap: 0.4rem; background: rgba(201,168,124,0.1); color: var(--clr-brown); padding: 0.3rem 1rem; border-radius: var(--r-pill); font-size: 0.72rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1rem; border: 1px solid rgba(201,168,124,0.25); }
.section-title { font-family: var(--font-display); font-size: clamp(2rem, 3.5vw, 2.8rem); font-weight: 600; color: var(--clr-brown-deep); margin-bottom: 1rem; }
.section-title-line { width: 60px; height: 3px; background: linear-gradient(90deg, var(--clr-gold), var(--clr-gold-light)); border-radius: var(--r-pill); margin-bottom: 1.5rem; }
.section-title-line.center { margin-left: auto; margin-right: auto; }
.section-sub { font-size: 1rem; color: var(--clr-muted); max-width: 500px; line-height: 1.8; }
.text-center { text-align: center; }
.text-center .section-sub { margin: 0 auto; }

/* PAKET GRID */
.paket-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem; margin-top: 3rem; }
.paket-card {
    background: #fff; border-radius: 24px; overflow: hidden;
    border: 1px solid rgba(232,196,196,0.2);
    box-shadow: 0 4px 20px rgba(107,76,59,0.06);
    transition: all 0.4s var(--ease);
    position: relative;
    display: flex;
    flex-direction: column;
}
.paket-card:hover { transform: translateY(-10px); box-shadow: 0 25px 60px rgba(107,76,59,0.14); border-color: rgba(201,168,124,0.4); }
.paket-card-img-wrap { overflow: hidden; position: relative; height: 220px; flex-shrink: 0; }
.paket-card-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s var(--ease); }
.paket-card:hover .paket-card-img { transform: scale(1.07); }
.paket-badge { position: absolute; top: 14px; left: 14px; padding: 0.3rem 0.85rem; border-radius: var(--r-pill); font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px; }
.paket-badge.wedding { background: linear-gradient(135deg, #C9A87C, #E8D5B5); color: var(--clr-brown-deep); }
.paket-badge.popular { background: rgba(61,43,31,0.85); color: #fff; }
.paket-body { padding: 1.5rem; flex: 1; display: flex; flex-direction: column; }
.paket-name { font-family: var(--font-display); font-size: 1.35rem; font-weight: 600; margin-bottom: 0.5rem; }
.paket-desc { font-size: 0.85rem; color: var(--clr-muted); line-height: 1.7; margin-bottom: 1.25rem; flex: 1; }
.paket-meta { display: flex; justify-content: space-between; align-items: flex-end; border-top: 1px solid rgba(232,196,196,0.3); padding-top: 1rem; margin-top: auto; }
.paket-price { font-family: var(--font-display); font-size: 1.6rem; font-weight: 600; color: var(--clr-gold); }
.paket-price small { font-size: 0.8rem; font-family: var(--font-body); color: var(--clr-muted); display: block; font-weight: 400; }
.paket-duration { display: flex; align-items: center; gap: 0.4rem; font-size: 0.8rem; color: var(--clr-muted); }
.paket-cta { display: block; background: var(--clr-brown-deep); color: #fff; text-align: center; padding: 0.85rem 1rem; border-radius: 0 0 20px 20px; font-weight: 600; font-size: 0.88rem; transition: all 0.3s; flex-shrink: 0; }
.paket-cta:hover { background: var(--clr-gold); color: var(--clr-brown-deep); }

/* PORTFOLIO */
.porto-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-top: 3rem; }
.porto-item { border-radius: 16px; overflow: hidden; position: relative; aspect-ratio: 1; }
.porto-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s var(--ease); }
.porto-item:hover img { transform: scale(1.08); }
.porto-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(61,43,31,0.7) 0%, transparent 60%); opacity: 0; transition: opacity 0.3s; display: flex; align-items: flex-end; padding: 1rem; }
.porto-item:hover .porto-overlay { opacity: 1; }
.porto-overlay-text { color: #fff; font-size: 0.82rem; font-weight: 600; }
.porto-item.large { grid-column: span 2; grid-row: span 2; }

/* CARA KERJA */
.steps-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; margin-top: 3rem; position: relative; }
.steps-grid::before { content: ''; position: absolute; top: 28px; left: 12.5%; right: 12.5%; height: 1.5px; background: linear-gradient(90deg, var(--clr-gold-light), var(--clr-rose), var(--clr-gold-light)); z-index: 0; }
.step-item { text-align: center; position: relative; z-index: 1; }
.step-circle { width: 56px; height: 56px; border-radius: 50%; background: #fff; border: 2.5px solid var(--clr-gold); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; font-family: var(--font-display); font-size: 1.3rem; font-weight: 600; color: var(--clr-gold); box-shadow: 0 4px 15px rgba(201,168,124,0.2); }
.step-title { font-family: var(--font-display); font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem; }
.step-desc { font-size: 0.83rem; color: var(--clr-muted); line-height: 1.7; }

/* TESTIMONI */
.testi-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-top: 3rem; }
.testi-card { background: #fff; border-radius: 20px; padding: 1.75rem; border: 1px solid rgba(232,196,196,0.2); transition: all 0.3s; }
.testi-card:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(107,76,59,0.1); }
.testi-stars { color: var(--clr-gold); font-size: 0.9rem; margin-bottom: 1rem; letter-spacing: 2px; }
.testi-text { font-size: 0.9rem; color: var(--clr-brown); line-height: 1.75; margin-bottom: 1.25rem; font-style: italic; }
.testi-author { display: flex; align-items: center; gap: 0.75rem; }
.testi-avatar { width: 44px; height: 44px; background: linear-gradient(135deg, var(--clr-rose), var(--clr-rose-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 1.05rem; flex-shrink: 0; }
.testi-name { font-weight: 600; font-size: 0.88rem; color: var(--clr-brown-deep); }
.testi-paket { font-size: 0.75rem; color: var(--clr-gold); margin-top: 2px; }

/* ABOUT */
.about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center; }
.about-img-wrap { position: relative; }
.about-img-main { width: 100%; aspect-ratio: 4/5; object-fit: cover; border-radius: 24px 80px 24px 80px; box-shadow: 0 20px 60px rgba(107,76,59,0.15); }
.about-img-accent { position: absolute; bottom: -20px; right: -20px; width: 160px; aspect-ratio: 1; border-radius: 24px; object-fit: cover; border: 4px solid #fff; box-shadow: var(--shadow-md); }
.about-badges { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 2rem; }
.about-badge { display: inline-flex; align-items: center; gap: 0.4rem; background: rgba(201,168,124,0.1); border: 1px solid rgba(201,168,124,0.25); padding: 0.45rem 1rem; border-radius: var(--r-pill); font-size: 0.8rem; font-weight: 600; color: var(--clr-brown); }
.about-badge i { color: var(--clr-gold); }

/* CTA SECTION */
.cta-section { background: linear-gradient(135deg, var(--clr-brown-deep) 0%, #5C3D2E 100%); padding: 5rem 0; position: relative; overflow: hidden; }
.cta-section::before { content: ''; position: absolute; top: -50%; right: -10%; width: 500px; height: 500px; border-radius: 50%; background: radial-gradient(circle, rgba(201,168,124,0.12) 0%, transparent 70%); }
.cta-inner { position: relative; z-index: 1; text-align: center; }
.cta-title { font-family: var(--font-display); font-size: clamp(2rem, 4vw, 3.5rem); color: var(--clr-gold-light); font-weight: 300; margin-bottom: 1rem; }
.cta-title span { color: var(--clr-gold); font-style: italic; }
.cta-sub { color: rgba(255,255,255,0.65); font-size: 1rem; margin-bottom: 2.5rem; }
.btn-cta { background: var(--clr-gold); color: var(--clr-brown-deep); padding: 1rem 2.5rem; border-radius: var(--r-pill); font-weight: 700; font-size: 1rem; font-family: var(--font-body); border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.6rem; transition: all 0.3s; text-decoration: none; }
.btn-cta:hover { background: #fff; transform: translateY(-4px); box-shadow: 0 15px 40px rgba(201,168,124,0.4); }

/* CONTACT */
.contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: start; }
.contact-info-item { display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1.5rem; }
.contact-info-icon { width: 44px; height: 44px; background: rgba(201,168,124,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--clr-gold); font-size: 1rem; flex-shrink: 0; border: 1px solid rgba(201,168,124,0.2); }
.contact-info-text { font-size: 0.88rem; color: var(--clr-brown); line-height: 1.6; }
.contact-info-label { font-size: 0.75rem; font-weight: 600; color: var(--clr-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px; }
.social-wrap { display: flex; gap: 0.75rem; margin-top: 2rem; }
.social-btn { width: 44px; height: 44px; border-radius: 12px; background: rgba(201,168,124,0.08); border: 1px solid rgba(201,168,124,0.2); display: flex; align-items: center; justify-content: center; color: var(--clr-gold); transition: all 0.3s; font-size: 1rem; }
.social-btn:hover { background: var(--clr-gold); color: var(--clr-brown-deep); transform: translateY(-3px); }

/* FOOTER */
.footer { background: var(--clr-brown-deep); padding: 3rem 0 2rem; }
.footer-inner { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem; }
.footer-brand { font-family: var(--font-display); font-size: 1.5rem; color: var(--clr-gold-light); }
.footer-links { display: flex; gap: 2rem; }
.footer-links a { color: rgba(255,255,255,0.5); font-size: 0.85rem; transition: color 0.3s; }
.footer-links a:hover { color: var(--clr-gold); }
.footer-copy { color: rgba(255,255,255,0.35); font-size: 0.8rem; border-top: 1px solid rgba(255,255,255,0.07); padding-top: 1.5rem; margin-top: 1.5rem; text-align: center; }

/* SCROLL REVEAL */
.reveal { opacity: 0; transform: translateY(30px); transition: all 0.7s ease; }
.reveal.visible { opacity: 1; transform: translateY(0); }

/* RESPONSIVE */
@media (max-width: 1024px) {
    .porto-grid { grid-template-columns: repeat(3, 1fr); }
    .steps-grid { grid-template-columns: repeat(2, 1fr); }
    .steps-grid::before { display: none; }
}
@media (max-width: 768px) {
    .hero-inner { grid-template-columns: 1fr; gap: 2rem; text-align: center; padding: 2rem 1.5rem; }
    .hero-btns { justify-content: center; }
    .hero-stats { justify-content: center; }
    .hero-img-wrap { order: -1; }
    .hero-img-main { border-radius: 50%; width: 280px; height: 280px; margin: 0 auto; }
    .hero-img-badge, .hero-img-float { display: none; }
    .paket-grid { grid-template-columns: 1fr 1fr; }
    .testi-grid { grid-template-columns: 1fr; }
    .about-grid { grid-template-columns: 1fr; }
    .contact-grid { grid-template-columns: 1fr; }
    .porto-grid { grid-template-columns: repeat(2, 1fr); }
    .porto-item.large { grid-column: span 1; grid-row: span 1; }
    .nav-links { display: none; }
    .hamburger-nav { display: flex; }
    .footer-inner { flex-direction: column; text-align: center; }
    .footer-links { justify-content: center; }
    .nav-btns { display: none; }
    .steps-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 480px) {
    .paket-grid { grid-template-columns: 1fr; }
    .steps-grid { grid-template-columns: 1fr; }
    .porto-grid { grid-template-columns: repeat(2, 1fr); }
}
    </style>
</head>
<body>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <button class="mobile-close" onclick="closeMobileMenu()"><i class="fas fa-times"></i></button>
    <a href="#home" onclick="closeMobileMenu()">Beranda</a>
    <a href="#paket" onclick="closeMobileMenu()">Paket</a>
    <a href="#portofolio" onclick="closeMobileMenu()">Portofolio</a>
    <a href="#testimoni" onclick="closeMobileMenu()">Testimoni</a>
    <a href="#about" onclick="closeMobileMenu()">Tentang</a>
    <a href="#contact" onclick="closeMobileMenu()">Kontak</a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="index.php?page=<?= $_SESSION['role'] === 'admin' ? 'admin/dashboard' : 'customer/dashboard' ?>" class="btn-hero-primary" style="border-radius:50px;margin-top:1rem;">Dashboard</a>
    <?php else: ?>
        <a href="index.php?page=login" style="display:inline-block;margin-top:1rem;background:var(--clr-brown-deep);color:#fff;padding:.8rem 2rem;border-radius:50px;font-weight:600;">Masuk</a>
    <?php endif; ?>
</div>

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
    <div class="nav-inner">
        <div class="nav-brand">
            <i class="fas fa-spa"></i>
            MUA ULVA
        </div>
        <ul class="nav-links">
            <li><a href="#home">Beranda</a></li>
            <li><a href="#paket">Paket</a></li>
            <li><a href="#portofolio">Portofolio</a></li>
            <li><a href="#testimoni">Testimoni</a></li>
            <li><a href="#about">Tentang</a></li>
            <li><a href="#contact">Kontak</a></li>
        </ul>
        <div class="nav-btns">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php?page=<?= $_SESSION['role'] === 'admin' ? 'admin/dashboard' : 'customer/dashboard' ?>" class="btn-nav btn-nav-solid">
                    <i class="fas fa-user me-1" style="font-size:0.8rem;"></i> Dashboard
                </a>
            <?php else: ?>
                <a href="index.php?page=login" class="btn-nav btn-nav-outline">Masuk</a>
                <a href="index.php?page=register" class="btn-nav btn-nav-solid">Daftar</a>
            <?php endif; ?>
        </div>
        <button class="hamburger-nav" onclick="openMobileMenu()">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

<!-- HERO -->
<section class="hero" id="home">
    <div class="hero-bg-circle hero-bg-circle-1"></div>
    <div class="hero-bg-circle hero-bg-circle-2"></div>
    <div class="hero-inner">
        <div class="hero-content">
            <div class="hero-tag"><i class="fas fa-star" style="color:var(--clr-gold);font-size:0.65rem;"></i> Makeup Artist Profesional — Pekanbaru</div>
            <h1 class="hero-title">
                Tampil <span class="accent">Cantik</span><br>
                di Momen<br>
                Terbaikmu
            </h1>
            <p class="hero-desc">Studio MUA ULVA hadir untuk membuat setiap momen spesialmu bersinar. Dari pernikahan sakral hingga wisuda membanggakan — kami di sini.</p>
            <div class="hero-btns">
                <a href="#paket" class="btn-hero-primary">
                    <i class="fas fa-calendar-alt"></i> Lihat Paket
                </a>
                <a href="#contact" class="btn-hero-outline">
                    <i class="fas fa-phone"></i> Hubungi Kami
                </a>
            </div>
            <div class="hero-stats">
                <div>
                    <div class="hero-stat-num" data-count="<?= date('Y') - ($studio['tahun_berdiri'] ?? 2019) ?>">0</div>
                    <div class="hero-stat-label">Tahun Pengalaman</div>
                </div>
                <div>
                    <div class="hero-stat-num" data-count="500">0</div>
                    <div class="hero-stat-label">Klien Puas</div>
                </div>
                <div>
                    <div class="hero-stat-num" data-count="<?= count($paket ?? []) ?>">0</div>
                    <div class="hero-stat-label">Paket Tersedia</div>
                </div>
            </div>
        </div>
        <div class="hero-img-wrap">
            <img src="public/img/profile.webp" 
                 alt="Studio MUA ULVA — Makeup Artist Profesional" class="hero-img-main">
            <div class="hero-img-badge">
                <div class="hero-img-badge-icon"><i class="fas fa-award"></i></div>
                <div class="hero-img-badge-text">
                    Profesional MUA
                    <small>Bersertifikat & Berpengalaman</small>
                </div>
            </div>
            <div class="hero-img-float">
                <div class="hero-img-float-num">★ 5.0</div>
                <div class="hero-img-float-label">Rating Klien</div>
            </div>
        </div>
    </div>
</section>

<!-- PAKET SECTION -->
<section class="section" id="paket">
    <div class="container">
        <div class="text-center reveal">
            <div class="section-tag"><i class="fas fa-box-open" style="font-size:0.65rem;"></i> Layanan Kami</div>
            <h2 class="section-title">Paket Makeup Pilihan</h2>
            <div class="section-title-line center"></div>
            <p class="section-sub">Setiap paket dirancang khusus untuk memenuhi kebutuhan kecantikanmu di berbagai acara istimewa.</p>
        </div>
        <div class="paket-grid">
            <?php if (!empty($paket)): ?>
                <?php foreach ($paket as $i => $p): ?>
                <div class="paket-card reveal" style="animation-delay:<?= $i * 0.1 ?>s;">
                    <div class="paket-card-img-wrap">
                        <?php if (!empty($p['gambar_utama'])): ?>
                            <img src="<?= htmlspecialchars($p['gambar_utama']) ?>" alt="<?= htmlspecialchars($p['nama_paket']) ?>" class="paket-card-img">
                        <?php else: ?>
                            <img src="public/img/pengantin.jpg" alt="<?= htmlspecialchars($p['nama_paket']) ?>" class="paket-card-img">
                        <?php endif; ?>
                        <?php if ($p['kategori'] === 'wedding'): ?>
                            <div class="paket-badge wedding">✦ Wedding</div>
                        <?php elseif ($i === 0): ?>
                            <div class="paket-badge popular">★ Populer</div>
                        <?php endif; ?>
                    </div>
                    <div class="paket-body">
                        <div class="paket-name"><?= htmlspecialchars($p['nama_paket']) ?></div>
                        <div class="paket-desc"><?= htmlspecialchars($p['deskripsi']) ?></div>
                        <div class="paket-meta">
                            <div>
                                <div class="paket-price">
                                    Rp <?= number_format($p['harga'], 0, ',', '.') ?>
                                    <small>DP <?= $p['dp_persen'] ?? 30 ?>% = Rp <?= number_format($p['harga'] * (($p['dp_persen'] ?? 30) / 100), 0, ',', '.') ?></small>
                                </div>
                            </div>
                            <div class="paket-duration">
                                <i class="far fa-clock"></i>
                                <?php if ($p['kategori'] === 'wedding'): ?>
                                    Full Day
                                <?php else: ?>
                                    ~<?= $p['durasi_jam'] ?> jam
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'customer'): ?>
                        <a href="index.php?page=customer/reservasi/create&paket_id=<?= $p['id'] ?>" class="paket-cta">
                            <i class="fas fa-calendar-plus" style="margin-right:6px;"></i> Booking Sekarang
                        </a>
                    <?php else: ?>
                        <a href="index.php?page=<?= isset($_SESSION['user_id']) ? 'admin/dashboard' : 'login' ?>&paket_id=<?= $p['id'] ?>" class="paket-cta">
                            <i class="fas fa-arrow-right" style="margin-right:6px;"></i> Pilih Paket Ini
                        </a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--clr-muted);">
                    <i class="fas fa-box-open" style="font-size:3rem;opacity:0.3;"></i>
                    <p style="margin-top:1rem;">Paket sedang dipersiapkan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- PORTOFOLIO SECTION -->
<section class="section section-alt" id="portofolio">
    <div class="container">
        <div class="text-center reveal">
            <div class="section-tag"><i class="fas fa-images" style="font-size:0.65rem;"></i> Hasil Karya</div>
            <h2 class="section-title">Portofolio & Galeri</h2>
            <div class="section-title-line center"></div>
            <p class="section-sub">Setiap riasan adalah karya seni yang kami ciptakan dengan penuh dedikasi dan kecintaan.</p>
        </div>
        <div class="porto-grid" style="margin-top:3rem;">
            <?php
            // Data dari database (maksimal 9)
            $portoImages = !empty($portofolio) ? $portofolio : [];
            $displayImgs = array_slice($portoImages, 0, 9);

            // Daftar placeholder untuk mengisi slot kosong
            $placeholders = [
                'public/img/wisuda1.jpeg',
                'public/img/wisuda2.jpeg',
                'public/img/pengantin2.jpeg',
                'public/img/pengantin1.jpeg',
                'public/img/party2.webp',
                'public/img/party1.jpeg',
                'public/img/glam.jpeg',
                'public/img/glam1.jpeg',
                'public/img/glam2.jpeg',
                'public/img/glam3.webp',
                'public/img/glam.webp'
            ];

            // Gambar default jika semua file tidak ditemukan (pastikan file ini ada)
            $defaultImg = 'public/img/glam.webp';

            for ($i = 0; $i < 9; $i++):
                // 1. Tentukan path gambar dari database atau placeholder
                if (isset($displayImgs[$i])) {
                    $imgPath = $displayImgs[$i]['gambar'] ?? '';
                } else {
                    $imgPath = $placeholders[$i] ?? $defaultImg;
                }

                // 2. Jika path kosong atau file tidak ada, gunakan default
                if (empty($imgPath) || !file_exists($imgPath)) {
                    $imgPath = $defaultImg;
                }

                // 3. Ambil caption (judul)
                if (isset($displayImgs[$i])) {
                    $caption = $displayImgs[$i]['caption'] ?? $displayImgs[$i]['nama_paket'] ?? 'Karya MUA ULVA';
                } else {
                    $caption = 'Karya MUA ULVA';
                }

                $isLarge = ($i === 0 || $i === 5);
            ?>
            <div class="porto-item <?= $isLarge ? 'large' : '' ?> reveal" style="animation-delay:<?= $i * 0.07 ?>s;">
                <img src="<?= htmlspecialchars($imgPath) ?>" alt="<?= htmlspecialchars($caption) ?>">
                <div class="porto-overlay">
                    <span class="porto-overlay-text"><i class="fas fa-spa me-1"></i> <?= htmlspecialchars($caption) ?></span>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- CARA KERJA -->
<section class="section" id="cara-kerja">
    <div class="container">
        <div class="text-center reveal">
            <div class="section-tag"><i class="fas fa-route" style="font-size:0.65rem;"></i> Cara Booking</div>
            <h2 class="section-title">Mudah & Cepat dalam 4 Langkah</h2>
            <div class="section-title-line center"></div>
        </div>
        <div class="steps-grid">
            <div class="step-item reveal delay-1">
                <div class="step-circle">1</div>
                <h4 class="step-title">Pilih Paket</h4>
                <p class="step-desc">Temukan paket makeup yang sesuai dengan kebutuhan dan anggaran acara Anda.</p>
            </div>
            <div class="step-item reveal delay-2">
                <div class="step-circle">2</div>
                <h4 class="step-title">Login / Daftar</h4>
                <p class="step-desc">Masuk ke akun Anda atau daftar baru dalam hitungan detik untuk melanjutkan booking.</p>
            </div>
            <div class="step-item reveal delay-3">
                <div class="step-circle">3</div>
                <h4 class="step-title">Pilih Jadwal</h4>
                <p class="step-desc">Pilih tanggal dan waktu yang tersedia. Sistem kami otomatis mencegah double booking.</p>
            </div>
            <div class="step-item reveal delay-4">
                <div class="step-circle">4</div>
                <h4 class="step-title">Bayar DP & Konfirmasi</h4>
                <p class="step-desc">Transfer DP melalui WhatsApp admin untuk konfirmasi booking dan detil pelaksanaan.</p>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONI -->
<section class="section section-alt" id="testimoni">
    <div class="container">
        <div class="text-center reveal">
            <div class="section-tag"><i class="fas fa-heart" style="font-size:0.65rem;"></i> Kata Mereka</div>
            <h2 class="section-title">Testimoni Klien Kami</h2>
            <div class="section-title-line center"></div>
            <p class="section-sub">Kepuasan klien adalah kebanggaan kami. Inilah cerita mereka.</p>
        </div>
        <div class="testi-grid">
            <?php if (!empty($testimoni)): ?>
                <?php foreach (array_slice($testimoni, 0, 6) as $i => $t): ?>
                <div class="testi-card reveal" style="animation-delay:<?= $i * 0.1 ?>s;">
                    <div class="testi-stars"><?= str_repeat('★', min((int)($t['rating'] ?? 5), 5)) ?></div>
                    <p class="testi-text">"<?= htmlspecialchars($t['isi'] ?? '') ?>"</p>
                    <div class="testi-author">
                        <div class="testi-avatar"><?= strtoupper(substr($t['nama'] ?? '?', 0, 1)) ?></div>
                        <div>
                            <div class="testi-name"><?= htmlspecialchars($t['nama'] ?? 'Anonim') ?></div>
                            <?php if (!empty($t['paket'])): ?>
                                <div class="testi-paket"><i class="fas fa-spa" style="font-size:0.65rem;margin-right:3px;"></i> <?= htmlspecialchars($t['paket']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--clr-muted);">Belum ada testimoni. Jadilah yang pertama!</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ABOUT -->
<section class="section" id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-img-wrap reveal">
                <img src="public/img/glam.jpeg" 
                     alt="Studio MUA ULVA" class="about-img-main">
                <img src="public/img/glam1.jpeg"
                     alt="Detail riasan" class="about-img-accent">
            </div>
            <div class="reveal delay-2">
                <div class="section-tag"><i class="fas fa-user-circle" style="font-size:0.65rem;"></i> Tentang Studio</div>
                <h2 class="section-title">Studio MUA ULVA —<br><em style="font-weight:300;">Lebih dari Sekadar Riasan</em></h2>
                <div class="section-title-line"></div>
                <p style="color:var(--clr-brown);line-height:1.85;margin-bottom:1rem;font-size:0.95rem;"><?= htmlspecialchars($studio['deskripsi'] ?? 'Deskripsi studio') ?></p>
                <div style="display:flex;flex-direction:column;gap:0.75rem;margin-bottom:1.75rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;font-size:0.88rem;color:var(--clr-brown);">
                        <i class="fas fa-user-circle" style="color:var(--clr-gold);width:18px;"></i>
                        <span><strong>Pemilik:</strong> <?= htmlspecialchars($studio['pemilik'] ?? 'ULVA') ?></span>
                    </div>
                    <div style="display:flex;align-items:center;gap:0.75rem;font-size:0.88rem;color:var(--clr-brown);">
                        <i class="fas fa-map-pin" style="color:var(--clr-gold);width:18px;"></i>
                        <span><?= htmlspecialchars($studio['alamat'] ?? 'Alamat') ?></span>
                    </div>
                    <div style="display:flex;align-items:center;gap:0.75rem;font-size:0.88rem;color:var(--clr-brown);">
                        <i class="fas fa-clock" style="color:var(--clr-gold);width:18px;"></i>
                        <span><?= htmlspecialchars($studio['jam_operasional'] ?? '08:00 - 20:00') ?></span>
                    </div>
                </div>
                <div class="about-badges">
                    <span class="about-badge"><i class="fas fa-check-circle"></i> MUA Profesional</span>
                    <span class="about-badge"><i class="fas fa-check-circle"></i> Produk Premium</span>
                    <span class="about-badge"><i class="fas fa-check-circle"></i> On-site & Studio</span>
                    <span class="about-badge"><i class="fas fa-check-circle"></i> +500 Klien Puas</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="cta
-section">
    <div class="container">
        <div class="cta-inner reveal">
            <h2 class="cta-title">Siap Tampil <span>Memukau?</span></h2>
            <p class="cta-sub">Booking sekarang dan wujudkan tampilan impianmu bersama MUA ULVA</p>
            <a href="<?= isset($_SESSION['user_id']) ? 'index.php?page=customer/reservasi/create' : 'index.php?page=login' ?>" class="btn-cta">
                <i class="fas fa-calendar-plus"></i> Booking Sekarang
            </a>
        </div>
    </div>
</section>

<!-- CONTACT -->
<section class="section" id="contact">
    <div class="container">
        <div class="text-center reveal">
            <div class="section-tag"><i class="fas fa-envelope" style="font-size:0.65rem;"></i> Hubungi Kami</div>
            <h2 class="section-title">Ada Pertanyaan?</h2>
            <div class="section-title-line center"></div>
            <p class="section-sub">Kami siap membantu Anda. Jangan ragu untuk menghubungi kami!</p>
        </div>
        <div class="contact-grid" style="margin-top:3rem;">
            <div class="reveal">
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <div class="contact-info-label">Alamat Studio</div>
                        <div class="contact-info-text"><?= htmlspecialchars($studio['alamat'] ?? 'Alamat') ?></div>
                    </div>
                </div>
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <div class="contact-info-label">Telepon / WhatsApp</div>
                        <div class="contact-info-text"><?= htmlspecialchars($studio['telepon'] ?? '+62 812-3456-7890') ?></div>
                    </div>
                </div>
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div class="contact-info-label">Email</div>
                        <div class="contact-info-text"><?= htmlspecialchars($studio['email'] ?? 'info@muaulva.com') ?></div>
                    </div>
                </div>
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="fas fa-clock"></i></div>
                    <div>
                        <div class="contact-info-label">Jam Operasional</div>
                        <div class="contact-info-text"><?= htmlspecialchars($studio['jam_operasional'] ?? '08:00 - 20:00') ?></div>
                    </div>
                </div>
                <div class="social-wrap">
                    <a href="https://www.instagram.com/<?= htmlspecialchars($studio['instagram'] ?? 'muaulva') ?>" target="_blank" class="social-btn"><i class="fab fa-instagram"></i></a>
                    <a href="https://tiktok.com/@<?= htmlspecialchars($studio['tiktok'] ?? 'muaulva') ?>" target="_blank" class="social-btn"><i class="fab fa-tiktok"></i></a>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $studio['whatsapp'] ?? '6281234567890') ?>" target="_blank" class="social-btn"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="reveal delay-2">
                <div style="background:#fff;border-radius:24px;padding:2rem;border:1px solid rgba(232,196,196,0.25);box-shadow:0 8px 30px rgba(107,76,59,0.08);">
                    <h3 style="font-family:var(--font-display);font-size:1.5rem;margin-bottom:1.5rem;">Kirim Pesan</h3>
                    <form id="contactForm" onsubmit="https://web.whatsapp.com/">
                        <div style="margin-bottom:1rem;">
                            <label style="display:block;font-size:0.8rem;font-weight:600;color:var(--clr-brown);margin-bottom:0.4rem;">Nama Lengkap</label>
                            <input type="text" id="contactName" placeholder="Nama Anda" required style="width:100%;padding:0.8rem 1.2rem;border-radius:50px;border:1.5px solid rgba(232,196,196,0.5);background:var(--clr-cream);font-family:var(--font-body);font-size:0.9rem;outline:none;transition:border 0.3s;" onfocus="this.style.borderColor='var(--clr-gold)'" onblur="this.style.borderColor='rgba(232,196,196,0.5)'">
                        </div>
                        <div style="margin-bottom:1rem;">
                            <label style="display:block;font-size:0.8rem;font-weight:600;color:var(--clr-brown);margin-bottom:0.4rem;">Nomor WhatsApp</label>
                            <input type="tel" id="contactPhone" placeholder="08xx-xxxx-xxxx" required style="width:100%;padding:0.8rem 1.2rem;border-radius:50px;border:1.5px solid rgba(232,196,196,0.5);background:var(--clr-cream);font-family:var(--font-body);font-size:0.9rem;outline:none;transition:border 0.3s;" onfocus="this.style.borderColor='var(--clr-gold)'" onblur="this.style.borderColor='rgba(232,196,196,0.5)'">
                        </div>
                        <div style="margin-bottom:1.5rem;">
                            <label style="display:block;font-size:0.8rem;font-weight:600;color:var(--clr-brown);margin-bottom:0.4rem;">Pesan</label>
                            <textarea id="contactMessage" placeholder="Ceritakan kebutuhan makeup Anda..." required style="width:100%;padding:0.8rem 1.2rem;border-radius:16px;border:1.5px solid rgba(232,196,196,0.5);background:var(--clr-cream);font-family:var(--font-body);font-size:0.9rem;outline:none;resize:vertical;min-height:110px;transition:border 0.3s;" onfocus="this.style.borderColor='var(--clr-gold)'" onblur="this.style.borderColor='rgba(232,196,196,0.5)'"></textarea>
                        </div>
                        <button type="submit" style="display:flex;align-items:center;justify-content:center;gap:0.5rem;background:#25D366;color:#fff;padding:0.9rem;border-radius:50px;font-weight:600;font-size:0.9rem;text-decoration:none;transition:all 0.3s;width:100%;border:none;cursor:pointer;" onmouseover="this.style.background='#1da855'" onmouseout="this.style.background='#25D366'">
                            <i class="fab fa-whatsapp"></i> Kirim via WhatsApp
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <div class="footer-inner">
            <div class="footer-brand"><i class="fas fa-spa" style="color:var(--clr-gold);margin-right:0.5rem;"></i> MUA ULVA</div>
            <div class="footer-links">
                <a href="#home">Beranda</a>
                <a href="#paket">Paket</a>
                <a href="#testimoni">Testimoni</a>
                <a href="#about">Tentang</a>
                <a href="#contact">Kontak</a>
            </div>
        </div>
        <div class="footer-copy">
            &copy; <?= date('Y') ?> Studio MUA ULVA — <?= htmlspecialchars($studio['alamat'] ?? '') ?>
            
        </div>
    </div>
</footer>

<script>
// Navbar scroll effect
window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    navbar.classList.toggle('scrolled', window.scrollY > 60);
});

// Mobile menu
function openMobileMenu() { document.getElementById('mobileMenu').classList.add('open'); document.body.style.overflow = 'hidden'; }
function closeMobileMenu() { document.getElementById('mobileMenu').classList.remove('open'); document.body.style.overflow = ''; }

// Scroll reveal
const revealElements = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) { entry.target.classList.add('visible'); observer.unobserve(entry.target); }
    });
}, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
revealElements.forEach(el => observer.observe(el));

// Animated counter
function animateCounter(el, target) {
    let current = 0;
    const step = Math.ceil(target / 60);
    const timer = setInterval(() => {
        current = Math.min(current + step, target);
        el.textContent = current + (target >= 100 ? '+' : '');
        if (current >= target) clearInterval(timer);
    }, 25);
}
const counters = document.querySelectorAll('[data-count]');
const countObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            animateCounter(entry.target, parseInt(entry.target.getAttribute('data-count')));
            countObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });
counters.forEach(c => countObserver.observe(c));

// Smooth scroll for nav links
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault();
        const target = document.querySelector(a.getAttribute('href'));
        if (target) target.scrollIntoView({ behavior: 'smooth' });
    });
});
</script>
</body>
</html>