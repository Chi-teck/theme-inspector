<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview;

/**
 * URL input preview.
 *
 * @ThemePreview(
 *   id = "url",
 *   label = @Translation("URL"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "disabled" = @Translation("Disabled"),
 *   },
 * )
 */
final class Url extends FormElementBase {

  protected function getElement(string $variation_id): array {
    return [
      '#type' => 'url',
      '#description' => 'Example of URL.',
    ];
  }

}
