/**
 * La Fioreria di Anna - Funzionalità Statiche
 */

document.addEventListener('DOMContentLoaded', () => {
    // Inizializza le icone Lucide
    if (window.lucide) {
        window.lucide.createIcons();
    }

    // Toggle menu mobile
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            const isOpen = !mobileMenu.classList.contains('hidden');
            if (isOpen) {
                mobileMenu.classList.add('hidden');
            } else {
                mobileMenu.classList.remove('hidden');
            }
        });
    }

    // Menu mobile toggle (già presente, mantenuto per core funzionalità)
});
