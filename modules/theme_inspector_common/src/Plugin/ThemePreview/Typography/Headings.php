<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview\Typography;

use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * Headings preview.
 *
 * @ThemePreview(
 *   id = "headings",
 *   label = @Translation("Headings"),
 *   category = @Translation("Typography"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "with_text" = @Translation("With text"),
 *   },
 * )
 */
final class Headings extends ThemePreviewPluginBase {

  public function build(string $variation_id): array {
    $markup = '';
    for ($level = 1; $level <= 6; $level++) {
      $markup .= \sprintf('<h%d role="presentation">H%d. heading</h%d>', $level, $level, $level);
      if ($variation_id === 'with_text') {
        $markup .= $this->random()->paragraphs(1);
      }
    }
    return ['#markup' => $markup];
  }

}
