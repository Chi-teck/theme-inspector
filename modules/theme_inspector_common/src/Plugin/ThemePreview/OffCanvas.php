<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview;

use Drupal\Core\Url;
use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * Off-canvas preview.
 *
 * @ThemePreview(
 *   id = "off_canvas",
 *   label = @Translation("Off-canvas"),
 *   category = @Translation("Common"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "top" = @Translation("Top"),
 *   },
 * )
 */
final class OffCanvas extends ThemePreviewPluginBase {

  public function build(string $variation): array {
    $options['query']['destination'] = self::getCurrentUrl($variation)->toString();
    return [
      '#type' => 'link',
      '#title' => 'Open the off-canvas dialog',
      '#url' => Url::fromRoute('theme_inspector.example_form', options: $options),
      '#options' => [
        'attributes' => [
          'class' => ['use-ajax'],
          'data-dialog-type' => 'dialog',
          'data-dialog-renderer' => match($variation) {
            'default' => 'off_canvas',
            // @phpcs:disable Squiz.Arrays.ArrayDeclaration.NoKeySpecified
            'top' => 'off_canvas_top',
          },
        ],
      ],
      '#attached' => ['library' => ['core/drupal.dialog.ajax']],
    ];
  }

}
