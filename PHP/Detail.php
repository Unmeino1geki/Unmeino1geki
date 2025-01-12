<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品詳細</title>
    <link rel="stylesheet" href="../CSS/detail.css"> <!-- CSSのパスを確認 -->
</head>
<body>
<?php
require 'header.php';

// 商品コードを取得
if (isset($_GET['code']) && $_GET['code'] !== '') {
    $clientId = 'dj00aiZpPXkxem0yQmltUVJhWSZzPWNvbnN1bWVyc2VjcmV0Jng9Nzc-';
    $productCode = $_GET['code'];

    echo "商品コード: " . htmlspecialchars($productCode, ENT_QUOTES);  // 商品コードを表示

    // Yahoo APIリクエストURL構築
    $apiUrl = "https://shopping.yahooapis.jp/ShoppingWebService/V1/itemLookup";
    $apiUrl .= "?appid=" . urlencode($clientId);
    $apiUrl .= "&itemcode=" . urlencode($productCode);

    // APIリクエスト
    $response = file_get_contents($apiUrl);
    if ($response !== FALSE) {
        $products = json_decode($response, true);

        // レスポンスの内容を確認するためにデバッグ出力
        echo "<pre>";
        print_r($products);  // レスポンスの内容を表示
        echo "</pre>";

        // レスポンスが正しい場合、商品情報を表示
         foreach ($products['hits'] as $product) {
            $product = $products['hits'][0];
            echo "<div class='product-detail'>";
            echo "<h1>" . htmlspecialchars($product['name'], ENT_QUOTES) . "</h1>";
            echo "<img src='" . htmlspecialchars($product['image']['medium'], ENT_QUOTES) . "' alt='" . htmlspecialchars($product['name'], ENT_QUOTES) . "'>";
            echo "<p class='price'>" . htmlspecialchars(number_format($product['price']), ENT_QUOTES) . "円</p>";
            echo "<p class='description'>" . htmlspecialchars($product['description'], ENT_QUOTES) . "</p>";
            echo "<p class='shop-name'>販売店: " . htmlspecialchars($product['seller']['name'], ENT_QUOTES) . "</p>";
            echo "<a href='" . htmlspecialchars($product['url'], ENT_QUOTES) . "' target='_blank'>購入ページへ</a>";
            echo "</div>";

            echo "商品コード: " . htmlspecialchars($productCode, ENT_QUOTES);  // 商品コードを表示

        // } else {
        //     echo "<p>商品詳細が見つかりませんでした。</p>";
        
        }
    } else {
        echo "<p>APIからデータを取得できませんでした。</p>";
    }
} else {
    echo "<p>商品コードが指定されていません。</p>";
}
?>
</body>
</html>

        <img src="https://item-shopping.c.yimg.jp/i/g/cosme-link_y3348901581035" alt="クリスチャンディオール カプチュール トータル インテンシブ エッセンス ローション 150ml (581035)">
        <div class="product-info">
            <p class="product-name">クリスチャンディオール カプチュール トータル イ...</p>
        <p class="price">9,940円</p>
        <p class="shop-name">コスメリンク Yahoo!店</p>
        </div>