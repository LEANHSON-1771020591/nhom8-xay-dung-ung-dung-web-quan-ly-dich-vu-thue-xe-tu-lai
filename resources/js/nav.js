document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('menuBtn');
    var nav = document.getElementById('mobileNav');

    if (!btn || !nav) return;

    var bars = btn.querySelectorAll('span');

    btn.addEventListener('click', function () {
        var expanded = btn.getAttribute('aria-expanded') === 'true';
        btn.setAttribute('aria-expanded', (!expanded).toString());

        // Toggle show/hide mobile nav
        nav.classList.toggle('hidden');

        // Animate hamburger to "X"
        if (bars[0]) {
            bars[0].classList.toggle('-rotate-45');
            bars[0].classList.toggle('-translate-x-1');
            bars[0].classList.toggle('translate-y-1.5');
        }

        if (bars[1]) {
            bars[1].classList.toggle('opacity-0');
        }

        if (bars[2]) {
            bars[2].classList.toggle('rotate-45');
            bars[2].classList.toggle('-translate-x-1');
            bars[2].classList.toggle('-translate-y-1.5');
        }
    });
});