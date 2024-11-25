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
            <li><a href="../PHP/top.php">トップ</a></li>
            <li><a href="/change-email.php">メールアドレス変更</a></li>
            <li><a href="/change-password">パスワード変更</a></li>
            <li><a href="/sakujyo.php">アカウント削除</a></li>
            <li><a href="#">アレルギー追加/変更</a></li>
        </ul>
    </aside>

    <!-- メインコンテンツ -->
    <main>
        <!-- ユーザー情報セクション -->
        <section class="user-info">
            <h2>プロフィール情報</h2>
            <div class="profile-details">
                <?php
                try {
                    // データベースに接続
                    $pdo = new PDO('mysql:host='. SERVER. ';dbname='. DBNAME. ';charset=utf8', USER, PASS);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // 名前と性別を取得
                    $stmt = $pdo->prepare('SELECT name, gender FROM user WHERE id = :id');
                    $stmt->execute([':id' => 14]); // 14はユーザーIDの例
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($user) {
                        echo "<p>名前: " . htmlspecialchars($user['name']) . "</p>";
                        echo "<p>性別: " . htmlspecialchars($user['gender']) . "</p>";
                        echo '<button type="button" onclick="showEditForm()">編集</button>';
                    } else {
                        echo "<p>ユーザー情報はありません。</p>";
                    }

                } catch (PDOException $e) {
                    echo "データベース接続エラー: " . $e->getMessage();
                }
                ?>
            </div>

            <!-- 名前・性別編集フォーム -->
            <form id="user-edit-form" action="profile_update.php" method="POST" style="display:none;">
                <label for="name">名前:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" placeholder="名前を入力してください">

                <label for="gender">性別:</label>
                <select id="gender" name="gender">
                    <option value="男性" <?php echo (isset($user['gender']) && $user['gender'] === '男性') ? 'selected' : ''; ?>>男性</option>
                    <option value="女性" <?php echo (isset($user['gender']) && $user['gender'] === '女性') ? 'selected' : ''; ?>>女性</option>
                    <option value="その他" <?php echo (isset($user['gender']) && $user['gender'] === 'その他') ? 'selected' : ''; ?>>その他</option>
                </select>

                <button type="submit" class="save">保存</button>
            </form>
        </section>

        <!-- お気に入り商品セクション -->
        <section class="favorites">
            <h2>あなたのお気に入り商品</h2>
            <div class="favorite-items">
                <?php
                // お気に入り商品を取得・表示
                try {
                    $stmt = $pdo->prepare('SELECT image_path FROM favorites WHERE user_id = :user_id');
                    $stmt->execute([':user_id' => 14]);
                    $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
            <div class="current-allergy">
                <?php
                // アレルギー情報を取得・表示
                try {
                    $stmt = $pdo->prepare('SELECT allergies FROM user WHERE id = :id');
                    $stmt->execute([':id' => 14]);
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

            <!-- アレルギー編集フォーム -->
            <form id="allergy-edit-form" action="profile_update.php" method="POST" style="display:none;">
                <label for="allergy">アレルギーを編集:</label>
                <input type="text" id="allergy" name="allergy" value="<?php echo htmlspecialchars($row['allergies'] ?? ''); ?>" placeholder="アレルギーを入力してください">
                <button type="submit" class="save">保存</button>
            </form>
        </section>
    </main>

    <script>
        function showEditForm() {
            document.getElementById('user-edit-form').style.display = 'block';
            document.getElementById('allergy-edit-form').style.display = 'block';
        }
    </script>

</body>
</html>