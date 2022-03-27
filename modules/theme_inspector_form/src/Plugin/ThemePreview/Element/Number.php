<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview\Element;

/**
 * Number input preview.
 *
 * @ThemePreview(
 *   id = "number",
 *   label = @Translation("Number"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "disabled" = @Translation("Disabled"),
 *   },
 * )
 */
final class Number extends FormElementBase {

  protected function getElement(string $variation): array {
    return [
      '#title' => $this->random()->title(),
      '#type' => 'number',
      '#description' => $this->random()->sentences(1),
      '#disabled' => $variation === 'disabled',
    ];
  }

}
