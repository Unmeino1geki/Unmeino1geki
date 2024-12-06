const autoSlides = document.querySelectorAll('.auto-slider .slide');
let autoSlideIndex = 0;

function changeAutoSlide() {
  autoSlides.forEach((slide, index) => {
    slide.classList.toggle('active', index === autoSlideIndex);
  });
  autoSlideIndex = (autoSlideIndex + 1) % autoSlides.length;
}

setInterval(changeAutoSlide, 6000);

// 初期表示設定
changeAutoSlide();

// 手動スライド用（画像の順序ループ対応）
let manualSlideIndex = 1; // 初期位置は2番目（1番目の画像）
const sliderImages = document.getElementById('slider-images');
const totalImages = sliderImages.children.length;

function moveManualSlider(direction) {
  if (direction === 'right') {
    manualSlideIndex++;
    if (manualSlideIndex >= totalImages - 1) {
      // 最後の画像（5番目の4）をスライド後に2番目に戻る
      sliderImages.style.transition = 'transform 0.5s ease';
      setTimeout(() => {
        sliderImages.style.transition = 'none'; // アニメーションを止めて瞬時に移動
        manualSlideIndex = 1; // 2番目の画像（1）に戻る
        updateManualSliderPosition();
      }, 500);
    }
  } else if (direction === 'left') {
    manualSlideIndex--;
    if (manualSlideIndex < 0) {
      // 最初の画像（1番目の4）から戻る場合
      sliderImages.style.transition = 'none'; // アニメーションを停止
      manualSlideIndex = totalImages - 2; // 最後の画像（4）に移動
      updateManualSliderPosition();
      setTimeout(() => {
        sliderImages.style.transition = 'transform 0.5s ease'; // アニメーション再開
      });
    }
  }
  updateManualSliderPosition();
}

// 手動スライド位置更新関数
function updateManualSliderPosition() {
  const translateX = -manualSlideIndex * 599.72; // 画像幅に応じて調整
  sliderImages.style.transform = `translateX(${translateX}px)`;
}

// ボタンイベント
document.getElementById('left-btn').addEventListener('click', () => moveManualSlider('left'));
document.getElementById('right-btn').addEventListener('click', () => moveManualSlider('right'));

// 6秒ごとの自動スライド
setInterval(() => moveManualSlider('right'), 6000);
