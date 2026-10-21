<?php
// ==========================================================
// Plugins :: zeimoto :: Blocks
// ==========================================================
//
// Owns zeimoto's custom Kirby blocks, including their Panel
// editors, block blueprints, and public rendering snippets.
//
// ==========================================================

declare(strict_types=1);

Kirby::plugin("zeimoto/blocks", [
  "fields" => [
    "zeimoto-blocks-list" => [
      "extends" => "list",
      "props" => [
        "toolbar" => function (array|null $toolbar = null): array|null {
          return $toolbar;
        },
      ],
    ],
  ],
  "blueprints" => [
    "blocks/code" => __DIR__ . "/blueprints/blocks/code.yml",
    "blocks/gallery" => __DIR__ . "/blueprints/blocks/gallery.yml",
    "blocks/heading" => __DIR__ . "/blueprints/blocks/heading.yml",
    "blocks/image" => __DIR__ . "/blueprints/blocks/image.yml",
    "blocks/line" => __DIR__ . "/blueprints/blocks/line.yml",
    "blocks/list" => __DIR__ . "/blueprints/blocks/list.yml",
    "blocks/markdown" => __DIR__ . "/blueprints/blocks/markdown.yml",
    "blocks/quote" => __DIR__ . "/blueprints/blocks/quote.yml",
    "blocks/text" => __DIR__ . "/blueprints/blocks/text.yml",
    "blocks/video" => __DIR__ . "/blueprints/blocks/video.yml",
    "fields/zeimoto-blocks/crop" => __DIR__ . "/blueprints/fields/crop.yml",
    "fields/zeimoto-blocks/ratio" => __DIR__ . "/blueprints/fields/ratio.yml",
    "fields/zeimoto-blocks/width" => __DIR__ . "/blueprints/fields/width.yml",
  ],
  "snippets" => [
    "zeimoto-blocks/image-render" => __DIR__ . "/snippets/image-render.php",
    "zeimoto-blocks/image-uploaded" => __DIR__ . "/snippets/image-uploaded.php",
    "blocks/code" => __DIR__ . "/snippets/blocks/code.php",
    "blocks/gallery" => __DIR__ . "/snippets/blocks/gallery.php",
    "blocks/heading" => __DIR__ . "/snippets/blocks/heading.php",
    "blocks/image" => __DIR__ . "/snippets/blocks/image.php",
    "blocks/line" => __DIR__ . "/snippets/blocks/line.php",
    "blocks/list" => __DIR__ . "/snippets/blocks/list.php",
    "blocks/markdown" => __DIR__ . "/snippets/blocks/markdown.php",
    "blocks/quote" => __DIR__ . "/snippets/blocks/quote.php",
    "blocks/text" => __DIR__ . "/snippets/blocks/text.php",
    "blocks/video" => __DIR__ . "/snippets/blocks/video.php",
  ],
]);
