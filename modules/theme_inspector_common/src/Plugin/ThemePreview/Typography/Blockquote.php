<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview\Typography;

use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * Blockquote preview.
 *
 * @ThemePreview(
 *   id = "blockquote",
 *   label = @Translation("Blockquote"),
 *   category = @Translation("Typography"),
 * )
 */
final class Blockquote extends ThemePreviewPluginBase {

  public function build(string $variation_id): array {
    $markup = $this->random()->paragraphs(1);
    $markup .= '<blockquote>' . $this->random()->paragraphs(1) . '</blockquote>';
    $markup .= $this->random()->paragraphs(1);
    return ['#markup' => $markup];
  }

}
