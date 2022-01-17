<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview;

/**
 * Buttons preview.
 *
 * @ThemePreview(
 *   id = "button",
 *   label = @Translation("Button"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "primary" = @Translation("Primary"),
 *     "secondary" = @Translation("Secondary"),
 *     "danger" = @Translation("Danger"),
 *   },
 * )
 */
final class Button extends FormElementBase {

  protected function getElement(string $variation_id): array {

    $actions_attributes = ['style' => 'display: flex; gap: 1em; margin-bottom: 1em;'];

    $element['primary'] = [
      '#type' => 'actions',
      '#attributes' => $actions_attributes,
      '#access' => $variation_id === 'primary',
    ];
    $element['primary']['default'] = [
      '#type' => 'button',
      '#value' => 'Primary',
      '#button_type' => 'primary',
    ];
    $element['primary']['disabled'] = [
      '#type' => 'button',
      '#value' => 'Primary disabled',
      '#button_type' => 'primary',
      '#disabled' => TRUE,
    ];

    $element['secondary'] = [
      '#type' => 'actions',
      '#attributes' => $actions_attributes,
      '#access' => $variation_id === 'secondary',
    ];
    $element['secondary']['default'] = [
      '#type' => 'button',
      '#value' => 'Secondary',
      '#button_type' => 'secondary',
    ];
    $element['secondary']['disabled'] = [
      '#type' => 'button',
      '#value' => 'Secondary disabled',
      '#button_type' => 'secondary',
      '#disabled' => TRUE,
    ];

    $element['danger'] = [
      '#type' => 'actions',
      '#attributes' => $actions_attributes,
      '#access' => $variation_id === 'danger',
    ];
    $element['danger']['default'] = [
      '#type' => 'button',
      '#value' => 'Danger',
      '#button_type' => 'danger',
    ];
    $element['danger']['disabled'] = [
      '#type' => 'button',
      '#value' => 'Danger disabled',
      '#button_type' => 'danger',
      '#disabled' => TRUE,
    ];

    return $element;
  }

}
