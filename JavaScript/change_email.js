function handleSubmit(event) {
    event.preventDefault();
    
    // フォームの入力値を取得
    const nowEmail = document.getElementById('now_email').value;
    const newEmail = document.getElementById('new_email').value;
    const confirmNewEmail = document.getElementById('confirm_new_email').value;

    // 新しいメールアドレスが一致しているか確認
    if (newEmail !== confirmNewEmail) {
        alert("新しいメールアドレスが一致しません。");
        return;
    }

    // 変更内容確認画面に遷移
    window.location.href = `email_confirm.php?nowEmail=${encodeURIComponent(nowEmail)}&newEmail=${encodeURIComponent(newEmail)}`;
}