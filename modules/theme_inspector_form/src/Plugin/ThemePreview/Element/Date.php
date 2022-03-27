<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview\Element;

/**
 * Date input preview.
 *
 * @ThemePreview(
 *   id = "date",
 *   label = @Translation("Date"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "disabled" = @Translation("Disabled"),
 *   },
 * )
 */
final class Date extends FormElementBase {

  protected function getElement(string $variation): array {
    return [
      '#title' => $this->random()->title(),
      '#type' => 'date',
      '#description' => $this->random()->sentences(1),
      '#disabled' => $variation === 'disabled',
    ];
  }

}
