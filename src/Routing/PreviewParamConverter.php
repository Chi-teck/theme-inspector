<?php declare(strict_types = 1);

namespace Drupal\theme_inspector\Routing;

use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\ParamConverter\ParamConverterInterface;
use Drupal\theme_inspector\ThemePreviewInterface;
use Drupal\theme_inspector\ThemePreviewPluginManager;
use Symfony\Component\Routing\Route;

/**
 * A convertor for 'preview' parameter.
 */
final class PreviewParamConverter implements ParamConverterInterface {

  public function __construct(
    private ThemePreviewPluginManager $pluginManager,
  ) {}

  public function convert($value, $definition, $name, array $defaults): ?ThemePreviewInterface {
    try {
      return $this->pluginManager->createInstance($value);
    }
    catch (PluginNotFoundException) {
      return NULL;
    }
  }

  public function applies($definition, $name, Route $route): bool {
    return ($definition['type'] ?? NULL) === 'ti_preview';
  }

}
