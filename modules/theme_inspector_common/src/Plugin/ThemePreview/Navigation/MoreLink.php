<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview\Navigation;

use Drupal\Core\Url;
use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * A preview plugin for "More link".
 *
 * @ThemePreview(
 *   id = "more_link",
 *   label = @Translation("More Link"),
 *   category = @Translation("Navigation"),
 * )
 */
final class MoreLink extends ThemePreviewPluginBase {

  public function build(string $variation): array {
    return [
      '#title' => 'Read more',
      '#type' => 'more_link',
      '#url' => Url::fromRoute('<current>'),
    ];
  }

}
