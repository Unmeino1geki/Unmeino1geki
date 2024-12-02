<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>美容製品検索 - ヤフーAPI版</title>
    <link rel="stylesheet" href="../CSS/API.css"> <!-- CSSパスの確認 -->
</head>
<body>
    <header class="header">
        <h1 class="logo">運命の一撃.com</h1>
        <div class="search-container">
            <form method="GET">
                <input type="text" name="query" id="searchBar" placeholder="美容品を検索" 
                    value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query'], ENT_QUOTES) : ''; ?>">
                <button type="submit">🔍</button>
            </form>
        </div>
    </header>

    <div class="product-grid">
    <?php
if (isset($_GET['query']) && $_GET['query'] !== '') {
    $clientId = 'dj00aiZpPXkxem0yQmltUVJhWSZzPWNvbnN1bWVyc2VjcmV0Jng9Nzc-';
    $searchQuery = $_GET['query'];

    // Yahoo APIリクエストURL構築
    $apiUrl = "https://shopping.yahooapis.jp/ShoppingWebService/V3/itemSearch";
    $apiUrl .= "?appid=" . urlencode($clientId);
    $apiUrl .= "&query=" . urlencode($searchQuery);
    $apiUrl .= "&results=50"; // 最大50件取得

    // APIリクエスト
    $response = file_get_contents($apiUrl);
    if ($response !== FALSE) {
        $products = json_decode($response, true);

        if (isset($products['hits']) && count($products['hits']) > 0) {
            foreach ($products['hits'] as $product) {
                echo "<div class='product-card'>";
                echo "<a href='Detail.php?code=" . urlencode($product['code']) . "'>"; // 商品コードを渡す
                echo "<img src='" . htmlspecialchars($product['image']['medium'], ENT_QUOTES) . "' alt='" . htmlspecialchars($product['name'], ENT_QUOTES) . "'>";
                echo "<div class='product-info'>";
                echo "<p class='product-name'>" . mb_strimwidth(htmlspecialchars($product['name'], ENT_QUOTES), 0, 50, '...') . "</p>";
                echo "<p class='price'>" . htmlspecialchars(number_format($product['price']), ENT_QUOTES) . "円</p>";
                echo "<p class='shop-name'>" . htmlspecialchars($product['seller']['name'], ENT_QUOTES) . "</p>";
                echo "</div>";
                echo "</a>";
                echo "</div>";
            }
        } else {
            echo "<p>商品が見つかりませんでした。</p>";
        }
    } else {
        echo "<p>APIからデータを取得できませんでした。</p>";
    }
} else {
    echo "<p>検索キーワードを入力してください。</p>";
}
?>

    </div>
</body>
</html>
