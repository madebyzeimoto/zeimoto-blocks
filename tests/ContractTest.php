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
use PHPUnit\Framework\Attributes\DataProvider;

final class ContractTest extends PluginTestCase
{
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
    $default = new \Kirby\Form\Field("zeimoto-blocks-list", ["name" => "text", "model" => $app->site()]);
    self::assertNull($default->toolbar());
  }

  public function testRichTextBlockBlueprintsDefaultToMatchingFixedToolbars(): void
  {
    $this->app();
    foreach (["heading", "text", "list", "quote", "image", "gallery", "video"] as $type) {
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

  public function testEmptyImageAndTextRemainQuiet(): void
  {
    $this->app();
    foreach (["text", "image", "gallery"] as $type) {
      self::assertSame("", trim(snippet("blocks/" . $type, ["block" => new Block(["type" => $type])], true)));
    }
  }
}
