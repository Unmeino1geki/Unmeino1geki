<?php
// PHPのヘッダー設定（必要に応じてヘッダー情報を設定）
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>運命の一撃</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body class="home">

<div id="container">

<header>
    <h1 id="logo"><a href="home.php"></a></h1>

    <!--開閉ブロック-->
    <div id="menubar">
        <nav>
            <ul>
                <li><a href="home.php">HOME</a></li>
                <li><a href="login-input.php">LOGIN</a></li>
            </ul>
        </nav>
    </div>
    <!--/#menubar-->
</header>

<aside id="mainimg">
    <div class="slide slide1">
        <div>
            <h2>貴方の肌に一撃を</h2>
            <h1>運命の一撃</h1>
            <p class="btn-border-radius"><a href="touroku.php">新規登録</a></p>
        </div>
    </div>

    <div class="slide slide2">
        <div>
            <h1>運命の一撃</h1>
            <p>もう、調べる時間なんて<br>必要ない</p>
            <p class="btn-border-radius"><a href="touroku.php">新規登録</a></p>
        </div>
    </div>

    <div class="slide slide3">
        <div>
            <h1>貴方の肌に<br>輝きを！</h1>
            <p>ここで出会える<br>運命の”一”本を</p>
            <p class="btn-border-radius"><a href="touroku.php">新規登録</a></p>
        </div>
    </div>
</aside>

<div id="contents">
    <main>
        <section class="bg1">
            <h2 class="c"><span class="fade-in-text">review</span><span class="hosoku">レビュー</span></h2>
            <div class="list-grid1">
                <div class="list">
                    <figure><img src="../IMG/sample1.jpg" alt=""></figure>
                    <div class="text">
                        <h4>アブ嶺 ショーン(22)</h4>
                        <p>化粧水はハト麦でしょ！！</p>
                    </div>
                </div>

                <div class="list">
                    <figure><img src="../IMG/sample2.jpg" alt=""></figure>
                    <div class="text">
                        <h4>アブストラクト シヲン(19)</h4>
                        <p>美容よりスロ一択</p>
                    </div>
                </div>

                <div class="list">
                    <figure><img src="../IMG/sample3.jpg" alt=""></figure>
                    <div class="text">
                        <h4>アブンティー ナガン(33)</h4>
                        <p>ココでジンセイカワリマシタ</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="faq" id="faq">
            <h2><span class="kazari">FAQ</span></h2>
            <div class="text">
                <dl>
                    <h1>よく頂く質問</h1>
                    <dt>どうやって自分に合った美容品を探しているんですか？</dt>
                    <dd>登録時にこちらからのいくつかの質問に答えていただき、そこから肌質を診断します。そして、欲しい商品(化粧水など)を検索していただくときにAIが自動判別してあなたに合った商品のみ表示されるようになっています！</dd>

                    <dt>お金はかかりますか？</dt>
                    <dd>いいえ、かかりません！今後、新たな機能追加で一部有料の機能など追加予定ですが、現在使用できる機能に関しては引き続き無料でご利用いただけます。</dd>

                    <dt>手数料などで少し高くなったりしますか？</dt>
                    <dd>手数料は頂いておりません！運命の一撃は、商品の紹介サイトですのでご安心ください。</dd>
                </dl>
            </div>
        </section>

        <section>
            <h2><span class="fade-in-text">What's New</span><span class="hosoku">お知らせ</span></h2>
            <dl class="new">
                <dt>2024/12/05<span>その他</span></dt>
                <dd>AIに不具合があったため修正しました。</dd>
                <dt>2024/11/15<span>その他</span></dt>
                <dd>アカウント登録時の画面を見やすくしました。</dd>
                <dt>2024/10/10<span class="icon-bg2">重要</span></dt>
                <dd>申し訳ございません。本日から明日の朝方までメンテナンスですので、ご利用いただけません。</dd>
                <dt>2024/05/05<span class="icon-bg1">SELE</span></dt>
                <dd>[5月5日]GOGOチャンス！！今だけ、クーポン配布中！！</dd>
                <dt>2024/04/01<span>その他</span></dt>
                <dd>アブ嶺 ショーンの肌が激変</dd>
                <dt>20XX/01/01<span>その他</span></dt>
                <dd>20XX年美容界は大当たりの渦に包まれた</dd>
            </dl>
        </section>
    </main>
</div>

<ul id="footermenu">
    <li><a href="home.php">HOME</a></li>
    <li><a href="login-input.php">LOGIN</a></li>
</ul>

<footer>
    <small>ASOjuku&copy; <a href="home.php">Unmeino1geki</a> </small>
</footer>

<div class="pagetop"><a href="#"><i class="fas fa-angle-double-up"></i></a></div>

</div>

<div id="menubar_hdr">
    <span></span><span></span><span></span>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/protonet-jquery.inview/1.1.2/jquery.inview.min.js"></script>
<script src="JavaScript/jquery.inview_set.js"></script>
<script src="JavaScript/main.js"></script>

</body>
</html>
