<?php
// 必要な設定・共通処理をインクルード
require_once 'connect/dbconnect.php'; // DB接続情報などの設定を格納
session_start();

// 共通関数：リダイレクトを行う
function redirectWithMessage($message, $url, $delay = 3) {
    echo "<p>$message</p>";
    header("Refresh: $delay; url=$url");
    exit();
}

// セッションチェック（ログインしているか確認）
if (!isset($_SESSION['user_id'])) {
    redirectWithMessage("ログインが必要です。ログインページに遷移します。", "login-input.php");
}

// DB接続
try {
    // DB接続情報は共通の設定から読み込まれる
    $pdo = new PDO('mysql:host=' . SERVER . ';dbname=' . DBNAME . ';charset=utf8', USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("データベース接続エラー: " . $e->getMessage(), 0); // エラーログに記録
    die("<p>システムエラーが発生しました。しばらくしてから再度お試しください。</p>");
}

// 現在のユーザーID（セッションから取得）
$userId = $_SESSION['user_id'];

// メッセージ表示処理
$message = "";
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // 表示後にセッションから削除
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール</title>
    <link rel="stylesheet" href="../CSS/profile.css">
    <style>
        .message {
            color: green;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- メールアドレスのメッセージ -->
        <?php if ($message): ?>
            <p class="message"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
    <!-- ヘッダー -->
    <header>
        <!-- ロゴ -->
        <a href="top.php" class="flex items-center">
        <div class="flex items-center">
        <img src="../IMG/うんめい.png" alt="運命の一撃ロゴ" class="mr-4 ml-1" width="100" height="50">
        </div>
        </a>
        <div class="header-content">
            <div class="header-title"style="margin-left: 0px;margin-right: 80px;">
                <h1>運命の一撃</h1>
                <h2>unmei no ichigeki</h2>
            </div>
        </div>
    </header>

    <!-- サイドメニュー -->
    <aside>
        <div class="aaa">
        <ul>
            <li><button><a href="../PHP/top.php">トップ</a></button></li>
            <li><button><a href="../PHP/change_email.php">メールアドレス変更</a></button></li>
            <li><button><a href="../PHP/change_password">パスワード変更</a></button></li>
            <li><button><a href="../PHP/logout.php">ログアウト</a></button></li>
            <li><button><a href="../PHP/sakujyo.php">アカウント削除</a></button></li>
        </ul>
        </div>
    </aside>

    <!-- メインコンテンツ -->
    <main>
        <!-- ユーザー情報セクション -->
        <div class="allergy-section">
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
                    $stmt->execute([':id' => $userId]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($user) {
                        echo "<p>名前: " . htmlspecialchars($user['name']) . "</p>";
                        echo "<p>性別: " . htmlspecialchars($user['gender']) . "</p>";
                        echo '<button type="button" onclick="showUserEditForm()">編集</button>';
                    } else {
                        echo "<p>ユーザー情報はありません。</p>";
                    }

                } catch (PDOException $e) {
                    echo "データベース接続エラー: " . $e->getMessage();
                }
                ?>
            </div>
            
            <!-- 名前・性別編集フォーム -->
            <form class=sss id="user-edit-form" action="profile_update.php" method="POST" style="display:none;"style="margin-top: 20px;">
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
</div>
        <!-- アレルギー追加・変更セクション -->
        <section class="allergy-section">
            <h2>アレルギーの追加・変更</h2>
            <div class="current-allergy">
                <?php
                // アレルギー情報を取得・表示
                try {
                    $stmt = $pdo->prepare('SELECT allergies FROM user WHERE id = :id');
                    $stmt->execute([':id' => $userId]); // ユーザーIDを使用
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($row) {
                        echo "<p>現在のアレルギー: " . htmlspecialchars($row['allergies'] ?? '未記入') . "</p>";
                        echo '<button type="button" onclick="showAllergyEditForm()">変更</button>';
                    } else {
                        echo "<p>アレルギー情報はありません。</p>";
                    }

                } catch (PDOException $e) {
                    echo "データベース接続エラー: " . $e->getMessage();
                }
                ?>
            </div>

            <!-- アレルギー編集フォーム -->
            <form class=sss id="allergy-edit-form" action="profile_update.php" method="POST" style="display:none;">
                <label for="allergy">アレルギーを編集:</label>
                <input type="text" id="allergy" name="allergy" value="<?php echo htmlspecialchars($row['allergies'] ?? ''); ?>" placeholder="アレルギーを入力してください">
                <button type="submit" class="save">保存</button>
            </form>
        </section>
    </main>

    <script>
        // ユーザー情報編集フォームを表示
        function showUserEditForm() {
            document.getElementById('user-edit-form').style.display = 'block';
        }

        // アレルギー編集フォームを表示
        function showAllergyEditForm() {
            document.getElementById('allergy-edit-form').style.display = 'block';
        }
    </script>

</body>
</html>
