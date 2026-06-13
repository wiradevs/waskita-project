import './bootstrap';

// ── Scroll Animations ──────────────────────────────────
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

document.querySelectorAll('[data-animate]').forEach(el => observer.observe(el));

// ── Navbar Scroll Effect ───────────────────────────────
const navbar = document.getElementById('main-navbar');
if (navbar) {
    const onScroll = () => {
        navbar.classList.toggle('nav-scrolled', window.scrollY > 60);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

// ── Mobile Menu ────────────────────────────────────────
const menuBtn    = document.getElementById('mobile-menu-btn');
const mobileMenu = document.getElementById('mobile-menu');
if (menuBtn && mobileMenu) {
    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('open');
        const open = mobileMenu.classList.contains('open');
        menuBtn.querySelector('.icon-open').classList.toggle('hidden', open);
        menuBtn.querySelector('.icon-close').classList.toggle('hidden', !open);
    });
}

// ── Hero Video Controls ────────────────────────────────
const heroVideo    = document.getElementById('hero-video');
const toggleBtn    = document.getElementById('video-toggle');
const iconPause    = document.getElementById('icon-pause');
const iconPlay     = document.getElementById('icon-play');
const progressBar  = document.getElementById('video-progress');

if (heroVideo) {
    // Progress bar update
    if (progressBar) {
        heroVideo.addEventListener('timeupdate', () => {
            if (heroVideo.duration) {
                const pct = (heroVideo.currentTime / heroVideo.duration) * 100;
                progressBar.style.width = pct + '%';
            }
        });
        // Reset on loop
        heroVideo.addEventListener('seeked', () => {
            if (heroVideo.currentTime === 0) progressBar.style.width = '0%';
        });
    }

    // Pause / Play toggle
    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            if (heroVideo.paused) {
                heroVideo.play();
                iconPause.style.display = '';
                iconPlay.style.display  = 'none';
            } else {
                heroVideo.pause();
                iconPause.style.display = 'none';
                iconPlay.style.display  = '';
            }
        });
    }
}

// ── Hero Mouse Parallax ────────────────────────────────
const heroSection = document.getElementById('hero-section');
const par1 = document.getElementById('par-1');
const par2 = document.getElementById('par-2');
const par3 = document.getElementById('par-3');

if (heroSection) {
    let rafId = null;
    let targetX = 0, targetY = 0;
    let currentX = 0, currentY = 0;

    heroSection.addEventListener('mousemove', (e) => {
        const rect = heroSection.getBoundingClientRect();
        targetX = (e.clientX - rect.left)  / rect.width  - 0.5;
        targetY = (e.clientY - rect.top)   / rect.height - 0.5;

        if (!rafId) {
            const tick = () => {
                currentX += (targetX - currentX) * 0.055;
                currentY += (targetY - currentY) * 0.055;

                // par-1: large slow drift (video bg or orb)
                if (par1) par1.style.transform = `translate(${currentX * -30}px, ${currentY * -20}px)`;
                // par-2: medium ring
                if (par2) par2.style.transform = `translate(${currentX * 18}px, ${currentY * 14}px)`;
                // par-3: small diamond
                if (par3) par3.style.transform = `rotate(${45 + currentX * 12}deg) translate(${currentX * 10}px, ${currentY * 8}px)`;

                const dist = Math.abs(targetX - currentX) + Math.abs(targetY - currentY);
                rafId = dist > 0.001 ? requestAnimationFrame(tick) : null;
            };
            rafId = requestAnimationFrame(tick);
        }
    });

    heroSection.addEventListener('mouseleave', () => {
        targetX = 0; targetY = 0;
    });
}

// ── Hero Stats Counter ─────────────────────────────────
function animateCounter(el) {
    const target   = parseInt(el.dataset.target, 10);
    const suffix   = el.dataset.suffix || '';
    const duration = 1600;
    const frameDur = 16;
    const total    = duration / frameDur;
    let frame = 0;

    const easeOut = (t) => 1 - Math.pow(1 - t, 3);
    const format  = (n) => n >= 1000 ? (n / 1000).toFixed(0) + 'K' : String(n);

    const timer = setInterval(() => {
        frame++;
        const progress = easeOut(Math.min(frame / total, 1));
        const current  = Math.round(target * progress);
        el.textContent = format(current) + suffix;
        if (frame >= total) {
            el.textContent = format(target) + suffix;
            clearInterval(timer);
        }
    }, frameDur);
}

setTimeout(() => {
    document.querySelectorAll('.hero-stat').forEach(animateCounter);
}, 2100);

// ── Product image gallery (detail page) ───────────────
window.changeImage = (src) => {
    const main = document.getElementById('main-image');
    if (!main) return;
    main.style.opacity = '0';
    main.style.transform = 'scale(1.03)';
    setTimeout(() => {
        main.src = src;
        main.style.opacity = '1';
        main.style.transform = 'scale(1)';
    }, 220);
};
