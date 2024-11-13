<!DOCTYPE html>
<?php
// データベース接続 (PDO を使用)
const SERVER = 'mysql310.phy.lolipop.lan';
const DBNAME = 'LAA1517323-circus';
const USER = 'LAA1517323';
const PASS = 'Pass0128';

try {
    $pdo = new PDO('mysql:host='. SERVER. ';dbname='. DBNAME. ';charset=utf8', USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // POSTリクエストで送信されたデータの処理
    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['password'])) {
        $id = (int)$_POST['id'];
        $name = $_POST['name'];
        $password = $_POST['password'];

        // パスワードのハッシュ化（セキュリティ対策）
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // ユーザー情報を更新するSQLクエリ
        $stmt = $pdo->prepare("UPDATE user SET name = ?, password = ? WHERE id = ?");
        $stmt->execute([$name, $hashedPassword, $id]);

        echo json_encode(["status" => "success", "message" => "User updated successfully"]);
        exit; // 更新後にスクリプトを終了
    }
} catch (PDOException $e) {
    echo "データベース接続エラー: " . $e->getMessage();
    exit;
}
?>

<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワード管理画面</title>
    <style>
        /* 背景と基本のスタイル */
        body {
            background: linear-gradient(135deg, #ffffff 0%, #d4af37 100%);
            margin: 0;
            padding: 20px;
            height: 100vh;
            overflow: hidden; /* bodyのスクロールをなくす */
            
        }
        
        /* テーブルのスタイル */
        #table-container {
    width: 100%;
    max-height: 70%; /* 固定の高さを設定 */
    overflow-y: auto; /* 縦スクロールを有効にする */
}
        table {
            
    border: 1px solid #ffffff; /* 枠線 */
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            border: 1px solid #ffffff; /* 枠線を白に */
            padding: 10px;
            text-align: center;
        }
        
        th {
            background-color: #d4af37;
            color: white;
        }
        tbody tr:first-child {
            background-color: #FFD700; /* 濃い黄色 */
        }

        /* 2行目以降（他のtr）を薄い黄色に */
        tbody tr:not(:first-child) {
            background-color: #FFD700; /* 薄い黄色 */
        }
        /* 戻るボタンのデザイン */
        .modoru{
            background-color: #d4af37;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            border: 1px solid #ffffff;
        }
        .modoru:hover {
            background-color: #b8860b;
        }

        .henkou{
            background-color: #44ce37;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            border: 1px solid #ffffff;
        }

        .henkou:hover {
            background-color: #23e911;
        }

        /* 検索バーのスタイル */
        #search-bar,#search-bar-name {
            margin-bottom: 20px;
            padding: 10px;
            width: 200px; /* 短くする */
            font-size: 16px;
            border: 1px solid #d4af37;
            border-radius: 5px;
        }

        /* 検索バーと戻るボタンの配置 */
        .action-bar {
            display: flex;
            justify-content: flex-end; /* 右側に配置 */
            gap: 10px; /* 検索バーとボタンの間隔 */
            margin-bottom: 20px;
        }

        .yes{
            background-color: #44ce37;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            border: 1px solid #ffffff;
        }
        .yes:hover {
            background-color: #23e911;
        }
        .no{
            background-color: #DDDDDD;
            border: none;
            color: #000000;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            border: 1px solid #ffffff;
        }
        .no:hover {
            background-color: #BBBBBB;
        }

        .sample-popup-background {
            /* 画面全体を暗くする透過背景 */
            position: fixed;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,.5);
            top: 0;
            left: 0;
            z-index: 1000;
        }

        /* ポップアップのスタイル */
        #customPopup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 40px;
            border: 3px solid #d4af37;
            border-radius: 15px;
            z-index: 1001;
            /* スポットライト効果の追加 */
            box-shadow: 0 0 100px rgba(255, 255, 255, 0.5), 
                        0 0 0px rgba(255, 255, 255, 0.7);
        }

        #username-all, #password-all {
            margin-bottom: 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <h1>ユーザー一覧</h1>

    <!-- 検索バーと戻るボタンを右側に配置 -->
    <div class="action-bar">
        <input type="text" id="search-bar" onkeyup="searchById()" placeholder="IDで検索...">
        <input type="text" id="search-bar-name" onkeyup="searchByName()" placeholder="ユーザー名で検索...">
        <button class="modoru" onclick="location.href='admin_top.php'">戻る</button>
    </div>
    <div id="table-container">
    <table id="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>ユーザーネーム</th>
                <th>パスワード</th>
                <th>変更</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT id, name, password FROM user"); // users テーブルからデータを取得
            while ($row = $stmt->fetch()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['password']}</td>
                        <td><button type='button' class='henkou' onclick='showCustomPopup({$row['id']}, \"{$row['name']}\", \"{$row['password']}\")'>変更</button></td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
    </div>
    <!-- ポップアップのHTML -->
