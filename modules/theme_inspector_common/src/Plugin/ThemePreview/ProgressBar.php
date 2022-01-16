<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview;

use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * Progress bar preview.
 *
 * @ThemePreview(
 *   id = "progress_bar",
 *   label = @Translation("Progress Bar"),
 *   category = @Translation("Common"),
 *   variations = {
 *     "slow" = @Translation("Slow"),
 *     "fast" = @Translation("Fast"),
 *   }
 * )
 */
final class ProgressBar extends ThemePreviewPluginBase {

  public function build(string $variation_id): array {
    return [
      '#markup' => '<div data-ti-progress-bar></div>',
      '#attached' => [
        'library' => ['theme_inspector_common/progress_bar'],
        'drupalSettings' => [
          'themeInspector' => [
            'progressBarTimeout' => $variation_id === 'slow' ? 500 : 100,
          ],
        ],
      ],
    ];
  }

}
