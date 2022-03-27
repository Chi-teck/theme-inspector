<?php declare(strict_types = 1);

namespace Drupal\theme_inspector;

use Drupal\Core\Extension\Extension;
use Drupal\Core\Extension\ThemeHandlerInterface;

/**
 * Gets theme preview definitions from installed themes.
 */
final class ThemeDefinitionDiscovery {

  private const HOOK = 'theme_preview_info';

  public function __construct(private ThemeHandlerInterface $themeHandler) {}

  public function getDefinitions(): array {
    $definitions = [];
    foreach ($this->themeHandler->listInfo() as $theme) {
      $definitions += $this->getThemeDefinitions($theme);
    }
    return $definitions;
  }

  private function getThemeDefinitions(Extension $theme): array {
    $function = $theme->getName() . '_' . self::HOOK;
    $theme->load();
    if (\function_exists($function)) {
      $add_theme = static fn(array $definition): array => $definition + ['theme' => $theme->getName()];
      return \array_map($add_theme, $function());
    }
    return [];
  }

}
