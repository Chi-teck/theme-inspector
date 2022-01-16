<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview;

/**
 * Textfield preview.
 *
 * @ThemePreview(
 *   id = "textfield",
 *   label = @Translation("Textfield"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "disabled" = @Translation("Disabled"),
 *   },
 * )
 */
final class Textfield extends FormElementBase {

  protected function getElement(string $variation_id): array {
    return [
      '#type' => 'textfield',
      '#description' => 'Example of textfield.',
    ];
  }

}
