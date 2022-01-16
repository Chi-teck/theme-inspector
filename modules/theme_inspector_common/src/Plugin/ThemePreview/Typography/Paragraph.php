<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview\Typography;

use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * A preview plugin for HTML paragraphs.
 *
 * @ThemePreview(
 *   id = "paragraph",
 *   label = @Translation("Paragraph"),
 *   category = @Translation("Typography"),
 * )
 */
final class Paragraph extends ThemePreviewPluginBase {

  public function build(string $variation_id): array {
    $markup = '';
    for ($i = 1; $i <= 5; $i++) {
      $markup .= '<p>' . $this->random()->paragraphs(1) . '</p>';
    }
    return ['#markup' => $markup];
  }

}
