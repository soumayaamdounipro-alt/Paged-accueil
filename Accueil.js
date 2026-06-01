/* ══════════════════════════════════════════
   COOK WITH SOUMI — script.js
   ══════════════════════════════════════════ */
 
/* ── NAVBAR : ombre au scroll ── */
const navbar = document.getElementById('navbar');
 
window.addEventListener('scroll', () => {
  navbar.classList.toggle('scrolled', window.scrollY > 20);
});
 
/* ── REVEAL AU SCROLL (Intersection Observer) ── */
const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
    }
  });
}, { threshold: 0.15 });
 
document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));
 
/* ── FORMULAIRE NEWSLETTER ── */
const newsletterForm = document.getElementById('newsletterForm');
 
if (newsletterForm) {
  newsletterForm.addEventListener('submit', (e) => {
    e.preventDefault();
 
    const btn = newsletterForm.querySelector('button');
    const originalText = btn.textContent;
 
    btn.textContent = '🎉 Merci !';
    btn.style.background = '#27500A';
    btn.disabled = true;
 
    setTimeout(() => {
      btn.textContent = originalText;
      btn.style.background = '';
      btn.disabled = false;
      newsletterForm.reset();
    }, 3000);
  });
}
 
/* ── SMOOTH SCROLL pour les liens d'ancre ── */
document.querySelectorAll('a[href^="#"]').forEach(link => {
  link.addEventListener('click', (e) => {
    const target = document.querySelector(link.getAttribute('href'));
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});