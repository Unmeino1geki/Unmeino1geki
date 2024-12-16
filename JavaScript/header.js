
    const menuButton = document.getElementById('menuButton');
    const menu = document.getElementById('menu');

    menuButton.addEventListener('click', () => {
        if (menu.style.maxHeight === '0px' || !menu.style.maxHeight) {
            menu.style.maxHeight = menu.scrollHeight + 'px';
        } else {
            menu.style.maxHeight = '0px';
        }
    });
