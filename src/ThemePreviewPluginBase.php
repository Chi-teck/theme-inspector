<?php declare(strict_types = 1);

namespace Drupal\theme_inspector;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\theme_inspector\Utility\Random;

/**
 * Base class for theme preview plugins.
 */
abstract class ThemePreviewPluginBase extends PluginBase implements ThemePreviewInterface {

  use StringTranslationTrait;

  private ?Random $random = NULL;

  abstract public function build(string $variation): array;

  final protected function random(): Random {
    if (!$this->random) {
      $this->random = new Random();
    }
    return $this->random;
  }

}
