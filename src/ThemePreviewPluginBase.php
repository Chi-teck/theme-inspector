<?php declare(strict_types = 1);

namespace Drupal\theme_inspector;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Component\Utility\Random;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Base class for theme preview plugins.
 */
abstract class ThemePreviewPluginBase extends PluginBase implements ThemePreviewInterface {

  use StringTranslationTrait;

  private ?Random $random = NULL;

  public function id(): string {
    return $this->getPluginId();
  }

  public function getLabel(): string {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

  public function getCategory(): string {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['category'];
  }

  public function getVariations(): array {
    return $this->pluginDefinition['variations'] ?? ['default' => $this->t('Default')];
  }

  abstract public function build(string $variation): array;

  final protected function random(): Random {
    if (!$this->random) {
      $this->random = new Random();
    }
    return $this->random;
  }

}
