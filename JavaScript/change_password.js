document.getElementById("passwordForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const currentPassword = document.getElementById("currentPassword").value;
    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    const messageElement = document.getElementById("message");

    // パスワード確認のバリデーション
    if (newPassword !== confirmPassword) {
        messageElement.textContent = "新しいパスワードが一致しません。";
        return;
    }

    // ここでパスワードの強度や他の条件を確認できる
    if (newPassword.length < 8) {
        messageElement.textContent = "パスワードは8文字以上にしてください。";
        return;
    }

    // パスワードを変更する処理（例：サーバーに送信）
    messageElement.textContent = "パスワードが正常に変更されました。";
});
