<?php
// ==========================================================
// Plugins :: zeimoto :: Blocks :: Snippets :: Blocks :: Lead
// ==========================================================
//
// Renders lead copy with an optional call to action.
//
// ==========================================================

declare(strict_types=1);

/** @var \Kirby\Cms\Block $block */
$text     = $block->text();
$ctaLabel = $block->ctaLabel();
$cta      = $block->cta()->toPage();
$width    = $block->width()->or("narrow")->value();
?>

<?php if ($text->isNotEmpty() || $cta !== null): ?>
  <div id="<?= esc($block->id()) ?>" class="mds-blocks-lead" data-width="<?= esc($width) ?>">
    <div class="mds-blocks-lead-content">
      <?php if ($text->isNotEmpty()): ?>
        <p class="mds-blocks-lead-text mds-lead"><?= $text->kirbytextinline() ?></p>
      <?php endif ?>
      <?php if ($cta !== null): ?>
        <a class="mds-blocks-lead-button" href="<?= esc($cta->url()) ?>"><?= $ctaLabel->or(t("zeimoto-blocks-lead-cta"))->html() ?></a>
      <?php endif ?>
    </div>
  </div>
<?php endif ?>
