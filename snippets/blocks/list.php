<?php
// ==========================================================
// Plugins :: zeimoto :: Blocks :: Snippets :: Blocks :: List
// ==========================================================
//
// Renders the saved list markup within its block boundary.
//
// ==========================================================

declare(strict_types=1);

/** @var \Kirby\Cms\Block $block */
$text  = $block->text();
$width = $block->width()->or("base")->value();
?>

<?php if ($text->isNotEmpty()): ?>
  <div id="<?= esc($block->id()) ?>" class="mds-blocks-list" data-width="<?= esc($width) ?>">
    <?= $text ?>
  </div>
<?php endif ?>
