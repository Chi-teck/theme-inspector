<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview\Element;

/**
 * Fieldset input preview.
 *
 * @ThemePreview(
 *   id = "fieldset",
 *   label = @Translation("Fieldset"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "disabled" = @Translation("Disabled"),
 *   },
 * )
 */
final class Fieldset extends FormElementBase {

  protected function getElement(string $variation): array {
    return [
      '#type' => 'fieldset',
      '#title' => 'Author',
      '#disabled' => $variation === 'disabled',
      'first_name' => [
        '#type' => 'textfield',
        '#title' => 'First name',
      ],
      'last_name' => [
        '#type' => 'textfield',
        '#title' => 'Last name',
      ],
    ];
  }

}
