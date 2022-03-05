<?php declare(strict_types = 1);

namespace Drupal\theme_inspector\Annotation;

use Drupal\Component\Annotation\Plugin;
use Drupal\Core\Annotation\Translation;

/**
 * Defines ThemePreview annotation object.
 *
 * @Annotation
 */
final class ThemePreview extends Plugin {

  /**
   * The plugin ID.
   */
  readonly public string $id;

  /**
   * The human-readable name of the plugin.
   */
  readonly public Translation $label;

  /**
   * The preview category.
   */
  readonly public Translation $category;

  /**
   * The preview variations.
   */
  readonly public array $variations;

}
