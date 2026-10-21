# zeimoto Blocks

Custom Kirby blocks with Panel blueprints and frontend snippets.

## Installation

Requires PHP 8.5 and Kirby 5.6.1 or later within Kirby 5.
The Composer package is `zeimoto/blocks` and installs into
`site/plugins/zeimoto-blocks`. Release versions come from Git tags.

Once published on Packagist:

```sh
composer require zeimoto/blocks
```

For manual installation, copy this plugin into `site/plugins/zeimoto-blocks`.
See the integration requirements below before using its public surfaces.
The plugin is distributed under the MIT license; see [LICENSE](LICENSE).

## Compiler compatibility

The Quote editor uses a render function, so the released Panel assets work with
`panel.vue.compiler: false`. Rebuild with `npm run build` after editing its
source; Composer installations use the included `index.js` and `index.css`.

## Panel development

Kirby loads the included `index.js` and `index.css`; installing a release does
not require a Node build. To edit the Panel source, use Node 24 and run these
commands from the plugin directory:

```sh
npm ci
npm run dev
```

Stop development and run `npm run build` before committing a release. This
replaces the temporary development loader with the production assets. The kit's
`npm run dev:plugins` command also manages this plugin build. Ordinary host
development and production builds use the included Panel assets.

## Dependencies

Uploaded gallery and image-block files are rendered by `zeimoto-image`.
Image, gallery and video-poster uploads use the host’s `image` file blueprint.
Local video uploads use its `audiovisual` blueprint. The host supplies both
blueprints; video selection still queries `model.videos`, including existing
videos with other templates.
The quote block's text field uses the inline rich-text field from `zeimoto-writer`.
Composer metadata requires both `zeimoto/image` and `zeimoto/writer` at `^0.1`.
For manual installation, install and enable `zeimoto-image` and `zeimoto-writer`
alongside this plugin. Uploaded-image rendering reports a clear error if its
image helpers are absent.

## Rich-text block defaults

Heading, text, list, quote, and image/gallery/video caption fields default to
persistent toolbars with bold, italic, strikethrough, link, and clear formatting.
Lists additionally retain their native bulleted/numbered list controls.

The shared media caption preview places its toolbar across the top of the media
block, with the caption text below the media. Kirby displays the caption preview
when a caption has content; use the block settings to add an empty caption.
The caption toolbar is always fixed in the preview. Plain-text attribution,
URLs, code, and Markdown fields retain their existing editors.

## Heading toolbar

Heading blocks with `toolbar.inline: false` display an edge-to-edge toolbar,
matching text and list blocks. Heading text retains its inset with space for
the level selector beside it. Setting `toolbar.inline: true` retains Kirby's
native floating layout.

## Quote toolbar

The quote preview forwards the text field's `toolbar` configuration to Kirby's
Writer input. The bundled blueprint sets `toolbar.inline: false` for a persistent
formatting toolbar. Set `toolbar.inline: true` to use a floating toolbar.
The fixed toolbar spans the top edge of the block; the quote rule and attribution
remain below it. Citation and role remain plain text; source remains a URL field.

## List toolbar

The list block uses the plugin-owned `zeimoto-blocks-list` field, extending
Kirby's native List field with a `toolbar` option. The Panel preview forwards
`marks`, `nodes`, and `toolbar` while preserving native list editing and stored HTML.

```yaml
list:
  extends: blocks/list
  fields:
    text:
      marks:
        - bold
        - italic
        - strike
        - "|"
        - link
        - "|"
        - clear
      nodes:
        - bulletList
        - orderedList
      toolbar:
        inline: false
```

This keeps formatting and the native list selector visible without selecting
text. Set `toolbar.inline: true` to use Kirby's floating toolbar. Fixed list toolbars
align with native text block toolbars. No content migration is required.

## Gallery and image rendering

Block crop enabled with a valid ratio uses `zeimotoImageThumbnail()` for
responsive previews, with dimensions fitted to the ratio within the configured
`zeimoto.image.maxDimensionsDesktop`, `maxDimensionsLaptop`, `maxDimensionsTablet`, and
`maxDimensionsMobile` bounds. Each source file supplies its own focal point.
The block settings take precedence over the file's saved ratio/crop settings.

Crop disabled, ratio Auto, or an invalid ratio uses `zeimotoImage()` to retain
the full composition. A selected ratio still defines the CSS display box when
crop is disabled. Processing never enlarges smaller files or changes stored
sources. Shared image format, quality, and breakpoints come from `zeimoto-image`.
Images use lazy loading and automatic fetch priority.

Gallery lightbox links open stored full images. Individual image blocks retain
custom links or open the full image in the lightbox. Block alt text overrides
file alt text for individual images; gallery items use file alt text. An empty
alt attribute remains present when no description is available.

External URLs remain ordinary image elements. Their existing CSS ratio/crop
behavior is preserved; no remote download, generated derivatives, Kirby focal
point processing, or responsive file optimisation is performed.

## Unavailable external images

If an external image fails to load, the public frontend replaces it with
“This image is currently unavailable.” The selected ratio box, block width,
caption, and custom link remain. Its original-image lightbox link is removed,
and the affected lightGallery group is refreshed.

This requires the plugin's `frontend/image.js` module, wired through the kit's
public entry on initial load and after Swup navigation. Manual integrations
must call `initializeExternalImages()` on those same lifecycle events and pass
their lightbox refresh callback when applicable. Without JavaScript, ordinary
browser image behavior remains. Loading failures do not establish whether the
remote image was deleted; no remote copies, retries, or server checks are made.

Uploaded block images use the image plugin's resolution candidates and default
`auto, 100vw` sizes with lazy loading. Supporting browsers select from actual
layout widths; other browsers use viewport-width sizing, which can overestimate
gallery columns. Narrow/Base widths and grid gaps remain CSS-owned. External
images do not gain generated candidates.

## Development environment

Open `kirby.code-workspace` while this plugin is installed under the zeimoto Kirby
Kit's `site/plugins/` directory. The workspace uses the kit's Composer and npm
dependencies, shared formatting rules, and Kirby classes for autocomplete. IDE
stubs are included; local editor settings, caches, private notes, and `.env` are
ignored. The formatter launcher currently requires Herd's PHP 8.5 on macOS.

Install Composer and npm dependencies at the kit root. From that root, check this
plugin with:

```sh
node tools/check-style.mjs --plugin site/plugins/zeimoto-blocks
```

Blocks also requires `npm ci` in its own directory for its Panel asset build.
Keep the shipped `index.js` and `index.css` in the repository.

## Behavior tests

Run `composer install` and `composer test` from this repository. Tests boot Kirby
with disposable runtime directories and never load project secrets or send real
mail. The host kit can also run this suite with `composer test:plugins`.
