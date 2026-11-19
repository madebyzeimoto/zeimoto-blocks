<?php
// ==========================================================
// Plugins :: zeimoto :: Blocks :: Snippets :: Image Uploaded
// ==========================================================
//
// Resolves block crop dimensions and delegates to the image plugin.
//
// ==========================================================

declare(strict_types=1);

if (!function_exists("zeimotoImage") || !function_exists("zeimotoImageThumbnail")) {
  throw new LogicException("zeimoto-blocks requires zeimoto-image to render uploaded images. Install and enable zeimoto-image.");
}

$props = ["image" => $image, "class" => $class];
if (is_string($alt ?? null)) {
  $props["alt"] = $alt;
}

if ($crop && preg_match('~^([1-9][0-9]*)/([1-9][0-9]*)$~', $ratio, $parts) === 1) {
  $ratioWidth = (int) $parts[1];
  $ratioHeight = (int) $parts[2];

  foreach (["Desktop", "Laptop", "Tablet", "Mobile"] as $breakpoint) {
    $option = "zeimoto.image.maxDimensions{$breakpoint}";
    $bounds = $kirby->option($option);
    if (!is_array($bounds) || !array_is_list($bounds) || count($bounds) !== 2 ||
      !is_int($bounds[0]) || !is_int($bounds[1]) || $bounds[0] <= 0 || $bounds[1] <= 0
    ) {
      throw new InvalidArgumentException("{$option} must contain two positive integer maximum dimensions.");
    }

    $scale = min($bounds[0] / $ratioWidth, $bounds[1] / $ratioHeight);
    $props["dimensions{$breakpoint}"] = [
      max(1, (int) round($ratioWidth * $scale)),
      max(1, (int) round($ratioHeight * $scale)),
    ];
  }

  $props["dimensions"] = $props["dimensionsDesktop"];
  echo zeimotoImageThumbnail($props);
} else {
  echo zeimotoImage($props);
}
