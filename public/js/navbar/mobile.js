$(() => {
    const $menuIcon = $('#menu-hambuguer-icon');
    const $menuIconCloser = $('#menu-hambuguer-icon-closer');
    const $mainNav = $('.main-nav');
    const $userMenu = $('.user');
    const $activeMenuShadow = $('#active-menu-shadow');

    const showMenu = () => {
        $mainNav.addClass('open');
        $userMenu.show();
        $menuIcon.hide();
        $menuIconCloser.show();
        $activeMenuShadow.show();
    };

    const closerMenu = () => {
        $mainNav.removeClass('open');
        $userMenu.hide();
        $menuIconCloser.hide();
        $activeMenuShadow.hide();
        $menuIcon.show();
    };

    $menuIcon.on('click', showMenu)
    $menuIconCloser.on('click', closerMenu)
    $activeMenuShadow.on('click', closerMenu)
});
