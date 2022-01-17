<?php declare(strict_types = 1);

namespace Drupal\theme_inspector;

/**
 * Interface for theme preview plugins.
 */
interface ThemePreviewInterface {

  public function build(string $variation): array;

}
