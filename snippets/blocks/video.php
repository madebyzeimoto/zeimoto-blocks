<?php
// ==========================================================
// Plugins :: zeimoto :: Article :: Snippets :: Blocks :: Video
// ==========================================================
//
// Renders uploaded video or supported external video markup.
//
// ==========================================================

declare(strict_types=1);

use Kirby\Cms\Html;
use Kirby\Toolkit\Str;

/** @var \Kirby\Cms\Block $block */
$caption   = $block->caption();
$width     = $block->width()->or("narrow")->value();
$videoHtml = null;

if ($block->location()->value() === "kirby") {
  if ($videoFile = $block->video()->toFile()) {
    $autoplay = $block->autoplay()->toBool();
    $attrs    = array_filter([
      "autoplay"    => $autoplay,
      "class"       => "mds-article-video-media",
      "controls"    => $block->controls()->toBool(),
      "loop"        => $block->loop()->toBool(),
      "muted"       => $block->muted()->toBool() || $autoplay,
      "playsinline" => $autoplay,
      "poster"      => $block->poster()->toFile()?->url(),
      "preload"     => $block->preload()->value(),
    ]);

    $videoHtml = Html::video($videoFile->url(), [], $attrs);
  }
} elseif ($block->url()->isNotEmpty()) {
  $url         = $block->url()->value();
  $mediaWidth  = $block->mediaWidth()->toInt();
  $mediaHeight = $block->mediaHeight()->toInt();
  $mediaWidth  = $mediaWidth > 0 ? $mediaWidth : 1600;
  $mediaHeight = $mediaHeight > 0 ? $mediaHeight : 900;
  $isIframe    = Str::contains($url, "youtu", true) || Str::contains($url, "vimeo", true);

  $attrs = [
    "class"  => "mds-article-video-media",
    "height" => $mediaHeight,
    ...($isIframe ? [
      "loading" => "lazy",
      "title"   => trim(Str::unhtml($caption->value())) ?: t("field.blocks.video.name"),
    ] : []),
    "style" => "--mds-article-video-aspect-ratio: {$mediaWidth} / {$mediaHeight}",
    "width" => $mediaWidth,
  ];

  $videoHtml = Html::video($url, [], $attrs);
}
?>

<?php if ($videoHtml !== null): ?>
  <div id="<?= esc($block->id()) ?>" class="mds-article-video" data-width="<?= esc($width) ?>">
    <figure class="mds-article-video-group">
      <?= $videoHtml ?>

      <?php if ($caption->isNotEmpty()): ?>
        <figcaption class="mds-article-video-caption">
          <?= $caption ?>
        </figcaption>
      <?php endif ?>
    </figure>
  </div>
<?php endif ?>
