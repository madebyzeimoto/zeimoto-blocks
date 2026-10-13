<?php
// ==========================================================
// Plugins :: zeimoto :: Blocks :: Snippets :: Blocks :: Image
// ==========================================================
//
// Renders uploaded or external images with links and captions.
//
// ==========================================================

declare(strict_types=1);

use Kirby\Cms\Html;

/** @var \Kirby\Cms\Block $block */
$alt     = $block->alt();
$caption = $block->caption();
$crop    = $block->crop()->isTrue();
$link    = $block->link();
$ratio   = $block->ratio()->or("auto")->value();
$src     = null;
$image   = null;
$width   = $block->width()->or("base")->value();

if ($block->location()->value() === "web") {
  $src = $block->src()->isNotEmpty() ? $block->src()->toUrl() : null;
} elseif ($image = $block->image()->toFile()) {
  $alt = $alt->or($image->alt());
  $src = $image->url();
}
?>

<?php if ($src !== null): ?>
  <div id="<?= esc($block->id()) ?>" class="mds-blocks-image" data-width="<?= esc($width) ?>">
    <figure class="mds-blocks-image-group"<?= Html::attr(["data-ratio" => $ratio, "data-crop" => $crop], null, " ") ?>>
      <?php if (($linkUrl = $link->toUrl()) !== null): ?>
        <a href="<?= esc($linkUrl) ?>" class="mds-blocks-image-link">
          <?php snippet("zeimoto-blocks/image-render", [
            "image" => $image,
            "src" => $src,
            "alt" => $alt->value(),
            "crop" => $crop,
            "ratio" => $ratio,
          ]); ?>
        </a>
      <?php else: ?>
        <a href="<?= esc($src) ?>" class="mds-blocks-image-link mds-lightgallery-item" data-no-swup>
          <?php snippet("zeimoto-blocks/image-render", [
            "image" => $image,
            "src" => $src,
            "alt" => $alt->value(),
            "crop" => $crop,
            "ratio" => $ratio,
          ]); ?>
        </a>
      <?php endif ?>
      <?php if ($caption->isNotEmpty()): ?>
        <figcaption class="mds-blocks-image-caption">
          <?= $caption ?>
        </figcaption>
      <?php endif ?>
    </figure>
  </div>
<?php endif ?>
