import './stimulus_bootstrap.js';
import './styles/app.css';

document.addEventListener('DOMContentLoaded', () => {
    const navLinks = Array.from(document.querySelectorAll('[data-home-nav-link]'));

    if (navLinks.length > 0) {
        navLinks.forEach((link) => {
            link.addEventListener('click', (event) => {
                const targetId = link.getAttribute('href');

                if (!targetId || !targetId.startsWith('#')) {
                    return;
                }

                const target = document.querySelector(targetId);
                const nav = document.querySelector('.home-nav');

                if (!target || !nav) {
                    return;
                }

                event.preventDefault();

                const navHeight = nav.offsetHeight;
                const targetTop = window.scrollY + target.getBoundingClientRect().top - navHeight;

                window.scrollTo({
                    top: targetTop,
                    behavior: 'smooth',
                });
            });
        });
    }

    const toggleButtons = Array.from(document.querySelectorAll('[data-home-toggle]'));

    if (toggleButtons.length === 0) {
        return;
    }

    toggleButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const panelName = button.dataset.homeToggle;
            const panel = document.querySelector(`[data-home-panel="${panelName}"]`);

            if (!panel) {
                return;
            }

            const isOpen = !panel.hidden;

            button.setAttribute('aria-expanded', isOpen ? 'false' : 'true');

            if (isOpen) {
                panel.style.maxHeight = `${panel.scrollHeight}px`;
                panel.classList.remove('home-expandable-panel-open');

                window.requestAnimationFrame(() => {
                    panel.style.maxHeight = '0px';
                });

                window.setTimeout(() => {
                    panel.hidden = true;
                    panel.style.maxHeight = '';
                }, 500);

                return;
            }

            panel.hidden = false;
            panel.style.maxHeight = '0px';

            window.requestAnimationFrame(() => {
                panel.style.maxHeight = `${panel.scrollHeight}px`;
                panel.classList.add('home-expandable-panel-open');
            });

            window.setTimeout(() => {
                panel.style.maxHeight = 'none';
            }, 500);
        });
    });
});
