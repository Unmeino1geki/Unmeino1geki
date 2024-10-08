        // URLパラメータからメールアドレスを取得
        const urlParams = new URLSearchParams(window.location.search);
        const nowEmail = urlParams.get('nowEmail');
        const newEmail = urlParams.get('newEmail');

        // 取得したメールアドレスを画面に表示
        document.getElementById('nowEmail').textContent = nowEmail;
        document.getElementById('newEmail').textContent = newEmail;

        function confirmChange() {
            alert('メールアドレスが変更されました！');
            // ここで実際の変更処理をサーバーに送信する処理を実装する

            window.location.href="profile";
        }

        function goBack() {
            window.history.back();
        }