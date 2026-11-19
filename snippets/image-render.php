<?php
// ==========================================================
// Plugins :: zeimoto :: Article :: Snippets :: Image Render
// ==========================================================
//
// Selects uploaded-image rendering or external image markup.
//
// ==========================================================

declare(strict_types=1);

if ($image !== null) {
  snippet("zeimoto-article/image-uploaded", [
    "image" => $image,
    "class" => "mds-article-image-media",
    "alt" => $alt,
    "crop" => $crop,
    "ratio" => $ratio,
  ]);
} else {
  echo '<img ' . Kirby\Cms\Html::attr([
    "src" => $src,
    "alt" => $alt ?? "",
    "class" => "mds-article-image-media",
    "loading" => "lazy",
    "fetchpriority" => "auto",
    "data-external-image" => true,
  ]) . '>';
  echo '<div class="mds-article-image-fallback" hidden><p class="mds-article-image-message">This image is currently unavailable.</p></div>';
}
