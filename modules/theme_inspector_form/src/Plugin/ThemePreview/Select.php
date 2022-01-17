<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview;

/**
 * Select element preview.
 *
 * @ThemePreview(
 *   id = "select",
 *   label = @Translation("Select"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "single" = @Translation("Single"),
 *     "multiple" = @Translation("Multiple"),
 *     "singe_disabled" = @Translation("Singe (disabled)"),
 *     "multiple_disabled" = @Translation("Multiple (disabled)"),
 *   },
 * )
 */
final class Select extends FormElementBase {

  protected function getElement(string $variation_id): array {
    return [
      '#title' => \ucfirst($this->random()->name()),
      '#type' => 'select',
      '#description' => $this->random()->sentences(1),
      '#options' => [
        'alpha' => 'Alpha',
        'beta' => 'Beta',
        'gamma' => 'Gamma',
      ],
      '#disabled' => \str_contains($variation_id, 'disabled'),
      '#multiple' => \str_contains($variation_id, 'multiple'),
    ];
  }

}
