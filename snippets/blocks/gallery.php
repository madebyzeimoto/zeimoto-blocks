<?php
// ==========================================================
// Plugins :: zeimoto :: Blocks :: Snippets :: Blocks :: Gallery
// ==========================================================
//
// Renders uploaded gallery images, captions, and lightbox links.
//
// ==========================================================

declare(strict_types=1);

use Kirby\Cms\Html;

/** @var \Kirby\Cms\Block $block */
$caption = $block->caption();
$crop    = $block->crop()->isTrue();
$images  = $block->images()->toFiles();
$ratio   = $block->ratio()->or("auto")->value();
$width   = $block->width()->or("base")->value();
?>

<?php if ($images->isNotEmpty()): ?>
  <div id="<?= esc($block->id()) ?>" class="mds-blocks-gallery" data-width="<?= esc($width) ?>">
    <figure class="mds-blocks-gallery-group"<?= Html::attr(["data-ratio" => $ratio, "data-crop" => $crop], null, " ") ?>>
      <ul class="mds-blocks-gallery-list">
        <?php foreach ($images as $image): ?>
          <li class="mds-blocks-gallery-item">
            <a href="<?= esc($image->url()) ?>" class="mds-blocks-gallery-link mds-lightgallery-item" data-no-swup>
              <?php snippet("zeimoto-blocks/image-uploaded", [
                "image" => $image,
                "class" => "mds-blocks-gallery-image",
                "crop" => $crop,
                "ratio" => $ratio,
              ]); ?>
            </a>
          </li>
        <?php endforeach ?>
      </ul>
      <?php if ($caption->isNotEmpty()): ?>
        <figcaption class="mds-blocks-gallery-caption">
          <?= $caption ?>
        </figcaption>
      <?php endif ?>
    </figure>
  </div>
<?php endif ?>
