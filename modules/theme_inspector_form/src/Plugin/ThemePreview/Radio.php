<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview;

/**
 * Radio button preview.
 *
 * @ThemePreview(
 *   id = "radio",
 *   label = @Translation("Radio Button"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "single" = @Translation("Single"),
 *     "multiple" = @Translation("Multiple"),
 *     "singe_disabled" = @Translation("Singe (disabled)"),
 *     "multiple_disabled" = @Translation("Multiple (disabled)"),
 *   },
 * )
 */
final class Radio extends FormElementBase {

  protected function getElement(string $variation_id): array {
    if ($variation_id === 'single' || $variation_id === 'singe_disabled') {
      $element = [
        '#title' => \ucfirst($this->random()->name()),
        '#type' => 'radio',
        '#description' => 'Example of radio button.',
        '#disabled' => $variation_id === 'singe_disabled',
      ];
    }
    else {
      $element = [
        '#title' => \ucfirst($this->random()->name()),
        '#type' => 'radios',
        '#description' => 'Example of radio buttons.',
        '#disabled' => $variation_id === 'multiple_disabled',
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
