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
 *     "single" = @Translation("Single"),
 *     "multiple" = @Translation("Multiple"),
 *     "singe_disabled" = @Translation("Singe (disabled)"),
 *     "multiple_disabled" = @Translation("Multiple (disabled)"),
 *   },
 * )
 */
final class Checkbox extends FormElementBase {

  protected function getElement(string $variation): array {
    if ($variation === 'single' || $variation === 'singe_disabled') {
      $element = [
        '#type' => 'checkbox',
        '#description' => 'Example of checkbox.',
        '#disabled' => $variation === 'singe_disabled',
      ];
    }
    else {
      $element = [
        '#type' => 'checkboxes',
        '#description' => 'Example of checkboxes.',
        '#disabled' => $variation === 'multiple_disabled',
        '#options' => [
          $this->random()->sentences(1),
          $this->random()->sentences(1),
          $this->random()->sentences(1),
          $this->random()->sentences(1),
          $this->random()->sentences(1),
        ],
      ];
    }
    return $element;
  }

}
