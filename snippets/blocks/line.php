<?php
// ==========================================================
// Plugins :: zeimoto :: Blocks :: Snippets :: Blocks :: Line
// ==========================================================
//
// Renders a divider within the selected block width.
//
// ==========================================================

declare(strict_types=1);

/** @var \Kirby\Cms\Block $block */
$width = $block->width()->or("base")->value();
?>

<div id="<?= esc($block->id()) ?>" class="mds-blocks-line" data-width="<?= esc($width) ?>">
  <hr class="mds-blocks-line-divider">
</div>
