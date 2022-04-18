<?php declare(strict_types = 1);

namespace Drupal\theme_inspector\Controller;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Extension\Extension;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\theme_inspector\ThemePreviewPluginManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns a response for TI overview page.
 */
final class OverviewController implements ContainerInjectionInterface {

  use StringTranslationTrait;

  public function __construct(
    private ThemePreviewPluginManager $pluginManager,
    private ConfigFactoryInterface $configFactory
  ) {}

  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('plugin.manager.theme_preview'),
      $container->get('config.factory'),
    );
  }

  public function __invoke(Extension $theme): array {
    $settings['themeInspector'] = [
      'loadPrevious' => $this->configFactory->get('theme_inspector.settings')->get('load_previous'),
      'previews' => $this->pluginManager->buildRegistry($theme),
    ];
    return [
      '#title' => $this->t('@theme components', ['@theme' => $theme->info['name']]),
      '#theme' => 'theme_inspector_overview',
      '#preview_tree' => $this->pluginManager->buildGroupedRegistry($theme),
      '#theme_name' => $theme->getName(),
      '#attached' => ['drupalSettings' => $settings],
    ];
  }

}
