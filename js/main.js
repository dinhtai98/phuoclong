// ============================================
//  PCCC PHƯỚC LONG — main.js
//  Menu, scroll, filter, counter, AOS, floats
// ============================================

document.addEventListener('DOMContentLoaded', () => {
  initScrollProgress();
  initHeader();
  initHamburger();
  initAOS();
  initCounters();
  initScrollToTop();
  initProjectFilter();
  setActiveNavLink();
});

// ─── Scroll Progress Bar ──────────────────────
function initScrollProgress() {
  const bar = document.getElementById('scroll-progress');
  if (!bar) return;
  window.addEventListener('scroll', () => {
    const scrolled = window.scrollY;
    const total = document.documentElement.scrollHeight - window.innerHeight;
    bar.style.width = total > 0 ? `${(scrolled / total) * 100}%` : '0%';
  }, { passive: true });
}

// ─── Sticky Header ────────────────────────────
function initHeader() {
  const header = document.querySelector('.header');
  if (!header) return;
  const threshold = 60;
  const update = () => {
    const scrolled = window.scrollY > threshold;
    header.classList.toggle('header--scrolled', scrolled);
    header.classList.toggle('header--transparent', !scrolled);
  };
  update();
  window.addEventListener('scroll', update, { passive: true });
}

// ─── Hamburger Mobile Menu ────────────────────
function initHamburger() {
  const btn  = document.querySelector('.hamburger');
  const nav  = document.querySelector('.mobile-nav');
  if (!btn || !nav) return;

  btn.addEventListener('click', () => {
    const open = btn.classList.toggle('active');
    nav.classList.toggle('active', open);
    document.body.style.overflow = open ? 'hidden' : '';
  });

  // Close on link click
  nav.querySelectorAll('.mobile-nav__link').forEach(link => {
    link.addEventListener('click', () => {
      btn.classList.remove('active');
      nav.classList.remove('active');
      document.body.style.overflow = '';
    });
  });

  // Close on backdrop click
  nav.addEventListener('click', e => {
    if (e.target === nav) {
      btn.classList.remove('active');
      nav.classList.remove('active');
      document.body.style.overflow = '';
    }
  });
}

// ─── AOS (Animate On Scroll) ──────────────────
function initAOS() {
  const elements = document.querySelectorAll('[data-aos]');
  if (!elements.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('aos-animate');
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

  elements.forEach(el => observer.observe(el));
}

// ─── Counter Animation ────────────────────────
function initCounters() {
  const counters = document.querySelectorAll('[data-count]');
  if (!counters.length) return;

  const ease = t => t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;

  const animateCounter = (el) => {
    const target  = parseFloat(el.dataset.count);
    const suffix  = el.dataset.suffix || '';
    const prefix  = el.dataset.prefix || '';
    const decimal = el.dataset.decimal ? parseInt(el.dataset.decimal) : 0;
    const duration = 2000;
    let start = null;

    const step = (timestamp) => {
      if (!start) start = timestamp;
      const progress = Math.min((timestamp - start) / duration, 1);
      const current  = target * ease(progress);
      el.textContent = prefix + current.toFixed(decimal) + suffix;
      if (progress < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting && !entry.target.dataset.done) {
        entry.target.dataset.done = 'true';
        animateCounter(entry.target);
      }
    });
  }, { threshold: 0.5 });

  counters.forEach(el => observer.observe(el));
}

// ─── Scroll To Top Button ─────────────────────
function initScrollToTop() {
  const btn = document.querySelector('.float-btn--top');
  if (!btn) return;
  window.addEventListener('scroll', () => {
    btn.classList.toggle('visible', window.scrollY > 400);
  }, { passive: true });
  btn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

// ─── Project Filter ───────────────────────────
function initProjectFilter() {
  const filterBtns = document.querySelectorAll('[data-filter]');
  const cards      = document.querySelectorAll('[data-category]');
  if (!filterBtns.length || !cards.length) return;

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const filter = btn.dataset.filter;

      cards.forEach(card => {
        const show = filter === 'all' || card.dataset.category === filter;
        card.style.display = show ? '' : 'none';
        if (show) {
          card.style.animation = 'scaleIn 0.35s ease both';
        }
      });
    });
  });
}

// ─── Active Nav Link Highlight ────────────────
function setActiveNavLink() {
  const path = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav__link').forEach(link => {
    const href = link.getAttribute('href');
    if (href && (href === path || (path === '' && href === 'index.html'))) {
      link.classList.add('active');
    }
  });
}

// ─── Smooth Scroll for anchor links ──────────
document.querySelectorAll('a[href^="#"]').forEach(link => {
  link.addEventListener('click', e => {
    const id = link.getAttribute('href').slice(1);
    const target = id ? document.getElementById(id) : null;
    if (target) {
      e.preventDefault();
      const top = target.getBoundingClientRect().top + window.scrollY - 90;
      window.scrollTo({ top, behavior: 'smooth' });
    }
  });
});
