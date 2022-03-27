<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview\Element;

/**
 * Managed file input preview.
 *
 * @ThemePreview(
 *   id = "managed_file",
 *   label = @Translation("Managed file"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "disabled" = @Translation("Disabled"),
 *   },
 * )
 */
final class ManagedFile extends FormElementBase {

  protected function getElement(string $variation): array {
    return [
      '#title' => $this->random()->title(),
      '#type' => 'managed_file',
      '#description' => $this->random()->sentences(1),
      '#disabled' => $variation === 'disabled',
    ];
  }

}
