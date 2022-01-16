<?php declare(strict_types = 1);

namespace Drupal\theme_inspector\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides dynamic tabs based on active theme.
 */
final class ThemeInspectorLocalTask extends DeriverBase implements ContainerDeriverInterface {

  public function __construct(
    private ThemeHandlerInterface $themeHandler,
    private ConfigFactoryInterface $configFactory,
  ) {}

  public static function create(ContainerInterface $container, $base_plugin_id): self {
    return new self(
      $container->get('theme_handler'),
      $container->get('config.factory'),
    );
  }

  public function getDerivativeDefinitions($base_plugin_definition): array {
    $default_theme = $this->configFactory->get('system.theme')->get('default');
    foreach ($this->themeHandler->listInfo() as $theme_name => $theme) {
      $this->derivatives[$theme_name] = $base_plugin_definition;
      $this->derivatives[$theme_name]['title'] = $theme->info['name'];
      if ($default_theme === $theme->getName()) {
        $this->derivatives[$theme_name]['route_name'] = 'theme_inspector.overview';
        $this->derivatives[$theme_name]['weight'] = -100;
      }
      else {
        $this->derivatives[$theme_name]['route_parameters']['theme'] = $theme_name;
      }
    }
    return $this->derivatives;
  }

}
