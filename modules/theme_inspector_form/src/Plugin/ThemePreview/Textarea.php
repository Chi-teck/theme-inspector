<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview;

/**
 * Textarea preview plugin.
 *
 * @ThemePreview(
 *   id = "textarea",
 *   label = @Translation("Textarea"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "disabled" = @Translation("Disabled"),
 *   },
 * )
 */
final class Textarea extends FormElementBase {

  protected function getElement(string $variation_id): array {
    return [
      '#title' => 'Example',
      '#type' => 'textarea',
      '#description' => $this->random()->sentences(1),
    ];
  }

}
