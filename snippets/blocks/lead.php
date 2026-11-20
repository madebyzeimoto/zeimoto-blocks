<?php
// ==========================================================
// Plugins :: zeimoto :: Blocks :: Snippets :: Blocks :: Lead
// ==========================================================
//
// Renders lead copy with an optional call to action, reusing
// the MDS lead callout markup.
//
// ==========================================================

declare(strict_types=1);

/** @var \Kirby\Cms\Block $block */
$text     = $block->text();
$ctaLabel = $block->ctaLabel();
$cta      = $block->cta()->toPage();
?>

<?php if ($text->isNotEmpty() || $cta !== null): ?>
  <div id="<?= esc($block->id()) ?>" class="mds-lead-callout">
    <div class="mds-lead-callout-box">
      <div class="mds-lead-callout-content">
        <?php if ($text->isNotEmpty()): ?>
          <p class="mds-lead-callout-text mds-lead"><?= $text->kirbytextinline() ?></p>
        <?php endif ?>
        <?php if ($cta !== null): ?>
          <a class="mds-lead-callout-button" href="<?= esc($cta->url()) ?>"><?= $ctaLabel->or(t("lead-cta", "Read more"))->html() ?></a>
        <?php endif ?>
      </div>
    </div>
  </div>
<?php endif ?>
