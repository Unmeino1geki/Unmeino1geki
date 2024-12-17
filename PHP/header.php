<?php
// セッションを開始

session_start();
?>

<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ヘッダー</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="../CSS/header.css">

</head>
<body class="bg-gray-100">

    <!-- ヘッダー -->

    <header class="flex items-center justify-between bg-gray-100 shadow-md p-2 fixed top-0 left-0 w-full z-50 ">
        <!-- ロゴ -->
        <div class="flex items-center">
            <img src="../IMG/うんめい.png" alt="運命の一撃ロゴ" class="mr-4 ml-1" width="100" height="50">
            <h1 class="text-lg font-bold text-yellow-600 ml-2 mr-2"><div class="a">あなたの肌に一撃を</div></h1>
        </div>

        <!-- 検索バー -->
                    <form ation="search.php" method="GET" class="flex items-center w-2/3 mt-0 ml-2 mr-2">
                <input 
                    type="search"
                    name="query"
                    placeholder="ブランド名、カテゴリ名、商品名で探す" 
                    class="w-full p-2 border border-4 border-gray-200 rounded-l-lg focus:outline-none"
                    value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query'], ENT_QUOTES) : ''; ?>">
                
                <button 
                    type="submit" 
                    class="p-2 border border-4  bg-gray-200 text-black rounded-r-lg hover:bg-gray-200 focus:outline-none"
                >
                <div class="dli-search"></div>

                </button>
            </form>
        
         <!-- ハンバーガーメニュー -->
        <button id="menuButton" class="text-3xl focus:outline-none ml-4 mr-4">
            <i class="fas fa-bars"></i>
        </button>
    </header>

    <!-- ハンバーガーメニュー内容 -->

    <div id="menu" class="menu bg-white shadow-lg max-h-0 justify-between">
        <div class="p-4 flex ">

        <?php $user_id = isset($_SESSION['User']['id']) ? $_SESSION['User']['id'] : ''; ?>


            <!-- ボタン類 -->

                <a href="favorites.php" class="w-1/3  mr-2 ml-2 py-3 px- bg-gray-200 text-black text-center border-solid border-4 rounded hover:bg-pink-200">いいね</button></a>
                <a href="profile.php?id=<?php $user_id ?>" class="w-1/3 mr-2 ml-2 py-3 px-4 bg-gray-200 text-black text-center border-solid border-4 rounded hover:bg-blue-200">プロフィール</a></button>
                <a href="logout.php" class="w-1/3 mr-2 ml-2 py-3 px-4 bg-gray-200 text-black text-center border-solid border-4 rounded hover:bg-red-300">ログアウト</a></button>

            
        </div>
    </div>

    <!-- Font Awesome for icons -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="../JavaScript/header.js"></script>

</html>
