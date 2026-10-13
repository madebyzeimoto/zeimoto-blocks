<?php
// ==========================================================
// Plugins :: zeimoto :: Blocks :: Snippets :: Blocks :: Text
// ==========================================================
//
// Renders saved rich text within its block boundary.
//
// ==========================================================

declare(strict_types=1);

/** @var \Kirby\Cms\Block $block */
$text  = $block->text();
$width = $block->width()->or("base")->value();
?>

<?php if ($text->isNotEmpty()): ?>
  <div id="<?= esc($block->id()) ?>" class="mds-blocks-text" data-width="<?= esc($width) ?>">
    <?= $text ?>
  </div>
<?php endif ?>
