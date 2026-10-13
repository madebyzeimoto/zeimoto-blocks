<?php
// ==========================================================
// Plugins :: zeimoto :: Blocks :: Snippets :: Blocks :: Heading
// ==========================================================
//
// Renders a validated heading level and inline heading text.
//
// ==========================================================

declare(strict_types=1);

/** @var \Kirby\Cms\Block $block */
$text  = $block->text();
$level = $block->level()->value();
$width = $block->width()->or("base")->value();

if (in_array($level, ["h2", "h3", "h4", "h5", "h6"], true) === false) {
  $level = "h2";
}
?>

<?php if ($text->isNotEmpty()): ?>
  <div id="<?= esc($block->id()) ?>" class="mds-blocks-heading" data-width="<?= esc($width) ?>">
    <<?= $level ?> class="mds-blocks-heading-title"><?= $text ?></<?= $level ?>>
  </div>
<?php endif ?>
