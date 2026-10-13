<?php
// ==========================================================
// Plugins :: zeimoto :: Blocks :: Snippets :: Blocks :: Quote
// ==========================================================
//
// Renders quote text, attribution, and source metadata.
//
// ==========================================================

declare(strict_types=1);

use Kirby\Cms\Html;

/** @var \Kirby\Cms\Block $block */
$text       = $block->text();
$citation   = $block->citation();
$role       = $block->role();
$source     = $block->source();
$isExternal = $block->isExternal()->toBool();
$sourceUrl  = $source->toUrl();
$width      = $block->width()->or("base")->value();
?>

<?php if ($text->isNotEmpty()): ?>
  <div id="<?= esc($block->id()) ?>" class="mds-blocks-quote" data-width="<?= esc($width) ?>">
    <figure class="mds-blocks-quote-group" itemscope itemtype="https://schema.org/Quotation">
      <blockquote class="mds-blocks-quote-text" itemprop="text" <?php if ($sourceUrl !== null): ?>cite="<?= esc($sourceUrl) ?>"<?php endif ?>>
        <?= $text->kirbytextinline() ?>
      </blockquote>
      <?php if ($citation->isNotEmpty() || $role->isNotEmpty() || $sourceUrl !== null): ?>
        <figcaption class="mds-blocks-quote-attribution">
          <?php if ($citation->isNotEmpty()): ?>
            <span class="mds-blocks-quote-author" itemprop="author" itemscope itemtype="https://schema.org/Person">— <span class="mds-blocks-quote-citation" itemprop="name"><?= $citation->html() ?></span><?php if ($role->isNotEmpty()): ?><meta itemprop="jobTitle" content="<?= $role->html() ?>"><?php endif ?></span><?php if ($role->isNotEmpty() || $sourceUrl !== null): ?>, <?php endif ?>
          <?php endif ?>
          <?php if ($role->isNotEmpty()): ?>
            <span class="mds-blocks-quote-role"><?= $role->html() ?></span><?php if ($sourceUrl !== null): ?>, <?php endif ?>
          <?php endif ?>
          <?php if ($sourceUrl !== null): ?>
            <?= Html::a($sourceUrl, "Source", [
              "class" => "mds-blocks-quote-source",
              "itemprop" => "citation",
              "target" => $isExternal ? "_blank" : null,
              "rel" => $isExternal ? "noopener" : null,
            ]) ?>
          <?php endif ?>
        </figcaption>
      <?php endif ?>
    </figure>
  </div>
<?php endif ?>
