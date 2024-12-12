<?php 

require 'header.php'
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧</title>
    <link rel="stylesheet" href="../CSS/top.css">
</head>
<div class="slider-container">
  <div class="slider">
    <!-- 自動スライドの広告部分 -->
    <div class="auto-slider" id="auto-slider">
      <div class="slide" id="auto-slide1">
        <img src="../IMG/auto1.png" alt="広告1">
      </div>
      <div class="slide" id="auto-slide2">
        <img src="../IMG/auto2.png" alt="広告2">
      </div>
      <div class="slide" id="auto-slide3">
        <img src="../IMG/auto3.png" alt="広告3">
      </div>
      <div class="slide" id="auto-slide4">
        <img src="../IMG/auto4.png" alt="広告4">
      </div>
    </div>
  </div>

  <div class="subtitle-box">
    <img src="../IMG/itigekiwo.png" alt="サブテーマ" class="subtitle">
  </div>

  <div class="manual-slider-box">
    <!-- 手動スライド -->
    <div class="manual-slider">
      <button class="manual-button" id="left-btn">←</button>
      <div class="manual-slider-images" id="slider-images">
        <img src="../IMG/DHCVC.png" class="slider-image" />
        <img src="../IMG/yoko1.jpg" class="slider-image" />
        <img src="../IMG/otonaBB.jpg" class="slider-image" />
        <img src="../IMG/Kanebou.jpg" class="slider-image" />
        <img src="../IMG/DHCVC.png" class="slider-image" />
        <img src="../IMG/yoko1.jpg" class="slider-image" />
        <!-- 他の画像 -->
      </div>
      <button class="manual-button" id="right-btn">→</button>
    </div>
  </div>
</div>

<script src="../JavaScript/top.js"></script>
</body>
</html>