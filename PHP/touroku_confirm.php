<?php
session_start();
// セッションからユーザー情報を取得
$username = isset($_SESSION['User']['username']) ? $_SESSION['User']['username'] : '未入力';
$email = isset($_SESSION['User']['email']) ? $_SESSION['User']['email'] : '未入力';
$gender = isset($_SESSION['User']['gender']) ? $_SESSION['User']['gender'] : '未入力';
$skinType = isset($_SESSION['User']['skin_type']) ? $_SESSION['User']['skin_type'] : '未診断';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録内容確認</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        h1 {
            color: #4a90e2;
            font-size: 2em;
            margin-bottom: 20px;
        }

        .confirm-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 500px;
            text-align: center;
        }

        .info-row {
            margin-bottom: 15px;
            font-size: 1.2em;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"], select {
            padding: 8px;
            font-size: 1em;
            width: 100%;
            max-width: 300px;
            margin-bottom: 10px;
        }

        .confirm-button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1em;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .confirm-button:hover {
            background-color: #357abd;
        }
    </style>
</head>
<body>
    <h1>登録内容確認</h1>
    <div class="confirm-container">
        <form action="touroku_confirm_output.php" method="POST">
            <div class="info-row">
                <label for="username">ユーザー名:</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="info-row">
                <label for="email">メールアドレス:</label>
                <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="info-row">
                <label for="gender">性別:</label>
                <select name="gender" id="gender" required>
                    <option value="男" <?php if ($gender === '男') echo 'selected'; ?>>男</option>
                    <option value="女" <?php if ($gender === '女') echo 'selected'; ?>>女</option>
                    <option value="ジェンダー" <?php if ($gender === 'ジェンダー') echo 'selected'; ?>>ジェンダー</option>
                    <option value="なし" <?php if ($gender === 'なし') echo 'selected'; ?>>なし</option>
                </select>
            </div>
            <div class="info-row">
                <label for="skin_type">肌質診断結果:</label>
                <select name="skin_type" id="skin_type" required>
                    <option value="dry" <?php if ($skinType === 'dry') echo 'selected'; ?>>乾燥肌</option>
                    <option value="normal" <?php if ($skinType === 'normal') echo 'selected'; ?>>普通肌</option>
                    <option value="combination" <?php if ($skinType === 'combination') echo 'selected'; ?>>混合肌</option>
                    <option value="oily" <?php if ($skinType === 'oily') echo 'selected'; ?>>脂性肌</option>
                </select>
            </div>

            <button type="submit" class="confirm-button">登録を確定する</button>
        </form>
    </div>
</body>
</html>
