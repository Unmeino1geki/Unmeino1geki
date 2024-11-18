<?php require 'db-connect.php'?>
<?php
// セッションを開始
session_start();

// ユーザーがログインしているか確認
if (!isset($_SESSION['user_id'])) {
    // 未ログインの場合はログインページにリダイレクト
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>

    <!-- ヘッダー -->
    <header>
        <div class="header-content">
            <div class="header-title">
                <h1>運命の一撃</h1>
                <h2>unmeino</h2>
            </div>
        </div>
    </header>

    <!-- サイドメニュー -->
    <aside>
        <ul>
            <li><a href="/top.php">トップ</a></li>
            <li><a href="/change-email.php">メールアドレス変更</a></li>
            <li><a href="/change-password">パスワード変更</a></li>
            <li><a href="/sakujyo.php">アカウント削除</a></li>
            <li><a href="#">アレルギー追加/変更</a></li>
        </ul>
    </aside>

    <!-- メインコンテンツ -->
    <main>
        <section class="favorites">
            <h2>あなたのお気に入り商品</h2>
            <div class="favorite-items">
                <?php
                try {
                    // データベースに接続
                    $pdo = new PDO('mysql:host='. SERVER. ';dbname='. DBNAME. ';charset=utf8', USER, PASS);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // お気に入り商品を取得
                    $stmt = $pdo->prepare('SELECT image_path FROM favorites WHERE user_id = :user_id');
                    $stmt->execute([':user_id' => 14]); // 14はユーザーIDの例
                    $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // 商品画像を表示
                    if ($favorites) {
                        foreach ($favorites as $favorite) {
                            echo '<div class="item"><img src="' . htmlspecialchars($favorite['image_path']) . '" alt="お気に入り商品"></div>';
                        }
                    } else {
                        echo '<p>お気に入りの商品はありません。</p>';
                    }

                } catch (PDOException $e) {
                    echo "データベース接続エラー: " . $e->getMessage();
                }
                ?>
            </div>
        </section>

        <!-- アレルギー追加・変更セクション -->
        <section class="allergy-section">
            <h2>アレルギーの追加・変更</h2>

            <!-- アレルギー情報を表示 -->
            <div class="current-allergy">
                <?php
                try {
                    // アレルギー情報を取得
                    $stmt = $pdo->prepare('SELECT allergies FROM user WHERE id = :id');
                    $stmt->execute([':id' => 14]); // 14はユーザーIDの例
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($row) {
                        echo "<p>現在のアレルギー: " . htmlspecialchars($row['allergies']) . "</p>";
                        echo '<button type="button" onclick="showEditForm()">変更</button>';
                    } else {
                        echo "<p>アレルギー情報はありません。</p>";
                    }

                } catch (PDOException $e) {
                    echo "データベース接続エラー: " . $e->getMessage();
                }
                ?>
            </div>

            <!-- アレルギー追加・変更フォーム -->
            <form id="allergy-edit-form" action="profile_update.php" method="POST" style="display:none;">
                <label for="allergy">アレルギーを編集:</label>
                <input type="text" id="allergy" name="allergy" value="<?php echo htmlspecialchars($row['allergies'] ?? ''); ?>" placeholder="アレルギーを入力してください">
                <button type="submit" class="save">保存</button>
            </form>

            <script>
                function showEditForm() {
                    document.getElementById('allergy-edit-form').style.display = 'block';
                }
            </script>

        </section>
    </main>

</body>
</html>