<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview;

/**
 * Telephone input preview.
 *
 * @ThemePreview(
 *   id = "telephone",
 *   label = @Translation("Telephone"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "disabled" = @Translation("Disabled"),
 *   },
 * )
 */
final class Telephone extends FormElementBase {

  protected function getElement(string $variation_id): array {
    return [
      '#title' => \ucfirst($this->random()->name()),
      '#type' => 'tel',
      '#description' => $this->random()->sentences(1),
      '#disabled' => $variation_id === 'disabled',
    ];
  }

}
