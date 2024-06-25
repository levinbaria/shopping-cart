document.addEventListener('DOMContentLoaded', function () {

    const navLinks = document.querySelectorAll('.nav__link');

    navLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            const submenu = link.nextElementSibling;
            const arrowIcon = link.querySelector('.fa-chevron-right');
            if (submenu && submenu.classList.contains('submenu')) {
                event.preventDefault();
                const openSubmenus = document.querySelectorAll('.submenu.submenu--open');
                openSubmenus.forEach(openSubmenu => {
                    if (openSubmenu !== submenu) {
                        openSubmenu.classList.remove('submenu--open');
                        const openArrowIcon = openSubmenu.previousElementSibling.querySelector('.fa-chevron-right');
                        if (openArrowIcon) {
                            openArrowIcon.classList.remove('rotate-icon');
                        }
                    }
                });
                submenu.classList.toggle('submenu--open');
                arrowIcon.classList.toggle('rotate-icon'); // Toggled the rotation class
            }
        });
    });
});
