<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ヘッダー</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../CSS/feader.css">

    <style>

        /* カスタムスタイル */
        header {
            background-color: #f8f8f8;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-sizing: border-box;
        }
        .menu {
            transition: max-height 0.3s ease-in-out;
            overflow: hidden;
        }

    </style>

</head>
<body class="bg-gray-100">

    <!-- ヘッダー -->

    <header class="flex items-center justify-between">

        <!-- ロゴ -->

        <div class="flex items-center">
            <img src="https://placehold.co/100x50" alt="運命の一撃ロゴ" class="mr-4">
            <h1 class="text-lg font-bold text-yellow-600"> ～ あなたの肌に一撃を ～ </h1>
        </div>

        <!-- ハンバーガーメニュー -->

        <button id="menuButton" class="text-2xl focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>
    </header>

    <!-- ハンバーガーメニュー内容 -->

    <div id="menu" class="menu bg-white shadow-lg max-h-0">
        <nav class="p-4">
            <div class="mb-4">
                <input type="text" class="w-full p-4  rounded">
            </div>

            <!-- 検索バー -->
            
                <form action="search.php" method="GET">

                <div class="flex space-y-0 space-x-0 mb-4">
                <input type="search" placeholder=" 検索..." class="w-5/6 p-2 border-solid border-4 border-black-300 rounded-l-lg">
                <button class=" w-1/6 py-2 bg-gray-200 text-black rounded-r-lg hover:bg-gray-300">🔍</button>
                </div>

                </form>
            
            <!-- カテゴリ選択 -->

            <ul class="flex space-y-2 space-x-2 mb-4">
              <a href="#"></a>
                <a href="#" class="w-1/5 py-2 px-4 bg-gray-100 text-black text-center border-solid border-4 rounded hover:bg-gray-300">化粧水</a>
                <a href="#" class="w-1/5 py-2 px-4 bg-gray-100 text-black text-center border-solid border-4 rounded hover:bg-gray-300">美容液</a>
                <a href="#" class="w-1/5 py-2 px-4 bg-gray-100 text-black text-center border-solid border-4 rounded hover:bg-gray-300">乳液</a>
                <a href="#" class="w-1/5 py-2 px-4 bg-gray-100 text-black text-center border-solid border-4 rounded hover:bg-gray-300">洗顔料</a>
                <a href="#" class="w-1/5 py-2 px-4 bg-gray-100 text-black text-center border-solid border-4 rounded hover:bg-gray-300"></a>
              <a href="#"></a>
            </ul>

            <!-- ボタン類 -->

            <div class="flex space-y-2 space-x-2 mb-4">
              <a href="#"></a>
                <a href="favorites.php" class="w-1/3 py-3 px- bg-gray-200 text-black text-center border-solid border-4 rounded hover:bg-pink-200">いいね</button></a>
                <a href="profile.php" class="w-1/3 py-3 px-4 bg-gray-200 text-black text-center border-solid border-4 rounded hover:bg-blue-200">プロフィール</a></button>
                <a href="logout.php" class="w-1/3 py-3 px-4 bg-gray-200 text-black text-center border-solid border-4 rounded hover:bg-red-300">ログアウト</a></button>
              <a href="#"></a>
            </div>
        </nav>
    </div>

    <!-- Font Awesome for icons -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- JavaScript -->
    <script>
        const menuButton = document.getElementById('menuButton');
        const menu = document.getElementById('menu');

        menuButton.addEventListener('click', () => {
            if (menu.style.maxHeight === '0px' || !menu.style.maxHeight) {
                menu.style.maxHeight = menu.scrollHeight + 'px';
            } else {
                menu.style.maxHeight = '0px';
            }
        });
    </script>
</body>
</html>
