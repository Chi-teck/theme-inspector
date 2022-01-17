<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview;

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

  protected function getElement(string $variation_id): array {
    return [
      '#title' => \ucfirst($this->random()->name()),
      '#type' => 'datetime',
      '#description' => $this->random()->sentences(1),
      '#disabled' => $variation_id === 'disabled',
    ];
  }

}
