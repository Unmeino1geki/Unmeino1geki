<?php
session_start();
// セッションからユーザー情報を取得
$email = isset($_SESSION['User']['email']) ? $_SESSION['User']['email'] : '未入力';
$username = isset($_SESSION['User']['username']) ? $_SESSION['User']['username'] : '未入力';
$gender = isset($_SESSION['User']['gender']) ? $_SESSION['User']['gender'] : '未入力';
$skinType = isset($_SESSION['skin_type']) ? $_SESSION['skin_type'] : '未診断';
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
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #333;
        }

        input[type="email"],
        input[type="text"],
        select {
            outline: none;
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
            background-color: #f9f9f9;
            color: #333;
            cursor: pointer;
        }

        .gender {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .gender label {
            margin-right: 10px;
            font-size: 14px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>登録内容確認</h2>
        <p class="explanation-text">以下の内容をご確認ください。<br>登録内容に誤りがありましたら、修正をお願いします<br>「確認し、本人確認メールを送信する」ボタンを押すと、登録されたメールアドレスに本人確認用のリンクが送信されます。</p>
        <form action="touroku_confirm_output.php" method="post">
            <label for="email">メールアドレス:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" required>

            <label for="username">ユーザー名:</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>" required>

            <label for="gender">性別:</label>
            <select name="gender" id="gender" required>
                <option value="男" <?php if ($gender === '男') echo 'selected'; ?>>男</option>
                <option value="女" <?php if ($gender === '女') echo 'selected'; ?>>女</option>
                <option value="ジェンダー" <?php if ($gender === 'ジェンダー') echo 'selected'; ?>>ジェンダー</option>
                <option value="なし" <?php if ($gender === 'なし') echo 'selected'; ?>>回答しない</option>
            </select>

            <label for="skin_type">肌質診断結果:</label>
            <select name="skin_type" id="skin_type" required>
                <option value="dry" <?php if ($skinType === '乾燥肌') echo 'selected'; ?>>乾燥肌</option>
                <option value="normal" <?php if ($skinType === '普通肌') echo 'selected'; ?>>普通肌</option>
                <option value="combination" <?php if ($skinType === '混合肌') echo 'selected'; ?>>混合肌</option>
                <option value="oily" <?php if ($skinType === '油性肌') echo 'selected'; ?>>脂性肌</option>
            </select>

            <input type="submit" value="確認し、本人確認メールを送信する">
        </form>
    </div>
</body>
</html>
