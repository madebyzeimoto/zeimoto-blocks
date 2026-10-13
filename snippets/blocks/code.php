<?php
// ==========================================================
// Plugins :: zeimoto :: Blocks :: Snippets :: Blocks :: Code
// ==========================================================
//
// Renders escaped code while preserving its stored whitespace.
//
// ==========================================================

declare(strict_types=1);

/** @var \Kirby\Cms\Block $block */
$code     = $block->code();
$language = $block->language()->or("text")->value();
$width    = $block->width()->or("base")->value();
?>

<?php if ($code->isNotEmpty()): ?>
  <div id="<?= esc($block->id()) ?>" class="mds-blocks-code" data-width="<?= esc($width) ?>">
    <pre class="mds-blocks-code-group"><code class="mds-blocks-code-text mds-blocks-language-<?= esc($language) ?>"><?= $code->html() ?></code></pre>
  </div>
<?php endif ?>
