<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview;

/**
 * Checkbox preview.
 *
 * @ThemePreview(
 *   id = "checkbox",
 *   label = @Translation("Checkbox"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "disabled" = @Translation("Disabled"),
 *   },
 * )
 */
final class Checkbox extends FormElementBase {

  protected function getElement(string $variation_id): array {
    return [
      '#type' => 'checkbox',
      '#description' => 'Example of checkbox.',
    ];
  }

}
