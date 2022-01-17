<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview\Navigation;

use Drupal\Core\Url;
use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * Drop button preview.
 *
 * @ThemePreview(
 *   id = "dropbutton",
 *   label = @Translation("Dropbutton"),
 *   category = @Translation("Navigation"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "small" = @Translation("Small"),
 *     "extra_small" = @Translation("Extra small"),
 *   }
 * )
 */
final class Dropbutton extends ThemePreviewPluginBase {

  public function build(string $variation): array {

    $url = Url::fromRoute('<current>');
    $create_link = static fn (int $key): array
      => ['title' => 'Option #' . $key, 'url' => $url];

    return [
      '#type' => 'dropbutton',
      '#dropbutton_type' => match ($variation) {
        'default' => NULL,
        // @todo Drop this once PHPCS is updated to 3.7.0
        // @see https://github.com/squizlabs/PHP_CodeSniffer/issues/3502
        // phpcs:ignore Squiz.Arrays.ArrayDeclaration.NoKeySpecified
        'extra_small' => 'extrasmall',
        default => $variation,
      },
      '#links' => \array_map($create_link, \range(1, 5)),
    ];
  }

}
