<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview\Navigation;

use Drupal\Core\Link;
use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * Breadcrumbs preview.
 *
 * @ThemePreview(
 *   id = "breadcrumbs",
 *   label = @Translation("Breadcrumbs"),
 *   category = @Translation("Navigation"),
 * )
 */
final class Breadcrumbs extends ThemePreviewPluginBase {

  public function build(string $variation): array {
    return [
      '#theme' => 'breadcrumb',
      '#links' => [
        Link::createFromRoute('Home', '<current>'),
        Link::createFromRoute('Lorem ipsum', '<current>'),
        Link::createFromRoute('Dolor sit amet', '<current>'),
        Link::createFromRoute('Adipiscing', '<current>'),
      ],
    ];
  }

}
