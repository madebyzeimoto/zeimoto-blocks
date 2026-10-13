<?php
// ==========================================================
// Plugins :: zeimoto :: Blocks :: Snippets :: Blocks :: Markdown
// ==========================================================
//
// Renders Markdown content through Kirbytext.
//
// ==========================================================

declare(strict_types=1);

/** @var \Kirby\Cms\Block $block */
$text  = $block->text();
$width = $block->width()->or("base")->value();
?>

<?php if ($text->isNotEmpty()): ?>
  <div id="<?= esc($block->id()) ?>" class="mds-blocks-markdown" data-width="<?= esc($width) ?>">
    <?= $text->kt() ?>
  </div>
<?php endif ?>
