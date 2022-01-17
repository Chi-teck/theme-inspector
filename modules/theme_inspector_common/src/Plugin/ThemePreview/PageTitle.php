<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview;

use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * A preview plugin for page title.
 *
 * @ThemePreview(
 *   id = "page_title",
 *   label = @Translation("Page Title"),
 *   category = @Translation("Common"),
 * )
 */
final class PageTitle extends ThemePreviewPluginBase {

  public function build(string $variation): array {
    return [
      '#type' => 'page_title',
      '#title' => 'Example',
    ];
  }

}
