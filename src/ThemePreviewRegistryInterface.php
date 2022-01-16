<?php declare(strict_types = 1);

namespace Drupal\theme_inspector;

use Drupal\Core\Extension\Extension;

/**
 * Interface fot Theme Preview plugin manager.
 */
interface ThemePreviewRegistryInterface {

  /**
   * Builds a tree of preview definitions.
   *
   * Returns an associative array of preview definitions keyed by preview
   * category.
   */
  public function buildGroupedRegistry(Extension $theme): array;

  /**
   * Builds a registry of preview definitions.
   */
  public function buildRegistry(Extension $theme): array;

}
