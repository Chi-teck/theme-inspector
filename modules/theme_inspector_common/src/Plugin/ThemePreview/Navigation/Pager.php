<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview\Navigation;

use Drupal\Core\Pager\PagerManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\theme_inspector\ThemePreviewPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Pager preview.
 *
 * @ThemePreview(
 *   id = "pager",
 *   label = @Translation("Pager"),
 *   category = @Translation("Navigation"),
 * )
 */
final class Pager extends ThemePreviewPluginBase implements ContainerFactoryPluginInterface {

  public function __construct(array $configuration, $plugin_id, $plugin_definition, private PagerManagerInterface $pagerManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new self(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('pager.manager'),
    );
  }

  public function build(string $variation): array {
    $this->pagerManager->createPager(250, 10)->getCurrentPage();
    return ['#type' => 'pager'];
  }

}
