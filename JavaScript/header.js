
    const menuButton = document.getElementById('menuButton');
    const menu = document.getElementById('menu');

    menuButton.addEventListener('click', () => {
        if (menu.style.maxHeight === '0px' || !menu.style.maxHeight) {
            menu.style.maxHeight = menu.scrollHeight + 'px';
        } else {
            menu.style.maxHeight = '0px';
        }
    });

    // 候補データ
    const suggestions = [
        "化粧水",
        "美容液",
        "乳液",
        "洗顔料",
        "日焼け止め",
        "シャンプー",
        "トリートメント",
        "フェイスクリーム"
    ];
    
    const searchInput = document.getElementById('searchInput');
        const autocompleteList = document.getElementById('autocompleteList');

        // 検索バーの入力イベント
        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim().toLowerCase();

            // 候補リストをクリア
            autocompleteList.innerHTML = '';

            if (query) {
                const filteredSuggestions = suggestions.filter(item =>
                    item.toLowerCase().includes(query)
                );

                if (filteredSuggestions.length > 0) {
                    autocompleteList.classList.remove('hidden');
                    filteredSuggestions.forEach(item => {
                        const div = document.createElement('div');
                        div.textContent = item;
                        div.classList.add('autocomplete-item');
                        div.addEventListener('click', function () {
                            searchInput.value = item; // 候補を検索バーにセット
                            autocompleteList.classList.add('hidden'); // リストを隠す
                        });
                        autocompleteList.appendChild(div);
                    });
                } else {
                    autocompleteList.classList.add('hidden');
                }
            } else {
                autocompleteList.classList.add('hidden');
            }
        });

        // フォーカスが外れた時にリストを隠す
        searchInput.addEventListener('blur', function () {
            setTimeout(() => autocompleteList.classList.add('hidden'), 200);
        });

        // フォーカス時に候補リストを表示
        searchInput.addEventListener('focus', function () {
            if (searchInput.value.trim()) {
                autocompleteList.classList.remove('hidden');
            }
        });