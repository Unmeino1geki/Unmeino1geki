<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ページタイトル</title>
<link rel="stylesheet" href="css/header.css"> <!-- CSSファイルのリンク -->
</head>
<body>
<header>
<div class="header-container">
<!-- 1. ページアイコン -->
<div class="logo">
<img src="path/to/logo.png" alt="サイトロゴ" width="50"> <!-- ロゴのパスとサイズを指定 -->
</div>
<!-- 2. 検索バー -->
<div class="search-bar">
<form action="search.php" method="GET">
<input type="text" name="query" placeholder="検索..." class="search-input">
<button type="submit" class="search-button">🔍</button>
</form>
</div>
<!-- 3. 絞り込みプルダウン -->
<div class="filter-dropdown">
<select name="filter" id="filter" onchange="location.href=this.value;">
<option value="all">すべて</option>
<option value="category1.php">カテゴリ1</option>
<option value="category2.php">カテゴリ2</option>
<option value="category3.php">カテゴリ3</option>
</select>
</div>
<!-- 4. いいね一覧に飛ぶボタン -->
<div class="favorites-button">
<a href="favorites.php" class="button">いいね一覧</a>
</div>
<!-- 5. プロフィールに飛ぶボタン -->
<div class="profile-button">
<a href="profile.php" class="button">プロフィール</a>
</div>
<!-- 6. ログアウトボタン -->
<div class="logout-button">
<a href="logout.php" class="button logout">ログアウト</a>
</div>
</div>
</header>
</body>
</html>

 