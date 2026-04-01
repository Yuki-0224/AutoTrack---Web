const parallaxLayers = document.querySelectorAll('.parallax-layer');

window.addEventListener('scroll', () => {
    const scrollTop = window.pageYOffset;
    parallaxLayers.forEach(layer => {
        const speed = parseFloat(layer.dataset.speed) || 0;
        layer.style.transform = `translate3d(0, ${scrollTop * speed}px, 0)`;
    });
});

const themeToggle = document.getElementById('theme-toggle');
const themeLabel = document.getElementById('theme-toggle-label');

function setTheme(theme) {
    const isDark = theme === 'dark';
    document.documentElement.classList.toggle('dark', isDark);
    if (themeToggle) themeToggle.classList.toggle('active', isDark);
    if (themeLabel) themeLabel.textContent = isDark ? 'Dark' : 'Light';
    localStorage.setItem('theme', theme);
}

function initTheme() {
    const savedTheme = localStorage.getItem('theme');
    const preferredTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    setTheme(savedTheme || preferredTheme);
}

window.addEventListener('DOMContentLoaded', () => {
    initTheme();
    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            setTheme(document.documentElement.classList.contains('dark') ? 'light' : 'dark');
        });
    }
});
