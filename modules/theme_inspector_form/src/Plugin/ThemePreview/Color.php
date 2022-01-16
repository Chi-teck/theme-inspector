<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview;

/**
 * Color input preview.
 *
 * @ThemePreview(
 *   id = "color",
 *   label = @Translation("Color"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "disabled" = @Translation("Disabled"),
 *   },
 * )
 */
final class Color extends FormElementBase {

  protected function getElement(string $variation_id): array {
    return [
      '#type' => 'color',
      '#description' => 'Example of color field.',
    ];
  }

}
