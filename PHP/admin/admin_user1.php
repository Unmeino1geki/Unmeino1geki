<?php
// データベース接続 (PDO を使用)
require_once 'connect/dbconnect.php';
try {
    $pdo = new PDO('mysql:host='. SERVER. ';dbname='. DBNAME. ';charset=utf8', USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // POSTリクエストで送信されたユーザーIDの削除
    if (isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM user WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(["status" => "success", "message" => "User deleted successfully"]);
        exit; // 削除後にスクリプトを終了
    }
} catch (PDOException $e) {
    echo "データベース接続エラー: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー管理画面</title>
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

        tbody tr:not(:first-child) {
            background-color: #FFD700; /* 薄い黄色 */
        }
        
        /* 戻るボタンのデザイン */
        .modoru, .sakujyo{
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            border: 1px solid #ffffff;
        }

        .yes{
            background-color: #ff4747;
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
            background-color: #ff0000;
            margin-right: 20px; /* 削除ボタンの右側に余白を追加 */
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


        .modoru {
            background-color: #d4af37;
        }

        .modoru:hover {
            background-color: #b8860b;
        }

        .sakujyo {
            background-color: #ff4747;
        }

        .sakujyo:hover {
            background-color: #ff0000;
        }

        /* 検索バーのスタイル */
        #search-bar {
            margin-bottom: 20px;
            padding: 10px;
            width: 200px;
            font-size: 16px;
            border: 1px solid #d4af37;
            border-radius: 5px;
        }

        #search-bar-name {
            margin-bottom: 20px;
            padding: 10px;
            width: 200px;
            font-size: 16px;
            border: 1px solid #d4af37;
            border-radius: 5px;
        }

        /* 検索バーと戻るボタンの配置 */
        .action-bar {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 20px;
        }

        .sample-popup-background {
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
            box-shadow: 0 0 100px rgba(255, 255, 255, 0.5), 
                        0 0 0px rgba(255, 255, 255, 0.7);
        }
        .popup-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
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
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ユーザーネーム</th>
                <th>メール</th>
                <th>削除</th>
            </tr>
        </thead>
        <tbody id="user-table">

            <!-- PHPコードを使用してユーザーデータを取得 -->
            <?php
            // ユーザーデータを取得
            $stmt = $pdo->query("SELECT id, name, email FROM user");
            while ($row = $stmt->fetch()) {
                echo "<tr data-user-id='{$row['id']}'>
                          <td>{$row['id']}</td>
                          <td>{$row['name']}</td>
                          <td>{$row['email']}</td>
                          <td><button type='button' class='sakujyo' onclick='showCustomPopup({$row['id']})'>削除</button></td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    </div>
    <!-- ポップアップのHTML -->
    <div id="popupBackground" class="sample-popup-background" style="display:none;"></div>
<div id="customPopup">
    <p>本当に削除しますか？</p>
    <form id="deleteForm" action="admin_user2.php" method="POST">
        <input type="hidden" name="user_id" id="popupUserId"> <!-- 削除するユーザーIDを保持 -->
        
        <!-- ボタンをフレックスボックスで横並びにするためのdiv -->
        <div class="popup-buttons">
            <button type="submit" class="yes"style="
    margin-right: 30px;
">削除</button> <!-- 削除ボタン -->
            <button type="button" onclick="hideCustomPopup(false)" class="no">キャンセル</button> <!-- キャンセルボタン -->
        </div>
    </form>
</div>

    <script>
        // IDで検索する関数
        function searchById() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search-bar");
            filter = input.value.toUpperCase();
            table = document.getElementById("user-table");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0]; // ID列のみを検索
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
                }       
            }
        }

        function searchByName() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("search-bar-name"); // ユーザー名検索バーを取得
    filter = input.value.toUpperCase();
    table = document.getElementById("user-table");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1]; // 2列目（ユーザー名列）を取得
        if (td) {
            txtValue = td.textContent || td.innerText;
            tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
        }       
    }
}




      

        /// カスタムポップアップを表示する関数
function showCustomPopup(userId) {
    document.getElementById("popupBackground").style.display = "block";
    document.getElementById("customPopup").style.display = "block";

    // 削除するユーザーIDをフォームのhiddenフィールドにセット
    document.getElementById("popupUserId").value = userId;
}

// カスタムポップアップを非表示にする関数
function hideCustomPopup() {
    document.getElementById("popupBackground").style.display = "none";
    document.getElementById("customPopup").style.display = "none";
}

        // 削除処理をPHPにリクエスト
        function deleteUser(userId) {
    fetch('', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${userId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert(data.message);
            document.querySelector(`tr[data-user-id="${userId}"]`).remove();
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}


        // カスタムポップアップを非表示にする関数
        function hideCustomPopup() {
            document.getElementById("popupBackground").style.display = "none";
            document.getElementById("customPopup").style.display = "none";
        }
    </script>

</body>
</html>
