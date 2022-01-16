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
 *     "default" = @Translation("Default"),
 *     "disabled" = @Translation("Disabled"),
 *     "multiple" = @Translation("Multiple"),
 *   },
 * )
 */
final class Select extends FormElementBase {

  protected function getElement(string $variation_id): array {
    return [
      '#type' => 'select',
      '#description' => 'Example of select element.',
      '#options' => [
        'alpha' => 'Alpha',
        'beta' => 'Beta',
        'gamma' => 'Gamma',
      ],
      '#multiple' => $variation_id === 'multiple',
    ];
  }

}
