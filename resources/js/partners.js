/**
 * Partners Section Script
 * - Fade-in on scroll (Intersection Observer)
 * - Glow hover follow cursor (shadcn style)
 */

document.addEventListener('DOMContentLoaded', () => {
    /* ================= Fade-in on Scroll ================= */
    const fadeElements = document.querySelectorAll('.partner-fade');

    if (fadeElements.length) {
        const observer = new IntersectionObserver(
            entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove(
                            'opacity-0',
                            'translate-y-6'
                        );
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.15 }
        );

        fadeElements.forEach(el => observer.observe(el));
    }

    /* ================= Glow Follow Cursor ================= */
    const partnerCards = document.querySelectorAll('.partner-card');

    partnerCards.forEach(card => {
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            card.style.setProperty('--x', `${x}px`);
            card.style.setProperty('--y', `${y}px`);
        });
    });
});