<div id="popupBackground" class="sample-popup-background" style="display:none;"></div>
<div id="customPopup" style="display:none;"> <!-- 初期表示は非表示 -->
    <p>変更する内容を入力して変更を押してください</p>
    <form id="deleteForm" action="admin_pass2.php" method="POST" onsubmit="return validatePassword()">
        <input type="hidden" name="user_id" id="popupUserId"> <!-- 削除するユーザーIDを保持 -->

        <!-- ユーザー名とパスワードのフィールド -->
        <div id="username-all">
            ユーザー名<br>
            <input type="text" id="adminname" name="adminname" placeholder="ADMIN NAME" required>
        </div>
        <div id="password-all">
            パスワード<br>
            <input type="password" id="password" name="password" placeholder="PASSWORD" required>
        </div>

        <!-- 変更ボタンをsubmitに変更 -->
        <div class="popup-buttons" style="display: flex; justify-content: space-between;">
            <button type="submit" class="yes" style="margin-right: 30px;">変更</button> <!-- 変更ボタン -->
            <button type="button" onclick="closeCustomPopup()" class="no">キャンセル</button> <!-- キャンセルボタン -->
        </div>
    </form>
</div>

<!-- JavaScript -->
<script>
    function validatePassword() {
        var password = document.getElementById('password').value;
        if (password.length < 8) {
            alert('パスワードは8文字以上で入力してください');
            return false; // フォームの送信を停止
        }
        return true; // フォームの送信を許可
    }

    function closeCustomPopup() {
        document.getElementById('customPopup').style.display = 'none';
        document.getElementById('popupBackground').style.display = 'none';
    }
</script>




<script>
   function showCustomPopup(userId, username, email) {
    // ポップアップを表示する
    document.getElementById("popupBackground").style.display = "block";
    document.getElementById("customPopup").style.display = "block";

    // ユーザーネームを placeholder に設定
    document.getElementById("adminname").value = username;  // ユーザー名のフィールドにユーザーネームを入れる
    document.getElementById("password").value = '';  // パスワードフィールドを空にする
}

function closeCustomPopup() {
    // ポップアップを非表示にする
    document.getElementById("popupBackground").style.display = "none";
    document.getElementById("customPopup").style.display = "none";
}

</script>


    <script>
        // Search functionality for ID
        function searchById() {
            var input = document.getElementById("search-bar").value.toLowerCase();
            var table = document.getElementById("user-table");
            var rows = table.getElementsByTagName("tr");

            for (var i = 1; i < rows.length; i++) {
                var id = rows[i].getElementsByTagName("td")[0].textContent;
                if (id.toLowerCase().indexOf(input) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }

        // Search functionality for username
        function searchByName() {
            var input = document.getElementById("search-bar-name").value.toLowerCase();
            var table = document.getElementById("user-table");
            var rows = table.getElementsByTagName("tr");

            for (var i = 1; i < rows.length; i++) {
                var username = rows[i].getElementsByTagName("td")[1].textContent;
                if (username.toLowerCase().indexOf(input) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }

        // Popup functionality
        function showCustomPopup(userId, username, email) {
    document.getElementById("popupBackground").style.display = "block";
    document.getElementById("customPopup").style.display = "block";
    document.getElementById("popupUserId").value = userId;  // ここでユーザーIDを設定
    document.getElementById("adminname").value = username;
    document.getElementById("password").value = '';  
}


        function closeCustomPopup() {
            document.getElementById("popupBackground").style.display = "none";
            document.getElementById("customPopup").style.display = "none";
        }

        // Function to handle data submission
        function submitData() {
            // Submit logic for your form
        }
    </script>

</body>
</html>
