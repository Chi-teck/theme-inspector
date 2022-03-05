<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview;

use Drupal\Core\Url;
use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * Dialog preview.
 *
 * @ThemePreview(
 *   id = "dialog",
 *   label = @Translation("Dialog"),
 *   category = @Translation("Common"),
 *   variations = {
 *     "dialog" = @Translation("Simple"),
 *     "modal" = @Translation("Modal"),
 *   },
 * )
 */
final class Dialog extends ThemePreviewPluginBase {

  public function build(string $variation): array {
    $options['query']['destination'] = self::getCurrentUrl($variation)->toString();
    return [
      '#type' => 'link',
      '#title' => 'Open the dialog',
      '#url' => Url::fromRoute('theme_inspector.example_form', options: $options),
      '#options' => [
        'attributes' => [
          'class' => ['use-ajax'],
          'data-dialog-type' => $variation,
        ],
      ],
      '#attached' => ['library' => ['core/drupal.dialog.ajax']],
    ];
  }

}
