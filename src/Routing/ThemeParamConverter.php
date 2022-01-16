<?php declare(strict_types = 1);

namespace Drupal\theme_inspector\Routing;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\Exception\UnknownExtensionException;
use Drupal\Core\Extension\Extension;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\Core\ParamConverter\ParamConverterInterface;
use Symfony\Component\Routing\Route;

/**
 * A convertor for 'theme' parameter.
 */
final class ThemeParamConverter implements ParamConverterInterface {

  public function __construct(
    private ConfigFactoryInterface $configFactory,
    private ThemeHandlerInterface $themeHandler,
  ) {}

  public function convert($value, $definition, $name, array $defaults): ?Extension {
    $theme_name = $value ?: $this->configFactory->get('system.theme')->get('default');
    try {
      return $this->themeHandler->getTheme($theme_name);
    }
    catch (UnknownExtensionException) {
      return NULL;
    }
  }

  public function applies($definition, $name, Route $route): bool {
    return ($definition['type'] ?? NULL) && $definition['type'] === 'ti_theme';
  }

}
