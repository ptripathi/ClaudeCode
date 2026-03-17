/* Village Connect — main.js */
(function () {
  'use strict';

  /* ----------------------------------------------------------------
     Sticky Header
  ---------------------------------------------------------------- */
  const header = document.getElementById('site-header');

  function updateHeader() {
    if (!header) return;
    if (window.scrollY > 60) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  }

  window.addEventListener('scroll', updateHeader, { passive: true });
  updateHeader();

  /* ----------------------------------------------------------------
     Mobile Menu
  ---------------------------------------------------------------- */
  const menuToggle  = document.getElementById('menu-toggle');
  const primaryNav  = document.getElementById('primary-nav');
  const navBackdrop = document.getElementById('nav-backdrop');

  function openMenu() {
    primaryNav.classList.add('open');
    navBackdrop.classList.add('active');
    menuToggle.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }

  function closeMenu() {
    primaryNav.classList.remove('open');
    navBackdrop.classList.remove('active');
    menuToggle.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  if (menuToggle) {
    menuToggle.addEventListener('click', function () {
      const isOpen = primaryNav.classList.contains('open');
      isOpen ? closeMenu() : openMenu();
    });
  }

  if (navBackdrop) navBackdrop.addEventListener('click', closeMenu);

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeMenu();
  });

  /* ----------------------------------------------------------------
     Hero parallax (subtle scale on load)
  ---------------------------------------------------------------- */
  const heroBg = document.querySelector('.hero-bg');
  if (heroBg) {
    // trigger the CSS transition
    requestAnimationFrame(function () {
      heroBg.style.transform = 'scale(1)';
    });
  }

  /* ----------------------------------------------------------------
     Scroll-reveal via Intersection Observer
  ---------------------------------------------------------------- */
  const revealEls = document.querySelectorAll('.reveal');

  if ('IntersectionObserver' in window && revealEls.length) {
    const revealObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            revealObserver.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12, rootMargin: '0px 0px -60px 0px' }
    );

    revealEls.forEach(function (el) {
      revealObserver.observe(el);
    });
  } else {
    // Fallback: show all immediately
    revealEls.forEach(function (el) {
      el.classList.add('visible');
    });
  }

  /* ----------------------------------------------------------------
     Animated stat counters
  ---------------------------------------------------------------- */
  const statNumbers = document.querySelectorAll('.stat-number[data-target]');

  if (statNumbers.length && 'IntersectionObserver' in window) {
    const counterObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          const el     = entry.target;
          const target = parseFloat(el.dataset.target);
          const suffix = el.dataset.suffix || '';
          const isFloat = target % 1 !== 0;
          const duration = 1800;
          const start  = performance.now();

          function step(now) {
            const progress = Math.min((now - start) / duration, 1);
            // ease-out cubic
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = target * eased;
            el.textContent = (isFloat
              ? current.toFixed(1)
              : Math.round(current).toLocaleString('en-IN')
            ) + suffix;
            if (progress < 1) requestAnimationFrame(step);
          }

          requestAnimationFrame(step);
          counterObserver.unobserve(el);
        });
      },
      { threshold: 0.5 }
    );

    statNumbers.forEach(function (el) {
      counterObserver.observe(el);
    });
  }

  /* ----------------------------------------------------------------
     Lazy-load video iframes (YouTube / Vimeo)
     Replaces data-src with src only when scrolled into view
  ---------------------------------------------------------------- */
  const lazyIframes = document.querySelectorAll('iframe[data-src]');

  if (lazyIframes.length && 'IntersectionObserver' in window) {
    const iframeObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          const iframe = entry.target;
          iframe.src = iframe.dataset.src;
          delete iframe.dataset.src;
          iframeObserver.unobserve(iframe);
        });
      },
      { rootMargin: '200px' }
    );

    lazyIframes.forEach(function (iframe) {
      iframeObserver.observe(iframe);
    });
  }

  /* ----------------------------------------------------------------
     Smooth scroll for in-page anchor links
  ---------------------------------------------------------------- */
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      const target = document.querySelector(anchor.getAttribute('href'));
      if (!target) return;
      e.preventDefault();
      closeMenu();
      const headerH = header ? header.offsetHeight : 0;
      const top     = target.getBoundingClientRect().top + window.scrollY - headerH - 16;
      window.scrollTo({ top: top, behavior: 'smooth' });
    });
  });

})();
