<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview;

use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * Details preview.
 *
 * @ThemePreview(
 *   id = "details",
 *   label = @Translation("Details"),
 *   category = @Translation("Common"),
 * )
 */
final class Details extends ThemePreviewPluginBase {

  public function build(string $variation): array {
    return [
      '#type' => 'details',
      '#title' => 'Example',
      '#open' => TRUE,
      'content' => [
        '#markup' => $this->random()->sentences(25),
      ],
    ];
  }

}
