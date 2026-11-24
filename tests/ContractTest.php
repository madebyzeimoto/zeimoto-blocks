<?php
// ==========================================================
// Tests :: Blocks Contracts
// ==========================================================
//
// Exercises the plugin public behavior with disposable Kirby fixtures.
//
// ==========================================================

declare(strict_types=1);

namespace Zeimoto\Blocks\Tests;

use Kirby\Cms\Block;
use Kirby\Cms\Blueprint;
use Kirby\Form\Field;
use PHPUnit\Framework\Attributes\DataProvider;

final class ContractTest extends PluginTestCase
{
  public function testWidthVocabularyMatchesTheMdsScale(): void
  {
    $this->app();
    $field = Blueprint::extend("fields/zeimoto-blocks/width");
    self::assertSame([
      "narrowest" => "Narrowest",
      "narrower" => "Narrower",
      "narrow" => "Narrow",
      "base" => "Base",
      "wide" => "Wide",
      "wider" => "Wider",
      "widest" => "Widest",
    ], $field["options"]);
    self::assertSame("narrow", $field["default"]);

    $block = new Block(["type" => "code", "content" => ["code" => "test", "width" => "widest"]]);
    self::assertStringContainsString('data-width="widest"', snippet("blocks/code", ["block" => $block], true));

    $block = new Block(["type" => "code", "content" => ["code" => "test"]]);
    self::assertStringContainsString('data-width="narrow"', snippet("blocks/code", ["block" => $block], true));
  }

  public function testListToolbarSurvivesFieldsetSerialization(): void
  {
    $app = $this->app();
    $fieldset = new \Kirby\Cms\Fieldset([
      "type" => "list",
      "fields" => ["text" => [
        "type" => "zeimoto-blocks-list",
        "marks" => ["bold", "italic", "link"],
        "nodes" => ["bulletList", "orderedList"],
        "toolbar" => ["inline" => false],
      ]],
    ]);
    $field = $fieldset->fields()["text"];
    self::assertSame(["inline" => false], $field["toolbar"]);
    self::assertSame(["bold", "italic", "link"], $field["marks"]);
    self::assertSame(["bulletList", "orderedList"], $field["nodes"]);
    $class = Field::resolve("zeimoto-blocks-list");
    $default = new $class(name: "text", model: $app->site());
    self::assertNull($default->toolbar());
  }

  public function testRichTextBlockBlueprintsDefaultToMatchingFixedToolbars(): void
  {
    $this->app();
    foreach (["heading", "text", "list", "quote", "lead", "image", "gallery", "video"] as $type) {
      $fieldset = new \Kirby\Cms\Fieldset([
        ...\Kirby\Cms\Blueprint::extend("blocks/" . $type),
        "type" => $type,
      ]);
      $field = $fieldset->fields()[in_array($type, ["image", "gallery", "video"], true) ? "caption" : "text"];
      self::assertSame(["inline" => false], $field["toolbar"], $type);
      self::assertSame(["bold", "italic", "strike", "|", "link", "|", "clear"], $field["marks"], $type);
    }
  }

  public function testCodeEscapesTextAndPreservesWhitespace(): void
  {
    $this->app();
    $block = new Block(["type" => "code", "content" => ["code" => "  <script>bad()</script>\n", "language" => "html", "width" => "narrow"]]);
    $html = snippet("blocks/code", ["block" => $block], true);
    self::assertStringContainsString("  &lt;script&gt;bad()&lt;/script&gt;\n", $html);
    self::assertStringContainsString("data-width=\"narrow\"", $html);
    self::assertStringNotContainsString("<script>", $html);
  }

  public static function headings(): array
  {
    return [["h3", "h3"], ["script", "h2"], ["h1", "h2"]];
  }

  #[DataProvider("headings")]
  public function testHeadingLevelVocabulary(string $stored, string $expected): void
  {
    $this->app();
    $html = snippet("blocks/heading", ["block" => new Block(["type" => "heading", "content" => ["text" => "Title", "level" => $stored]])], true);
    self::assertStringContainsString("<" . $expected . " ", $html);
  }

  public function testLeadRendersTextAndPageCta(): void
  {
    $this->app([], ["children" => [["slug" => "about", "num" => 1, "content" => ["title" => "About"]]]]);
    $html = snippet("blocks/lead", ["block" => new Block(["type" => "lead", "content" => ["text" => "Hello <strong>world</strong>", "cta" => "- about", "ctaLabel" => "Learn & more"]])], true);
    self::assertStringContainsString('class="mds-blocks-lead" data-width="narrow"', $html);
    self::assertStringContainsString('class="mds-blocks-lead-text mds-lead">Hello <strong>world</strong></p>', $html);
    self::assertStringContainsString('href="http://localhost/about"', $html);
    self::assertStringContainsString(">Learn &amp; more</a>", $html);

    $html = snippet("blocks/lead", ["block" => new Block(["type" => "lead", "content" => ["cta" => "- about", "width" => "base"]])], true);
    self::assertStringContainsString('class="mds-blocks-lead" data-width="base"', $html);
    self::assertStringContainsString(">Read more</a>", $html);
    self::assertStringNotContainsString("mds-blocks-lead-text", $html);

    $html = snippet("blocks/lead", ["block" => new Block(["type" => "lead", "content" => ["text" => "Only text"]])], true);
    self::assertStringNotContainsString("mds-blocks-lead-button", $html);
  }

  public function testFrontendTextUsesNamespacedPluginTranslations(): void
  {
    $this->app();
    self::assertSame("Read more", t("zeimoto-blocks-lead-cta"));
    self::assertSame("Source", t("zeimoto-blocks-quote-source"));
    self::assertSame("This image is currently unavailable.", t("zeimoto-blocks-image-unavailable"));

    $html = snippet("blocks/quote", ["block" => new Block(["type" => "quote", "content" => ["text" => "Quoted", "source" => "https://example.com"]])], true);
    self::assertStringContainsString('class="mds-blocks-quote-source"', $html);
    self::assertStringContainsString(">Source</a>", $html);
  }

  public function testPanelTextUsesNamespacedPluginTranslations(): void
  {
    $this->app();
    self::assertSame("Lead", t("zeimoto-blocks.blocks.lead.name"));
    self::assertSame("Auto", t("zeimoto-blocks.fields.ratio-placeholder"));
    self::assertSame(["*" => "zeimoto-blocks.blocks.lead.name"], Blueprint::extend("blocks/lead")["name"]);
    self::assertSame(["*" => "zeimoto-blocks.fields.ratio-placeholder"], Blueprint::extend("fields/zeimoto-blocks/ratio")["placeholder"]);
  }

  public function testEmptyImageAndTextRemainQuiet(): void
  {
    $this->app();
    foreach (["text", "lead", "image", "gallery"] as $type) {
      self::assertSame("", trim(snippet("blocks/" . $type, ["block" => new Block(["type" => $type])], true)));
    }
  }
}
