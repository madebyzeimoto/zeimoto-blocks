<?php
// ==========================================================
// Plugins :: zeimoto :: Article :: Snippets :: Blocks :: Code
// ==========================================================
//
// Renders escaped code while preserving its stored whitespace.
//
// ==========================================================

declare(strict_types=1);

/** @var \Kirby\Cms\Block $block */
$code     = $block->code();
$language = $block->language()->or("text")->value();
$width    = $block->width()->or("narrow")->value();
?>

<?php if ($code->isNotEmpty()): ?>
  <div id="<?= esc($block->id()) ?>" class="mds-article-code" data-width="<?= esc($width) ?>">
    <pre class="mds-article-code-group"><code class="mds-article-code-text mds-article-language-<?= esc($language) ?>"><?= $code->html() ?></code></pre>
  </div>
<?php endif ?>
