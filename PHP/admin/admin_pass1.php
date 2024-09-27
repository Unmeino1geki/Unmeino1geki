<!DOCTYPE html>
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
        }
        
        /* テーブルのスタイル */
        table {
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
            background-color: #FFFACD; /* 薄い黄色 */
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
        #search-bar {
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
        <button class="modoru" onclick="window.history.back()">戻る</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ユーザーネーム</th>
                <th>パスワード</th>
                <th>変更</th>
            </tr>
            
        </thead>
        <tbody id="pass-table">
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th><button type="submit" class="henkou" onclick="showCustomPopup()">
        変更
    </button></th>
            </tr>
            <?php
            //require 'db.php'; // データベース接続を読み込む

            //$stmt = $pdo->query("SELECT id, name, email FROM users"); // users テーブルからデータを取得
            //while ($row = $stmt->fetch()) {
            //echo "<tr>
                      //<td>{$row['id']}</td>
                      //<td>{$row['name']}</td>
                      //<td>{$row['email']}</td>
                    //</tr>";
            //}
            ?>
        </tbody>
    </table>
<!-- ポップアップのHTML -->
<div id="popupBackground" class="sample-popup-background" style="display:none;"></div>
    <div id="customPopup">
        <p>変更する内容を入力して変更を押してください</p>
        <div id="username-all">
                ユーザー名<br><input type="text" id="adminname" name="adminname" placeholder="ADMIN NAME" required>
            </div>
            <div id="password-all">
                パスワード<br><input type="password" id="password" name="password" placeholder="PASSWORD" required>
            </div>
        <button onclick="hideCustomPopup(true)" class="yes">変更</button>
        <button onclick="hideCustomPopup(false)" class="no">キャンセル</button>
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
                td = tr[i].getElementsByTagName("td")[0]; // IDは最初の列
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
        function searchById() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search-bar");
            filter = input.value.toUpperCase();
            table = document.getElementById("syouhin-table");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0]; // IDは最初の列
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
        
// カスタムポップアップを表示する関数
function showCustomPopup() {
    document.getElementById("popupBackground").style.display = "block";
    document.getElementById("customPopup").style.display = "block";
}

// カスタムポップアップを非表示にする関数
function hideCustomPopup(result) {
    document.getElementById("popupBackground").style.display = "none";
    document.getElementById("customPopup").style.display = "none";
    if (result) {
        alert("変更しました");
    } else {
        alert("変更がキャンセルされました");
    }
}

    </script>

</body>
</html>
