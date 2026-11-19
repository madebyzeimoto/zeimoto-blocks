<?php
// ==========================================================
// Plugins :: zeimoto :: Article :: Snippets :: Blocks :: Gallery
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
$width   = $block->width()->or("narrow")->value();
?>

<?php if ($images->isNotEmpty()): ?>
  <div id="<?= esc($block->id()) ?>" class="mds-article-gallery" data-width="<?= esc($width) ?>">
    <figure class="mds-article-gallery-group"<?= Html::attr(["data-ratio" => $ratio, "data-crop" => $crop], null, " ") ?>>
      <ul class="mds-article-gallery-list">
        <?php foreach ($images as $image): ?>
          <li class="mds-article-gallery-item">
            <a href="<?= esc($image->url()) ?>" class="mds-article-gallery-link mds-lightgallery-item" data-no-swup>
              <?php snippet("zeimoto-article/image-uploaded", [
                "image" => $image,
                "class" => "mds-article-gallery-image",
                "crop" => $crop,
                "ratio" => $ratio,
              ]); ?>
            </a>
          </li>
        <?php endforeach ?>
      </ul>
      <?php if ($caption->isNotEmpty()): ?>
        <figcaption class="mds-article-gallery-caption">
          <?= $caption ?>
        </figcaption>
      <?php endif ?>
    </figure>
  </div>
<?php endif ?>
