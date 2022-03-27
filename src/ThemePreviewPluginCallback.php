<?php declare(strict_types = 1);

namespace Drupal\theme_inspector;

use Drupal\Core\Extension\ThemeHandlerInterface;

/**
 * Defines theme preview plugin class that invokes callback function.
 */
final class ThemePreviewPluginCallback extends ThemePreviewPluginBase {

  public function build(string $variation): array {
    ['theme' => $theme, 'callback' => $callback] = $this->getPluginDefinition();
    self::getThemeHandler()->getTheme($theme)->load();
    return $callback($variation);
  }

  private static function getThemeHandler(): ThemeHandlerInterface {
    return \Drupal::service('theme_handler');
  }

}
