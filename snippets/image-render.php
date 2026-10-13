<?php
// ==========================================================
// Plugins :: zeimoto :: Blocks :: Snippets :: Image Render
// ==========================================================
//
// Selects uploaded-image rendering or external image markup.
//
// ==========================================================

declare(strict_types=1);

if ($image !== null) {
  snippet("zeimoto-blocks/image-uploaded", [
    "image" => $image,
    "class" => "mds-blocks-image-media",
    "alt" => $alt,
    "crop" => $crop,
    "ratio" => $ratio,
  ]);
} else {
  echo '<img ' . Kirby\Cms\Html::attr([
    "src" => $src,
    "alt" => $alt ?? "",
    "class" => "mds-blocks-image-media",
    "loading" => "lazy",
    "fetchpriority" => "auto",
    "data-external-image" => true,
  ]) . '>';
  echo '<div class="mds-blocks-image-fallback" hidden><p class="mds-blocks-image-message">This image is currently unavailable.</p></div>';
}
