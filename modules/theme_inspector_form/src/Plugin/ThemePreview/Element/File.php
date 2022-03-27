<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview\Element;

/**
 * File input preview.
 *
 * @ThemePreview(
 *   id = "file",
 *   label = @Translation("File"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "disabled" = @Translation("Disabled"),
 *   },
 * )
 */
final class File extends FormElementBase {

  protected function getElement(string $variation): array {
    return [
      '#title' => $this->random()->title(),
      '#type' => 'file',
      '#description' => $this->random()->sentences(1),
      '#disabled' => $variation === 'disabled',
    ];
  }

}
